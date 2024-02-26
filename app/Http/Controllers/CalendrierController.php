<?php

namespace App\Http\Controllers;

use App\Models\PanneauSolaire;
use App\Models\Delestage;
use App\Models\Groupe;
use App\Models\Sites;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendrierController extends Controller
{
    public function listeCalendrier(){
        $liste = DB::table('v_calendrier')->where('etatcalendrier', '=', 0)
            ->where('etatdiscipline', '=', 0)
            ->where('etatsite', '=', 0)
            ->paginate(5);
        $listeDiscipline = Groupe::where('etatdiscipline', 0)->get();
        $listeSites = Sites::where('etatsite', 0)->get();
        return view('employe.calendrier.listeCalendrier', [
            'liste' => $liste,
            'listeDiscipline' => $listeDiscipline,
            'listeSites' => $listeSites,
        ]);
    }
    public function chargeInsertCalendrier(){
        $listeDiscipline = Groupe::where('etatdiscipline', 0)->get();
        $listeSites = Sites::where('etatsite', 0)->get();
        return view('employe.calendrier.insertCalendrier',[
            'listeDiscipline' => $listeDiscipline,
            'listeSites' => $listeSites,
        ]);
    }
    public function insertCalendrier(Request $request){
        $calendrier = new Delestage();
        $calendrier->iddiscipline = $request->iddiscipline;
        $calendrier->idsite = $request->idsite;
        $calendrier->datecalendrier = $request->datecalendrier;
        $calendrier->save();
        return redirect()->route('listeCalendrier')->with('message', 'Programme enregistré !');
    }

    public function updateCalendrier($idcalendrier, Request $request){
        $datecalendrier = $request->datecalendrier;
        $iddiscipline = $request->iddiscipline;
        $idsite = $request->idsite;
        Delestage::where('idcalendrier', $idcalendrier)
            ->update([
                'datecalendrier'=>$datecalendrier,
                'iddiscipline'=>$iddiscipline,
                'idsite'=>$idsite,
            ]);
        return redirect()->route('listeCalendrier')->with('message', 'Programme modifié');
    }
    public function deleteCalendrier($idcalendrier){
        $etat = 1;
        Delestage::where('idcalendrier', $idcalendrier)
            ->update(['etat'=> $etat]);
        return redirect()->route('listeCalendrier')->with('message', 'Programme annulé');
    }

    public function calendrierUser(Request $request){
        $liste1 = DB::table('v_calendrier')->where('etatcalendrier', '=', 0)
            ->where('etatdiscipline', '=', 0)
            ->where('etatsite', '=', 0)
            ->orderBy('datecalendrier');
        $listeDiscipline = Groupe::where('etatdiscipline', 0)->get();
        if ($request->filled('iddiscipline')) {
            $liste1->where('iddiscipline', $request->iddiscipline);
        }
        $date = $request->filled('date_debut') ? $request->date_debut : $request->date_fin;
        // Si les deux dates sont fournies, recherche par intervalle
        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $liste1->whereBetween('datecalendrier', [$request->date_debut, $request->date_fin]);
        }
        // Sinon, recherche par date unique si date_debut est fournie
        elseif ($date) {
            $liste1->whereDate('datecalendrier', '=', $date);
        }

        $liste = $liste1->get();

        return view('calendrier', [
            'liste' => $liste,
            'listeDiscipline' => $listeDiscipline,
        ]);
    }
    public function pdfGeneration(){
        $liste = DB::table('v_calendrier')->where('etatcalendrier', '=', 0)
            ->where('etatdiscipline', '=', 0)
            ->where('etatsite', '=', 0)
            ->get();

//        $imagePath = public_path('uploads/highlights/' . $img);

        //$html = view('employe.devis.pdf.pdf', compact('titre', 'lieu', 'img', 'datedeb'))->render();
        $data = [
            'liste'=>$liste,
        ];
////        $html = view('employe.devis.pdf.pdf', compact('titre', 'lieu', 'img', 'datedeb'))->render();
//
//        $dompdf = new Dompdf();
//        $dompdf->loadHtml($html);
//        $dompdf->setPaper('A4', 'portrait');
//        $dompdf->render();
        $pdf = Pdf::loadView('pdf.calendrier', $data);
        return $pdf->download('calendrier.pdf');
    }
}

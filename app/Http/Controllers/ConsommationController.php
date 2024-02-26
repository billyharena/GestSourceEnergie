<?php

namespace App\Http\Controllers;

use App\Models\Consommation;
use App\Models\Groupe;
use Illuminate\Http\Request;

class ConsommationController extends Controller
{
    public function listConsommation(){
        $listeConsommation = Consommation::all();
        $listeC = Consommation::getConsommation();
        $totalC = Consommation::totalConsommation();

        return view('admin.Consommation.listeConsommation',[
            'liste' => $listeConsommation,
            'tauxHoraire' => $listeC,
            'total' => $totalC,
        ]);
    }

    public function insertConsommation(Request $request){
        if ($request->nbetudiant < 0 || $request->puissancelaptop < 0 || $request->consofixe < 0 || $request->pourcentage < 0)
            return redirect()->route('listeConsommation')->with('message', 'Veillez entrer que des valeurs positives');
        else
        {
            $consommation = new Consommation();
            $consommation->nbetudiant = $request->nbetudiant;
            $consommation->puissancelaptop = $request->puissancelaptop;
            $consommation->consofixe = $request->consofixe;
            $consommation->pourcentage = $request->pourcentage;
            $consommation->save();
            return redirect()->route('listeConsommation')->with('message', 'Consommation insérée');
        }
    }
    public function updateConsommation($idconsommation, Request $request){
        $nbetudiant = $request->nbetudiant;
        $puissancelaptop = $request->puissancelaptop;
        $consofixe = $request->consofixe;
        $pourcentage = $request->pourcentage;
        if ($nbetudiant < 0 || $puissancelaptop < 0 || $consofixe < 0 || $pourcentage < 0)
            return redirect()->route('listeConsommation')->with('message', 'Veillez entrer que des valeurs positives');
        else
        {
            Consommation::where('idconsommation', $idconsommation)
                ->update([
                    'nbetudiant'=>$nbetudiant,
                    'puissancelaptop'=>$puissancelaptop,
                    'consofixe'=>$consofixe,
                    'pourcentage'=>$pourcentage,
                ]);
            return redirect()->route('listeConsommation')->with('message', 'Consommation modifié');
        }
    }

    public function deleteDiscipline($iddiscipline){
        $etat = 1;
        Consommation::where('iddiscipline', $iddiscipline)
            ->update(['etatdiscipline'=> $etat]);
        return redirect()->route('listeDiscipline')->with('message', 'Consommation supprimée');
    }
}

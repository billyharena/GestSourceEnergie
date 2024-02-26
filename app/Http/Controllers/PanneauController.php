<?php

namespace App\Http\Controllers;

use App\Models\PanneauSolaire;
use App\Models\Groupe;
use App\Models\TauxPS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PanneauController extends Controller
{
    public function listPanneau(){
        $listePanneaux = PanneauSolaire::all();
        $listeTaux = TauxPS::all();
        $tauxHoraire = PanneauSolaire::tabProd();
        $total = PanneauSolaire::totalProd();
        return view('admin.Panneau.listePanneau',[
            'liste' => $listePanneaux,
            'listeTaux' => $listeTaux,
            'tauxHoraire' => $tauxHoraire,
            'total' => $total,
        ]);
    }

    public function insertPanneau(Request $request){
        $panneau = new PanneauSolaire();
        $panneau->puissance = $request->puissance;
        $panneau->tarif = $request->tarif;
        $panneau->save();
        TauxPS::create([
            'deb' => 8,
            'fin' => 11,
            'taux' => $request->input(1),
        ]);
        TauxPS::create([
            'deb' => 11,
            'fin' => 14,
            'taux' => $request->input(2),
        ]);
        TauxPS::create([
            'deb' => 14,
            'fin' => 17,
            'taux' => $request->input(3),
        ]);
        return redirect()->route('listePanneaux')->with('message', 'Paramètre bien inséré!');
    }

    public function updatePanneau($idpanneau, Request $request){
        $puissance = $request->puissance;
        $tarif = $request->tarif;
        if ($puissance < 0 || $tarif < 0)
            return redirect()->route('listePanneaux')->with('message', 'Valeurs négatives entrées');
        else
        {
            PanneauSolaire::where('idpanneau', $idpanneau)
                ->update([
                    'puissance'=>$puissance,
                    'tarif'=>$tarif,
                ]);
            $tauxData = $request->input('taux', []);

            foreach ($tauxData as $idTaux => $nouveauTaux) {
                if ($nouveauTaux < 0)
                    return redirect()->route('listePanneaux')->with('message', 'Valeurs négatives entrées');
                else
                {
                    TauxPS::where('idtaux', $idTaux)
                        ->update(['taux' => $nouveauTaux]);
                }
            }
            return redirect()->route('listePanneaux')->with('message', 'Paramètre modifié');
        }
    }
    public function deletePanneau($idpanneau){
        $etat = 1;
        PanneauSolaire::where('idpanneau', $idpanneau)
            ->update(['etatpanneau'=> $etat]);
        return redirect()->route('listePanneaux')->with('message', 'Athlète supprimée');
    }
}

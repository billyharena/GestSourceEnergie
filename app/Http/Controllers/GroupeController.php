<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\PanneauSolaire;
use App\Models\PrixDepense;
use App\Models\TauxPS;
use Illuminate\Http\Request;

class GroupeController extends Controller
{
    public function listGroupe(){
        $listeGroup = Groupe::all();
        $listeProdG = Groupe::productionGroupe();
        $totalProdG = Groupe::totalGroupe();

        return view('admin.Groupe.listeGroupe',[
            'liste' => $listeGroup,
            'tauxHoraire' => $listeProdG,
            'total' => $totalProdG,
        ]);
    }

    public function insertGroupe(Request $request){
        $groupe = new Groupe();
        $groupe->capacitemax = $request->capacitemax;
        $groupe->reservoir = $request->reservoir;
        $groupe->consommation = $request->consommation;
        $groupe->prixlitre = $request->prixlitre;
        $groupe->save();
        return redirect()->route('listeGroupe')->with('message', 'Groupe insérée');
    }
    public function updateGroupe($idgroupe, Request $request){
        $capacitemax = $request->capacitemax;
        $reservoir = $request->reservoir;
        $consommation = $request->consommation;
        $prixlitre = $request->prixlitre;
        $deb = $request->deb;
        if ($capacitemax < 0 || $reservoir < 0 || $consommation < 0 || $prixlitre < 0 || $deb < 0)
            return redirect()->route('listeGroupe')->with('message', 'Veillez entrer des valeurs positives');
        else
        {
            Groupe::where('idgroupe', $idgroupe)
                ->update([
                    'capacitemax'=>$capacitemax,
                    'reservoir'=>$reservoir,
                    'consommation'=>$consommation,
                    'prixlitre'=>$prixlitre,
                    'deb'=>$deb,
                ]);
            return redirect()->route('listeGroupe')->with('message', 'Groupe modifié');
        }
    }

    public function deleteDiscipline($iddiscipline){
        $etat = 1;
        Groupe::where('iddiscipline', $iddiscipline)
            ->update(['etatdiscipline'=> $etat]);
        return redirect()->route('listeDiscipline')->with('message', 'Groupe supprimée');
    }
}

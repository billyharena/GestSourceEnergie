<?php

namespace App\Http\Controllers;

use App\Models\Jirama;
use Illuminate\Http\Request;

class JiramaController extends Controller
{
    public function listJirama(){
        $listeJirama = Jirama::all();
        $listeProdJ = Jirama::productionJirama();
        $totalProdJ = Jirama::totalJirama();

        return view('admin.Jirama.listeJirama',[
            'liste' => $listeJirama,
            'tauxHoraire' => $listeProdJ,
            'total' => $totalProdJ,
        ]);
    }

    public function insertJirama(Request $request){
        $jirama = new Jirama();
        $jirama->capacitemax = $request->capacitemax;
        $jirama->tarifjirama = $request->tarifjirama;
        $jirama->save();
        return redirect()->route('listeJirama')->with('message', 'Jirama insérée');
    }
    public function updateJirama($idjirama, Request $request){
        $capacitemax = $request->capacitemax;
        $tarifjirama = $request->tarifjirama;
        if ($capacitemax < 0 || $tarifjirama < 0)
            return redirect()->route('listeJirama')->with('message', 'Veillez entrer des valeurs positives');
        else
        {
            Jirama::where('idjirama', $idjirama)
                ->update([
                    'capacitemax'=>$capacitemax,
                    'tarifjirama'=>$tarifjirama,
                ]);
            return redirect()->route('listeJirama')->with('message', 'Jirama modifié');
        }
    }

    /*public function deleteDiscipline($iddiscipline){
        $etat = 1;
        Jirama::where('iddiscipline', $iddiscipline)
            ->update(['etatdiscipline'=> $etat]);
        return redirect()->route('listeDiscipline')->with('message', 'Jirama supprimée');
    }*/

}

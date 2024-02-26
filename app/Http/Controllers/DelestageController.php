<?php

namespace App\Http\Controllers;

use App\Models\Delestage;
use App\Models\Groupe;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class DelestageController extends Controller
{
    public function listDelestage(){
        $listeDelestage = Delestage::where('etat', 0)->get();

        return view('admin.Delestage.listeDelestage',[
            'liste' => $listeDelestage,
        ]);
    }

    public function insertDelestage(Request $request){
        if ($request->deb < 0 || $request->fin < 0)
            return redirect()->route('listeDelestage')->with('message', 'Veillez entrer que des valeurs positives');
        else
        {
            $delestage = new Delestage();
            $delestage->deb = $request->deb;
            $delestage->fin = $request->fin;
            $delestage->save();
            return redirect()->route('listeDelestage')->with('message', 'Delestage insérée');
        }
    }
    public function updateDelestage($iddelestage, Request $request){
        $deb = $request->deb;
        $fin = $request->fin;
        if ($deb < 0 || $fin < 0)
            return redirect()->route('listeDelestage')->with('message', 'Veillez entrer que des valeurs positives');
        else
        {
            Delestage::where('iddelestage', $iddelestage)
                ->update([
                    'deb'=>$deb,
                    'fin'=>$fin,
                ]);
            return redirect()->route('listeDelestage')->with('message', 'Delestage modifié');
        }
    }


    public function deleteDelestage($iddelestage){
        $etat = 1;
        Delestage::where('iddelestage', $iddelestage)
            ->update(['etat'=> $etat]);
        return redirect()->route('listeDelestage')->with('message', 'Delestage supprimée');
    }

    public function insertAlea2(Request $request){
        if ($request->debgroup)
        {
            if ($request->debjir < 0 || $request->finjir < 0 || $request->debgroup < 0)
                return redirect()->back()->with('message', 'Veillez entrer que des valeurs positives');
            else
            {
                Groupe::where('idgroupe', 1)
                    ->update([
                        'deb'=>$request->debgroup,
                    ]);
                $delestage = new Delestage();
                $delestage->deb = $request->debjir;
                $delestage->fin = $request->finjir;
                $delestage->save();
                return redirect()->back()->with('message', 'Paramètres insérées');
            }
        }
        else
            $grp = Groupe::find(1);
            $debgroup = $grp->deb;
            if ($request->debjir < 0 || $request->finjir < 0 || $request->debgroup < 0)
                return redirect()->back()->with('message', 'Veillez entrer que des valeurs positives');
            else
            {
                Groupe::where('idgroupe', 1)
                    ->update([
                        'deb'=>$debgroup,
                    ]);
                $delestage = new Delestage();
                $delestage->deb = $request->debjir;
                $delestage->fin = $request->finjir;
                $delestage->save();
                return redirect()->back()->with('message', 'Paramètres insérées');
            }
    }
}

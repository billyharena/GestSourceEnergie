<?php

namespace App\Http\Controllers;

use App\Models\Consommation;
use App\Models\Depense;
use App\Models\DetailsDepense;
use App\Models\Jirama;
use App\Models\Groupe;
use App\Models\PanneauSolaire;
use App\Models\TauxPS;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Nette\Schema\ValidationException;
use ConsoleTVs\Charts\Facades\Charts;

class DetailsController extends Controller
{
    /*public function importCSV(Request $request)
    {
        if ($request->hasFile('filecsv')) {
            $file = $request->file('filecsv');
            $dataCSV = file_get_contents($file->getRealPath());
            $lines = explode(PHP_EOL, $dataCSV);
            $code = [];
            $valeur = [];
            foreach ($lines as $line) {
                $data = str_getcsv($line, ';', '"', "\\");
                // Trois éléments au moins
                if (count($data) >= 2) {
                    $code[] = trim($data[0]);
                    $valeur[] = trim($data[1]);
                }
            }
            for ($i = 0; $i < count($code); $i++) {
                if ($type[$i] == 'DEPENSE' || $type[$i] == 'Jirama'){
                    $iddepense = Depense::where('codedepense', $code[$i])->first();
                    $depensedetails = DetailsDepense::create([
                        'datedepense' => $date[$i],
                        'iddepense' => $iddepense->iddepense,
                        'prixdepense' => $prix[$i],
                        'iddiscipline' => $iddiscipline->iddiscipline,
                    ]);
                }
                elseif ($type[$i] == 'RECETTE' || $type[$i] == 'Consommation'){
                    $idrecette = Consommation::where('coderecette', $code[$i])->first();
                    $depensedetails = Jirama::create([
                        'daterecette' => $date[$i],
                        'idrecette' => $idrecette->idrecette,
                        'prixrecette' => $prix[$i],
                        'iddiscipline' => $iddiscipline->iddiscipline,
                    ]);
                }

            }
        }
        return redirect()->route('dashboard')->with('message', 'CSV bien inséré!');
    }*/

    public function importCSV(Request $request)
    {
        try {
            if ($request->hasFile('filecsv')) {
                $file = $request->file('filecsv');
                $dataCSV = file_get_contents($file->getRealPath());
                $lines = explode(PHP_EOL, $dataCSV);
                $errorMessages = [];

                DB::beginTransaction(); // Début de la transaction

                foreach ($lines as $line) {
                    $data = explode(';', $line);

                    if (count($data) !== 2 || !is_numeric($data[1]) || $data[1] < 0) {
                        // Marquer l'erreur dans le tableau, mais ne pas rediriger immédiatement
                        $errorMessages[] = "Erreur à la ligne $line : la valeur n'est pas valide.";
                    } else {
                        // Si pas d'erreur, effectuer l'insertion
                        switch ($data[0]) {
                            case 'GRP1':
                                Groupe::updateOrCreate(['idgroupe' => 1], ['capacitemax' => $data[1]]);
                                break;
                            case 'GRP2':
                                Groupe::updateOrCreate(['idgroupe' => 1], ['reservoir' => $data[1]]);
                                break;
                            case 'GRP3':
                                Groupe::updateOrCreate(['idgroupe' => 1], ['consommation' => $data[1]]);
                                break;
                            case 'GRP4':
                                Groupe::updateOrCreate(['idgroupe' => 1], ['prixlitre' => $data[1]]);
                                break;
                            case 'SOL1':
                                PanneauSolaire::updateOrCreate(['idpanneau' => 1], ['puissance' => $data[1]]);
                                break;
                            case 'SOL2':
                                TauxPS::updateOrCreate(
                                    ['idtaux' => 1],
                                    ['taux' => $data[1],
                                        'deb' => 8,
                                        'fin' => 11]
                                );
                                break;
                            case 'SOL3':
                                TauxPS::updateOrCreate(
                                    ['idtaux' => 2],
                                    ['taux' => $data[1],
                                        'deb' => 11,
                                        'fin' => 14]
                                );
                                break;
                            case 'SOL4':
                                TauxPS::updateOrCreate(
                                    ['idtaux' => 3],
                                    ['taux' => $data[1],
                                        'deb' => 14,
                                        'fin' => 17]
                                );
                                break;
                            case 'SOL5':
                                PanneauSolaire::updateOrCreate(['idpanneau' => 1], ['tarif' => $data[1]]);
                                break;
                            case 'JIR1':
                                Jirama::updateOrCreate(['idjirama' => 1], ['capacitemax' => $data[1]]);
                                break;
                            case 'JIR2':
                                Jirama::updateOrCreate(['idjirama' => 1], ['tarifjirama' => $data[1]]);
                                break;
                            default:
                                $errorMessages[] = "Erreur à la ligne $line : cas non reconnu.";
                                break;
                        }
                    }
                }

                if (!empty($errorMessages)) {
                    // S'il y a des erreurs, lancer une exception pour annuler la transaction
                    throw new \Exception('Erreur lors de l\'importation du CSV');
                }

                DB::commit(); // Validation de la transaction

                // Redirection avec le message de succès
                return redirect()->back()->with('message', 'CSV bien inséré!');
            } else {
                return redirect()->back()->with('message', 'Fichier CSV non trouvé.');
            }
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction et rediriger avec les messages d'erreur
            DB::rollBack();
            return redirect()->back()->with('errorMessages', $errorMessages);
        }
    }


    public function getDetailsProdConso()
    {
        $listeProdG = Groupe::productionGroupe();
        $listeProdJ = Jirama::productionJirama();
        $listeProdP = PanneauSolaire::tabProd();
        $listeConso = Consommation::getConsommation();

        $priceS = PanneauSolaire::getPriceP();
        $priceJ = Jirama::getPriceH();
        $priceG = Groupe::getPriceH();
        $total = $priceG + $priceJ + $priceS;

        $tabProd = [];
        $diffProdCons = [];
        for ($i = 0; $i <= 8; $i++)
        {
            if ($listeProdP)
            {
                $tabProd[$i] = $listeProdG[$i] + $listeProdP[$i] + $listeProdJ[$i];
                $diffProdCons[$i] = $tabProd[$i] - $listeConso[$i];
            }
            else
            {
                $tabProd[$i] = 0;
                $diffProdCons[$i] = 0;
            }
        }
        return view('admin.Details.detailsProdConso',[
            'tabProd' => $tabProd,
            'listeConso' => $listeConso,
            'diffProdCons' => $diffProdCons,
            'priceS' => $priceS,
            'priceJ' => $priceJ,
            'priceG' => $priceG,
            'total' => $total,
        ]);
    }
    public function getDetailsProdPrice()
    {
        $listeProdG = Groupe::getUtilisation();
        $listeProdJ = Jirama::getUtilisation();
        $listeProdP = PanneauSolaire::getUtilisation();

        $priceS = PanneauSolaire::getPriceP();
        $priceJ = Jirama::getPriceH();
        $priceG = Groupe::getPriceH();
        $total = $priceG + $priceJ + $priceS;

        $tabProd = [];
        for ($i = 0; $i <= 8; $i++)
        {
            if ($listeProdP)
            {
                $tabProd[$i] = $listeProdG[$i] + $listeProdP[$i] + $listeProdJ[$i];
            }
            else
            {
                $tabProd[$i] = 0;
            }
        }
        return view('admin.Details.totalprice',[
            'tabProd' => $tabProd,
            'priceS' => $priceS,
            'priceJ' => $priceJ,
            'priceG' => $priceG,
            'total' => $total,
            'listeS' => $listeProdP,
            'listeG' => $listeProdG,
            'listeJ' => $listeProdJ,
        ]);
    }
    public function getGraphProdConso()
    {
        $listeProdG = Groupe::productionGroupe();
        $listeProdJ = Jirama::productionJirama();
        $listeProdP = PanneauSolaire::tabProd();
        $listeConso = Consommation::getConsommation();

        $tabProd = [];
        $diffProdCons = [];
        for ($i = 0; $i <= 8; $i++)
        {
            if ($listeProdP)
            {
                $tabProd[$i] = $listeProdG[$i] + $listeProdP[$i] + $listeProdJ[$i];
                $diffProdCons[$i] = $tabProd[$i] - $listeConso[$i];
            }
            else
            {
                $tabProd[$i] = 0;
                $diffProdCons[$i] = 0;
            }
        }
        return view('admin.Details.graphique',[
            'tabProd' => $tabProd,
            'listeConso' => $listeConso,
            'diffProdCons' => $diffProdCons,
        ]);
    }
    public function getDetailsProd($id)
    {
        $listeProdG = Groupe::productionGroupe();
        $listeProdJ = Jirama::productionJirama();
        $listeProdP = PanneauSolaire::tabProd();

        $prodG = $listeProdG[$id];
        $prodJ = $listeProdJ[$id];
        $prodP = $listeProdP[$id];
        $heure = 8 + $id;
        return view('admin.Details.detailsProduction',[
            'prodG' => $prodG,
            'prodJ' => $prodJ,
            'prodP' => $prodP,
            'heure' => $heure,
        ]);
    }

    public function getDetailsCons($id)
    {
        $consommation = Consommation::find(1);
        $listeConso = Consommation::getConsommation();
        $cons = $listeConso[$id];
        $listeProdG = Groupe::getUtilisation();
        $listeProdJ = Jirama::getUtilisation();
        $listeProdP = PanneauSolaire::getUtilisation();

        $prodG = $listeProdG[$id];
        $prodJ = $listeProdJ[$id];
        $prodP = $listeProdP[$id];
        $heure = 8 + $id;
        return view('admin.Details.detailsConsommation',[
            'consommation' => $consommation,
            'cons' => $cons,
            'prodG' => $prodG,
            'prodJ' => $prodJ,
            'prodP' => $prodP,
            'heure' => $heure,
        ]);
    }


    /*public function exportToPDF()
    {
        // Votre code pour générer les données du graphique
        $listeProdG = Groupe::productionGroupe();
        $listeProdJ = Jirama::productionJirama();
        $listeProdP = PanneauSolaire::tabProd();
        $consommationData = Consommation::getConsommation();

        $tabProd = [];
        $diffProdCons = [];
        for ($i = 0; $i <= 9; $i++) {
            $productionData[$i] = $listeProdG[$i] + $listeProdP[$i] + $listeProdJ[$i];
            $diffProdCons[$i] = $tabProd[$i] - $consommationData[$i];
        }
        $data = [
            'productionData' => $productionData,
            'consommationData' => $consommationData,
        ];

        // Créer le graphique dans la vue HTML
        $chart = $this->generateChart($data);

        // Enregistrer le graphique comme image
        $chart->render(public_path('graphique.png'));

        // Créer le fichier PDF
        $pdf = PDF::loadView('pdf.test.pdf', $data);

        return $pdf->download('graphique.pdf');
    }

// Fonction pour générer le graphique avec ConsoleTVs/Charts
    private function generateChart($data)
    {
        $chart = Charts::multi('line', 'material')
            ->labels(range(8, 17))
            ->dataset('Production', $data['productionData'])
            ->dataset('Consommation', $data['consommationData'])
            ->options([
                'scales' => [
                    'x' => [
                        'type' => 'category',
                        'position' => 'bottom',
                        'grid' => [
                            'display' => false,
                        ],
                    ],
                    'y' => [
                        'beginAtZero' => true,
                    ],
                ],
                'maintainAspectRatio' => false,
                'responsive' => true,
                'plugins' => [
                    'legend' => [
                        'position' => 'top',
                    ],
                ],
            ]);

        return $chart;
    }*/
    public function pdfGeneration(){
        $listeProdG = Groupe::getUtilisation();
        $listeProdJ = Jirama::getUtilisation();
        $listeProdP = PanneauSolaire::getUtilisation();

        $priceS = PanneauSolaire::getPriceP();
        $priceJ = Jirama::getPriceH();
        $priceG = Groupe::getPriceH();
        $total = $priceG + $priceJ + $priceS;

        $tabProd = [];
        for ($i = 0; $i <= 8; $i++)
        {
            if ($listeProdP)
            {
                $tabProd[$i] = $listeProdG[$i] + $listeProdP[$i] + $listeProdJ[$i];
            }
            else
            {
                $tabProd[$i] = 0;
            }
        }
        //$html = view('employe.devis.pdf.pdf', compact('titre', 'lieu', 'img', 'datedeb'))->render();
        $data = [
            'tabProd' => $tabProd,
            'priceS' => $priceS,
            'priceJ' => $priceJ,
            'priceG' => $priceG,
            'total' => $total,
            'listeS' => $listeProdP,
            'listeG' => $listeProdG,
            'listeJ' => $listeProdJ,
        ];
////        $html = view('employe.devis.pdf.pdf', compact('titre', 'lieu', 'img', 'datedeb'))->render();
//
        $pdf = new Pdf();
        $pdf = Pdf::loadView('pdf.totalprice', $data);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        return $pdf->download('Totalprice.pdf');
    }

    public function exportToCSV()
    {
        $listeProdG = Groupe::productionGroupe();
        $listeProdJ = Jirama::productionJirama();
        $listeProdP = PanneauSolaire::tabProd();
        $listeConso = Consommation::getConsommation();
        $tabProd = [];
        $diffProdCons = [];
        $hours = range(8, 16);

        for ($i = 0; $i <= 8; $i++) {
            if ($listeProdP) {
                $tabProd[$i] = $listeProdG[$i] + $listeProdP[$i] + $listeProdJ[$i];
                $diffProdCons[$i] = $tabProd[$i] - $listeConso[$i];
            } else {
                $tabProd[$i] = 0;
                $diffProdCons[$i] = 0;
            }
        }

        // Prepare data for CSV
        $csvData = [];
        $csvData[] = ['Hour', 'Production', 'Consommation'];
        foreach ($hours as $index => $hour) {
            $csvData[] = ["{$hour}", $tabProd[$index], $listeConso[$index]];
        }

        // Create CSV file
        $csvFileName = 'production_conso.csv';
        $csvFile = fopen($csvFileName, 'w');

// Set the delimiter to a semicolon
        $delimiter = ';';

        foreach ($csvData as $row) {
            fputcsv($csvFile, $row, $delimiter);
        }
        fclose($csvFile);

        // Download the CSV file
        return Response::download($csvFileName)->deleteFileAfterSend(true);
    }

    public function exportToCSVPrice()
    {
        $listeProdG = Groupe::getUtilisation();
        $listeProdJ = Jirama::getUtilisation();
        $listeProdP = PanneauSolaire::getUtilisation();
        $priceS = PanneauSolaire::getPriceP();
        $priceJ = Jirama::getPriceH();
        $priceG = Groupe::getPriceH();
        $total = $priceG + $priceJ + $priceS;

        $tabProd = [];
        $hours = range(8, 16);

        for ($i = 0; $i <= 8; $i++) {
            if ($listeProdP) {
                $tabProd[$i] = $listeProdG[$i] + $listeProdP[$i] + $listeProdJ[$i];
            } else {
                $tabProd[$i] = 0;
            }
        }

        // Prepare data for CSV
        $csvData = [];
        //$csvData[] = ['Horaire', 'Solaire (W)', 'Jirama (W)', 'Groupe (W)', 'Total (W)'];
        foreach ($hours as $index => $hour) {
            $csvData[] = [
                "{$hour}",
                isset($listeProdP[$index]) ? number_format($listeProdP[$index], 2) : 'N/A',
                isset($listeProdJ[$index]) ? number_format($listeProdJ[$index], 2) : 'N/A',
                isset($listeProdG[$index]) ? number_format($listeProdG[$index], 2) : 'N/A',
                isset($tabProd[$index]) ? number_format($tabProd[$index], 2) : 'N/A',
            ];
        }

        $csvData[] = [number_format($priceS, 2), number_format($priceJ, 2), number_format($priceG, 2), number_format($total, 2)];

        // Create CSV file
        $csvFileName = 'export.csv';
        $csvFile = fopen($csvFileName, 'w');
        $delimiter = ';';

        foreach ($csvData as $row) {
            fputcsv($csvFile, $row, $delimiter);
        }

        fclose($csvFile);

        // Download the CSV file
        return Response::download($csvFileName)->deleteFileAfterSend(true);
    }

}

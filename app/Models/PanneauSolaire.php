<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\Translation\t;

class PanneauSolaire extends Model
{
    use HasFactory;
    protected $table = 'panneausolaire';
    protected $fillable = [
        'idpanneau',
        'puissance',
        'tarif',
    ];
    protected $primaryKey = 'idpanneau';
    public $timestamps = false;

    public static function getProductionValue($hour)
    {
        // Récupérez le taux en fonction de l'heure spécifiée
        $taux = TauxPS::getTauxByHour($hour);

        if ($taux) {
            // Récupérez le panneau solaire (supposons que vous avez déjà un panneau spécifique)
            $panneau = PanneauSolaire::find(1); // Remplacez $panneauId par l'ID réel du panneau

            // Calculez la valeur de production en multipliant la puissance par le taux

            $productionValue = ($panneau->puissance * $taux) / 100;

            return $productionValue;
        } else {
            return null; // Aucun taux correspondant trouvé ou résultat invalide
        }
    }


    public static function tabProd()
    {
        $productionValues = [];

        for ($hour = 8.00; $hour <= 16.00; $hour++) {
            // Appelez la méthode getProductionValue pour chaque heure
            $productionValue = PanneauSolaire::getProductionValue($hour);
            // Vérifiez si $productionValue est une valeur numérique avant d'ajouter à l'array
            if (is_numeric($productionValue)) {
                $productionValues[] = $productionValue;
            }
            else if (!$productionValue)
                $productionValues[] = 0;
        }
        return $productionValues;
    }

    public static function totalProd()
    {
        $productionValues = self::tabProd();
        $total = 0;
        for ($i = 0; $i < sizeof($productionValues); $i++)
        {
            $total = $total + $productionValues[$i];
        }
        return $total;
    }
    public static function getPriceP()
    {
        $p = PanneauSolaire::find(1);
        $price = $p->tarif;
        return $price;
    }
    public static function getUtilisation()
    {
        $listeProdP= self::tabProd();
        $listeConso = Consommation::getConsommation();
        $listeProdH = [];

        if ($listeProdP)
        {
            for ($i = 0; $i <= 8; $i++)
            {
                if ($listeConso[$i] > 0 && $listeConso[$i] <= $listeProdP[$i])
                {
                    $listeProdH[$i] = $listeConso[$i];
                }
                else if ($listeConso[$i] >= $listeProdP[$i])
                    $listeProdH[$i] = $listeProdP[$i];
            }
        }
        else
            for ($j = 0; $j <= 8; $j++)
                $listeProdH[$j] = 0;
        //dd($listeProdH);
        return $listeProdH;
    }
    public static function getPriceH()
    {
    }
}

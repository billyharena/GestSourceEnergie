<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jirama extends Model
{
    use HasFactory;
    protected $table = 'jirama';
    protected $fillable = [
        'idjirama',
        'capacitemax',
        'tarifjirama',
    ];
    protected $primaryKey = 'idjirama';
    public $timestamps = false;

    public static function productionJirama()
    {
        $production = [];
        $jirama = Jirama::find(1);
        $hour = 0;
        for ($i = 0; $i <= 8; $i++)
        {
            $hour = $i + 8;
            $delestage = Delestage::isDelestage($hour);
            //dd($delestage);
            if ($delestage == 0)
                $production[] = $jirama->capacitemax;
            else
                $production[] = 0.00;
        }
        return $production;
    }
    public static function totalJirama()
    {
        $production = self::productionJirama();
        $total = 0;
        for ($i = 0; $i < sizeof($production); $i++)
        {
            $total = $total + $production[$i];
        }
        return $total;
    }
    public static function getPriceJ()
    {
        $j = Jirama::find(1);
        $priceH = $j->tarifjirama;
        return $priceH;
    }
    public static function getUtilisation()
    {
        $listeProdG = Groupe::productionGroupe();
        $listeProdP = PanneauSolaire::tabProd();
        $listeProdJ = self::productionJirama();
        $listeConso = Consommation::getConsommation();
        $listeProdH = [];

        if ($listeProdP)
        {
            for ($i = 0; $i <= 8; $i++)
            {
                if ($listeConso[$i] <= $listeProdP[$i])
                {
                    $listeProdH[$i] = 0;
                }
                else if ($listeConso[$i] - $listeProdP[$i] - $listeProdG[$i] >= $listeProdJ[$i])
                    $listeProdH[$i] = $listeProdJ[$i];
                else if ($listeConso[$i] - $listeProdP[$i] - $listeProdG[$i] > 0 && $listeConso[$i] - $listeProdP[$i] - $listeProdG[$i] < $listeProdJ[$i])
                    $listeProdH[$i] = $listeConso[$i] - $listeProdP[$i] - $listeProdG[$i];
                else if ($listeConso[$i] - $listeProdP[$i] - $listeProdG[$i] <= 0)
                    $listeProdH[$i] = 0;
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
        $listeUJ = self::getUtilisation();
        $price = self::getPriceJ();
        $total = 0;
        for ($i = 0; $i <= 8; $i++)
        {
            $total = $total + ($listeUJ[$i] * $price);
        }
        return $total;
    }
   /* public static function productionJirama($delestHours)
    {
        $production = [];
        $jirama = Jirama::find(1);

        // Convertissez les plages horaires de délestage en un tableau
        $delestHoursArray = explode(',', $delestHours);

        for ($i = 0; $i <= 9; $i++) {
            // Vérifiez si l'heure actuelle est en délestage
            $currentHour = ($i + 8) % 24; // Convertir l'index en heure (de 8h à 17h)
            $isDelest = false;

            foreach ($delestHoursArray as $delestHour) {
                list($start, $end) = explode('-', $delestHour);
                $start = intval($start);
                $end = intval($end);

                // Assurez-vous que la plage horaire de délestage est comprise entre 8h et 17h
                if (($start >= 8 && $start <= 17) && ($end >= 8 && $end <= 17)) {
                    if ($currentHour >= $start && $currentHour <= $end) {
                        // L'heure actuelle est en délestage
                        $isDelest = true;
                        break;
                    }
                }
            }

            if ($isDelest) {
                // Pendant la plage de délestage, la production est égale à 0
                $production[] = 0;
            } else {
                // En dehors de la plage de délestage, utilisez la capacité maximale
                $production[] = $jirama->capacitemax;
            }
        }
        return $production;
    }
   public static function productionJirama($delestHours)
{
    $production = [];
    $jirama = Jirama::find(1);

    // Convertissez les plages horaires de délestage en un tableau
    $delestHoursArray = explode(',', $delestHours);

    for ($i = 0; $i <= 9; $i++) {
        // Vérifiez si l'heure actuelle est en délestage
        $currentHour = ($i + 8) % 24; // Convertir l'index en heure (de 8h à 17h)
        $isDelest = false;

        foreach ($delestHoursArray as $delestHour) {
            list($start, $end) = explode('-', $delestHour);
            $start = intval($start);
            $end = intval($end);

            if (($currentHour >= $start && $currentHour <= $end) || ($start > $end && ($currentHour >= $start || $currentHour <= $end))) {
                // L'heure actuelle est en délestage
                $isDelest = true;
                break;
            }
        }

        if ($isDelest) {
            // Pendant la plage de délestage, la production est égale à 0
            $production[] = 0;
        } else {
            // En dehors de la plage de délestage, utilisez la capacité maximale
            $production[] = $jirama->capacitemax;
        }
    }
    return $production;
}

   */

}

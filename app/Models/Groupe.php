<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;
    protected $table = 'groupe';
    protected $fillable = [
        'idgroupe',
        'capacitemax',
        'reservoir',
        'deb',
        'consommation',
        'prixlitre',
    ];
    protected $primaryKey = 'idgroupe';
    public $timestamps = false;

    public static function getHeure()
    {
        $groupe = Groupe::find(1);
        if ($groupe->consommation == 0)
            $heure = 0;
        else
            $heure = $groupe->reservoir / $groupe->consommation;
        return $heure;
    }
    public static function getConso()
    {
        $groupe = Groupe::find(1);
        $conso = $groupe->consommation;
        return $conso;
    }
    public static function productionGroupe()
    {
        $heure = self::getHeure();
        $capacite = Groupe::find(1);
        $deb = $capacite->deb;
        $heurefin = $deb + $heure;
        //dd($heurefin);
        $tab = [];
        // Utilisez l'index 0 à 9 pour représenter les heures de 8 à 17
        for ($j = 0; $j <= 8; $j++)
            $tab[$j] = 0;

        for ($i = $deb; $i < $heurefin; $i++)
        {
            // Utilisez l'index 0 à 8 pour représenter les heures de 8 à 16
            $index = $i - 8.00;
            if ($i < 17)
                $tab[$index] += $capacite->capacitemax;
            else
                break;
        }
        return $tab;
    }

    public static function totalGroupe()
    {
        $productionValues = self::productionGroupe();
        $total = 0;
        for ($i = 0; $i < sizeof($productionValues); $i++)
        {
            $total = $total + $productionValues[$i];
        }
        return $total;
    }

    public static function getPriceG()
    {
        $g = Groupe::find(1);
        $price = $g->prixlitre;
        return $price;
    }

    public static function getUtilisation()
    {
        $listeProdG = Groupe::productionGroupe();
        $listeProdP = PanneauSolaire::tabProd();
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
                else if ($listeConso[$i] - $listeProdP[$i] >= $listeProdG[$i])
                    $listeProdH[$i] = $listeProdG[$i];
                else if ($listeConso[$i] - $listeProdP[$i] > 0 && $listeConso[$i] - $listeProdP[$i]  < $listeProdG[$i])
                    $listeProdH[$i] = $listeConso[$i] - $listeProdP[$i];
                else if ($listeConso[$i] - $listeProdP[$i] <= 0)
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
        $price = self::getPriceG();
        $conso = self::getConso();
        $total = 0;
        for ($i = 0; $i <= 8; $i++)
        {
            if ($listeUJ[$i] != 0.00)
                $total = $total + ($conso * $price);
            else
                $total = $total + 0.00;
        }

        return $total;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consommation extends Model
{
    use HasFactory;
    protected $table = 'consommation';
    protected $fillable = [
        'idconsommation',
        'nbetudiant',
        'puissancelaptop',
        'consofixe',
        'pourcentage',
    ];
    protected $primaryKey = 'idconsommation';
    public $timestamps = false;

    public static function getConsommation()
    {
        $conso = Consommation::find(1);
        $consoTE = 0;
        $consoRE = 0;
        $tab = [];
        if ($conso)
        {
            $consoTE = ($conso->nbetudiant * $conso->puissancelaptop) + $conso->consofixe;
            $consoRE = ($conso->puissancelaptop * (($conso->nbetudiant * $conso->pourcentage) / 100)) + $conso->consofixe;

            // Utilisez l'index 0 à 9 pour représenter les heures de 8 à 17
            for ($j = 0; $j <= 8; $j++)
                $tab[$j] = 0;
            for ($i = 8; $i <= 16; $i++)
            {
                $index = $i - 8;
                if ($i >= 12 && $i < 14)
                    $tab[$index] += $consoRE;
                else
                    $tab[$index] += $consoTE;
            }
        }
        return $tab;
    }

    public static function totalConsommation()
    {
        $productionValues = self::getConsommation();
        $total = 0;
        for ($i = 0; $i < sizeof($productionValues); $i++)
        {
            $total = $total + $productionValues[$i];
        }
        return $total;
    }

    public static function getPrice()
    {
        $listeProdG = Groupe::productionGroupe();
        $listeProdJ = Jirama::productionJirama();
        $listeProdP = PanneauSolaire::tabProd();
        $listeConso = Consommation::getConsommation();

        $prixG = Groupe::getPriceG();
        $prixJ = Jirama::getPriceJ();
        $prixP = PanneauSolaire::getPriceP();

        $totalCost = 0;

        for ($i = 0; $i <= 8; $i++)
        {
            // Calculer le coût en utilisant le prixG en premier
            if ($listeProdG[$i] >= $listeConso[$i]) {
                $totalCost += $listeConso[$i] * $prixG;
                $listeProdG[$i] -= $listeConso[$i];
                $listeConso[$i] = 0;
            } else {
                $totalCost += $listeProdG[$i] * $prixG;
                $listeConso[$i] -= $listeProdG[$i];
                $listeProdG[$i] = 0;

                // Si la production de Groupe n'est pas suffisante, utiliser la production de Jirama
                $totalCost += $listeConso[$i] * $prixJ;
                $listeProdJ[$i] -= $listeConso[$i];
                $listeConso[$i] = 0;
            }
        }

        // Le reste de la consommation est couvert par la production de Jirama
        for ($i = 0; $i <= 8; $i++) {
            $totalCost += $listeConso[$i] * $prixJ;
            $listeProdJ[$i] -= $listeConso[$i];
            $listeConso[$i] = 0;
        }

        // Le coût total est maintenant dans $totalCost
        return $totalCost + $prixP;
    }

}

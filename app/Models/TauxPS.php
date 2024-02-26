<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TauxPS extends Model
{
    use HasFactory;
    protected $table = 'tauxps';
    protected $fillable = [
        'idtaux',
        'deb',
        'fin',
        'taux',
    ];
    protected $primaryKey = 'idtaux';
    public $timestamps = false;

    public static function getTauxByHour($hour)
    {
        // Récupérez le taux en fonction de l'heure spécifiée
        $taux = TauxPS::where('deb', '<=', $hour)
            ->where('fin', '>', $hour)
            ->first();
        // Si un taux correspondant est trouvé, retournez sa valeur, sinon retournez une valeur par défaut
        return $taux ? $taux->taux : null;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delestage extends Model
{
    use HasFactory;
    protected $table = 'delestage';
    protected $fillable = [
        'iddelestage',
        'deb',
        'fin',
        'etat',
    ];
    protected $primaryKey = 'iddelestage';
    public $timestamps = false;

    public static function isDelestage($hour)
    {
        $delestage = Delestage::where('deb', '<=', $hour)
            ->where('fin', '>', $hour)
            ->where('etat', '=', 0)
            ->first();
        return $delestage ? 1 : 0;
    }

}

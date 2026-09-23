<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prijs extends Model
{
    protected $table = 'prijs';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    const CREATED_AT = 'Datumaangemaakt';
    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'Datum',
        'Tijdslot',
        'Tarief',
        'Isactief',
        'Opmerking',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'PrijsId', 'Id');
    }
}

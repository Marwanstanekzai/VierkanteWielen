<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    protected $table = 'stands';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    const CREATED_AT = 'Datumaangemaakt';
    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'VerkoperId',
        'StandType',
        'Prijs',
        'VerhuurdStatus',
        'Isactief',
        'Opmerking',
    ];

    public function verkoper()
    {
        return $this->belongsTo(Verkoper::class, 'VerkoperId', 'Id');
    }
}

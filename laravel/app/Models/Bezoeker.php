<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bezoeker extends Model
{
    protected $table = 'bezoekers';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    const CREATED_AT = 'Datumaangemaakt';
    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'Naam',
        'E-mailadres',
        'Isactief',
        'Opmerking',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'BezoekerId', 'Id');
    }
}

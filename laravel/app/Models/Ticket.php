<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    const CREATED_AT = 'Datumaangemaakt';
    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'BezoekerId',
        'EvenementId',
        'PrijsId',
        'AantalTickets',
        'Datum',
        'Isactief',
        'Opmerking',
    ];

    public function bezoeker()
    {
        return $this->belongsTo(Bezoeker::class, 'BezoekerId', 'Id');
    }

    public function evenement()
    {
        return $this->belongsTo(Evenement::class, 'EvenementId', 'Id');
    }

    public function prijs()
    {
        return $this->belongsTo(Prijs::class, 'PrijsId', 'Id');
    }
}

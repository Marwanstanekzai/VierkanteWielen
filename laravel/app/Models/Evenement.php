<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    protected $table = 'evenements';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    const CREATED_AT = 'Datumaangemaakt';
    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'Naam',
        'Datum',
        'Locatie',
        'AantalTicketsPerTijdslot',
        'BeschikbareStands',
        'Isactief',
        'Opmerking',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'EvenementId', 'Id');
    }
}

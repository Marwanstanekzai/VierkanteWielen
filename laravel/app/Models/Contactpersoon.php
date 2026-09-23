<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contactpersoon extends Model
{
    protected $table = 'contactpersoons';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    const CREATED_AT = 'Datumaangemaakt';
    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'Naam',
        'Telefoonnummer',
        'E-mailadres',
        'Isactief',
        'Opmerking',
    ];

    public function verkopers()
    {
        return $this->belongsToMany(Verkoper::class, 'contact_per_verkopers', 'ContactpersoonId', 'VerkoperId', 'Id', 'Id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verkoper extends Model
{
    protected $table = 'verkopers';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    const CREATED_AT = 'Datumaangemaakt';
    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'Naam',
        'SpecialeStatus',
        'VerkooptSoort',
        'StandType',
        'Dagen',
        'Logo',
        'Isactief',
        'Opmerking',
    ];

    public function stands()
    {
        return $this->hasMany(Stand::class, 'VerkoperId', 'Id');
    }

    public function contactpersoons()
    {
        return $this->belongsToMany(Contactpersoon::class, 'contact_per_verkopers', 'VerkoperId', 'ContactpersoonId', 'Id', 'Id');
    }
}

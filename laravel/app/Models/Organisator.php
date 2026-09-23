<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organisator extends Model
{
    protected $table = 'organisators';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    const CREATED_AT = 'Datumaangemaakt';
    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'Naam',
        'Gebruikersnaam',
        'Wachtwoord',
        'Isactief',
        'Opmerking',
    ];

    protected $hidden = [
        'Wachtwoord',
    ];
}

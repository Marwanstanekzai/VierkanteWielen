<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactPerVerkoper extends Model
{
    protected $table = 'contact_per_verkopers';
    protected $primaryKey = 'Id';
    public $timestamps = true;

    const CREATED_AT = 'Datumaangemaakt';
    const UPDATED_AT = 'Datumgewijzigd';

    protected $fillable = [
        'VerkoperId',
        'ContactpersoonId',
        'Isactief',
        'Opmerking',
    ];

    public function verkoper()
    {
        return $this->belongsTo(Verkoper::class, 'VerkoperId', 'Id');
    }

    public function contactpersoon()
    {
        return $this->belongsTo(Contactpersoon::class, 'ContactpersoonId', 'Id');
    }
}

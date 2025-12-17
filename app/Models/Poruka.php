<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poruka extends Model
{
    use HasFactory;

    protected $table = 'poruka';
    protected $primaryKey = 'idPoruka';

    protected $fillable = [
        'tekst',
        'idChat',
        'idKorisnik',
    ];

    /**
     * Get the chat that this message belongs to.
     */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'idChat', 'idChat');
    }

    /**
     * Get the user who sent this message.
     */
    public function korisnik(): BelongsTo
    {
        return $this->belongsTo(Korisnik::class, 'idKorisnik', 'idKorisnik');
    }

    /**
     * Get the files attached to this message.
     */
    public function datoteke(): HasMany
    {
        return $this->hasMany(Datoteka::class, 'idPoruka', 'idPoruka');
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pripada extends Model
{
    use HasFactory;

    protected $table = 'pripada';

    protected $fillable = [
        'idKorisnik',
        'idChat',
        'datumKreiranja',
    ];

    protected $casts = [
        'datumKreiranja' => 'date',
    ];

    /**
     * Get the user that belongs to the chat.
     */
    public function korisnik(): BelongsTo
    {
        return $this->belongsTo(Korisnik::class, 'idKorisnik', 'idKorisnik');
    }

    /**
     * Get the chat that the user belongs to.
     */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'idChat', 'idChat');
    }
}


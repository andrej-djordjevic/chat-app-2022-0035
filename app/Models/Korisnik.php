<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Korisnik extends Model
{
    use HasFactory;

    protected $table = 'korisnik';
    protected $primaryKey = 'idKorisnik';

    protected $fillable = [
        'email',
        'lozinka',
        'suspendovan',
        'idUloga',
    ];

    protected $hidden = [
        'lozinka',
    ];

    protected $casts = [
        'suspendovan' => 'date',
    ];

    /**
     * Get the role that belongs to the user.
     */
    public function uloga(): BelongsTo
    {
        return $this->belongsTo(Uloga::class, 'idUloga', 'idUloga');
    }

    /**
     * Get the chats that the user belongs to.
     */
    public function chatovi(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'pripada', 'idKorisnik', 'idChat')
                    ->withPivot('datumKreiranja')
                    ->withTimestamps();
    }
}


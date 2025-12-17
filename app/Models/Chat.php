<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chat';
    protected $primaryKey = 'idChat';

    protected $fillable = [
        'idChat',
    ];

    /**
     * Get the users that belong to this chat.
     */
    public function korisnici(): BelongsToMany
    {
        return $this->belongsToMany(Korisnik::class, 'pripada', 'idChat', 'idKorisnik')
                    ->withPivot('datumKreiranja')
                    ->withTimestamps();
    }

    /**
     * Get the messages in this chat.
     */
    public function poruke(): HasMany
    {
        return $this->hasMany(Poruka::class, 'idChat', 'idChat');
    }

    /**
     * Get the group chat instance if this is a group chat.
     */
    public function grupniChat(): HasOne
    {
        return $this->hasOne(GrupniChat::class, 'idChat', 'idChat');
    }

    /**
     * Get the private chat instance if this is a private chat.
     */
    public function privatniChat(): HasOne
    {
        return $this->hasOne(PrivatniChat::class, 'idChat', 'idChat');
    }
}


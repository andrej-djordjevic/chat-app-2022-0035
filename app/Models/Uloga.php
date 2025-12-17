<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Uloga extends Model
{
    use HasFactory;

    protected $table = 'uloga';
    protected $primaryKey = 'idUloga';

    protected $fillable = [
        'naziv',
    ];

    /**
     * Get the users that have this role.
     */
    public function korisnici(): HasMany
    {
        return $this->hasMany(Korisnik::class, 'idUloga', 'idUloga');
    }
}


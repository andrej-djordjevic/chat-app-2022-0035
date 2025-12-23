<?php

namespace App\Presentation\Requests;

class StorePorukaRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'tekst' => 'required|string',
            'idChat' => 'required|exists:chat,idChat',
            'idKorisnik' => 'nullable|exists:korisnik,idKorisnik',
        ];
    }
}


<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Kaizen;
use App\Models\Signature;

class SignatureController extends Controller
{
    public function __invoke(Signature $signature)
    {
        $dokumen = Kaizen::where('pic_id', $signature->id)->orWhere('secretary_id', $signature->id)->first();

        return Inertia::render('Signature/Show', [
            'signature' => $signature->load(
                [
                    'user' => function ($query) {
                        $query->select('id', 'name', 'jabatan', 'departement_id')->with('departement');
                    },
                ]
            ), 'dokumen' => $dokumen
        ]);
    }
}

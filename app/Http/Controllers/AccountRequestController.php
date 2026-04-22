<?php

namespace App\Http\Controllers;

use App\Models\AccountRequest;
use Illuminate\Http\Request;

class AccountRequestController extends Controller
{
    public function create()
    {
        return view('permohonan.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'no_whatsapp' => 'required|string|max:20',
            'keperluan' => 'required|string',
        ]);

        AccountRequest::create($validated);

        return redirect()->route('permohonan.sukses');
    }

    public function sukses()
    {
        return view('permohonan.sukses');
    }
}
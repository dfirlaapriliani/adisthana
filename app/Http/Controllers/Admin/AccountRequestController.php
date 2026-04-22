<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountRequest;
use Illuminate\Http\Request;

class AccountRequestController extends Controller
{
    public function index()
    {
        $requests = AccountRequest::orderBy('created_at', 'desc')->get();
        return view('admin.account-requests.index', compact('requests'));
    }

    public function setujui($id)
    {
        $request = AccountRequest::findOrFail($id);
        $request->update(['status' => 'approved']);

        return redirect()->route('admin.users.create', [
            'from' => 'permohonan',
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'phone' => $request->no_whatsapp
        ]);
    }

    public function tolak($id)
    {
        $request = AccountRequest::findOrFail($id);
        $request->update(['status' => 'rejected']);

        return redirect()->route('admin.account-requests.index')
            ->with('success', 'Permohonan ditolak');
    }
}
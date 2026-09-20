<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PenggunaController extends Controller
{
    public function registrasi()
    {
        $institusi_asal = DB::table('jenis_institusi')->get();

        // dd($institusi_asal); // Debugging line to check the contents of $institusi_asal

        return view('registrasikppti', compact('institusi_asal'));
    }

    public function profile()
    {
        $role = DB::table('role')->get();
        $userdata = session('userdata');

        $institusi = $userdata['idinstitusi_asal']
            ? DB::table('institusi_asal')->where('idinstitusi_asal', $userdata['idinstitusi_asal'])->value('nama_institusi')
            : null;

        return view('profile', compact('role', 'institusi'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $user = Auth::user();

        if (! Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors([
                'current_password' => 'Kata sandi saat ini tidak sesuai.',
            ]);
        }

        $user->password = $request->input('password');
        $user->save();

        return back()->with('status', [
            'status' => 'success',
            'message' => 'Kata sandi berhasil diperbarui.',
        ]);
    }
}

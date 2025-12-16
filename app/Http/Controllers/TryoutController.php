<?php

namespace App\Http\Controllers;

use App\Models\Tryout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TryoutController extends Controller
{
    // Menampilkan halaman utama tryout
    public function index()
    {
        $user = Auth::user();
        
        // Ambil semua tryout
        $tryouts = Tryout::with(['users' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }])->get();

        return view('tryout.index', compact('tryouts'));
    }

    // Menampilkan detail tryout
    public function show($id)
    {
        $tryout = Tryout::findOrFail($id);
        return view('tryout.show', compact('tryout'));
    }

    // Memulai tryout
    public function start($id)
    {
        $user = Auth::user();
        $tryout = Tryout::findOrFail($id);

        // Cek apakah user sudah pernah mengambil tryout ini
        $userTryout = $user->tryouts()->where('tryout_id', $id)->first();

        if ($userTryout && $userTryout->pivot->status == 'sudah_dikerjakan') {
            return redirect()->route('tryout.index')->with('error', 'Anda sudah mengerjakan tryout ini!');
        }

        // Jika belum ada record, buat baru
        if (!$userTryout) {
            $user->tryouts()->attach($id, [
                'status' => 'sedang_dikerjakan',
                'started_at' => now(),
            ]);
        } else {
            // Update status jadi sedang dikerjakan
            $user->tryouts()->updateExistingPivot($id, [
                'status' => 'sedang_dikerjakan',
                'started_at' => now(),
            ]);
        }

        return redirect()->route('tryout.work', $id);
    }

    // Halaman mengerjakan tryout
    public function work($id)
    {
        $tryout = Tryout::findOrFail($id);
        $user = Auth::user();

        // Cek apakah user berhak mengerjakan
        $userTryout = $user->tryouts()->where('tryout_id', $id)->first();
        
        if (!$userTryout || $userTryout->pivot->status != 'sedang_dikerjakan') {
            return redirect()->route('tryout.index')->with('error', 'Anda tidak memiliki akses ke tryout ini!');
        }

        return view('tryout.work', compact('tryout', 'userTryout'));
    }

    // Submit tryout
    public function submit(Request $request, $id)
    {
        $user = Auth::user();
        
        // Update status jadi sudah dikerjakan
        $user->tryouts()->updateExistingPivot($id, [
            'status' => 'sudah_dikerjakan',
            'finished_at' => now(),
            'score' => $request->score ?? 0, // Score bisa dihitung dari jawaban
        ]);

        return redirect()->route('tryout.index')->with('success', 'Tryout berhasil dikerjakan!');
    }
}

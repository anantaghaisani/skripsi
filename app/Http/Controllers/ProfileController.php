<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show profile page
     */
    public function index()
    {
        $user = Auth::user();
        
        // Stats
        $completedTryouts = $user->tryouts()
            ->wherePivot('status', 'sudah_dikerjakan')
            ->count();
            
        $averageScore = $user->tryouts()
            ->wherePivot('status', 'sudah_dikerjakan')
            ->avg('user_tryouts.score');
        
        return view('profile.index', compact('user', 'completedTryouts', 'averageScore'));
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password berhasil diubah!');
    }

    /**
     * Update profile photo
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Max 2MB
        ]);

        $user = Auth::user();

        // Delete old photo if exists
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Store new photo
        $path = $request->file('photo')->store('profile-photos', 'public');

        $user->update([
            'photo' => $path,
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Foto profil berhasil diperbarui!');
    }

    /**
     * Delete profile photo
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->update([
            'photo' => null,
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Foto profil berhasil dihapus!');
    }
}
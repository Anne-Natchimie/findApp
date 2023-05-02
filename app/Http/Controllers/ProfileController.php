<?php

namespace App\Http\Controllers;

use App\Models\Favori;
use App\Models\Annonce;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function favoriAdd($id = 0)
    {
        # code...
        
        $favori = Annonce::findOrFail($id) ; // Vérifier que l'article existe 
        // Auth::user()->id // Récupère l'identifiant de l'utlisateur 
        $existFavori = Favori::where('annonce_id', $id)->where('user_id', Auth::user()->id)->first() ; 
        
        if (!empty($existFavori)) {
            Favori::where('annonce_id', $id)->where('user_id', Auth::user()->id)->delete() ; 
        } else {
            $favori = new Favori ; 
            $favori->annonce_id = $id ;
            $favori->user_id = Auth::user()->id ; 
            $favori->save() ;  
        } ; 

        return back(); 

    }
}

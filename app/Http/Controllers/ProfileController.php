<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();

        seo()->title($user->name);
        return view('profile.index', [
            'user' => $user,
        ]);
    }

    public function account(Request $request): View
    {
        seo()->title('Hesap Bilgilerim');
        return view('profile.account-info', [
            'user' => auth()->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $phone = Str::replace('+','',$request->phone);
        $phone = Str::replace(' ','',$request->phone);
        $request->merge([
            'phone' => $phone
        ]);

        $request->validate([
            'name' => ['required','string','max:100'],
            'phone' => ['required', 'numeric',Rule::unique('users')->ignore(auth()->id())],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())]
        ]);

        $request->user()->fill($request->all());
        $request->user()->email_promotions = false;

        if( $request->has('email_promotions') ){
            $request->user()->email_promotions = true;
        }
        
        /*
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        */

        $request->user()->save();

        return back()->with('success','Hesap bilgileri güncellendi.');
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
}

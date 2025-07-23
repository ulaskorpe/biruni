<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class AdminProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {
        return Inertia('Profile/Index');
    }

    public function update(Request $request)
    {
        $phone = Str::replace('+', '', $request->phone);
        $phone = Str::replace(' ', '', $request->phone);
        $request->merge([
            'phone' => $phone
        ]);

        $request->validate([
            'phone' => ['required', 'numeric', Rule::unique('users')->ignore(auth()->id())],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())]
        ]);

        $request->user()->fill($request->all());
        $request->user()->save();

        return back()->with('flash', [
            'type' => 'success',
            'message' => __('Profil bilgileri güncellendi.')
        ]);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $request->user()->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        $request->session()->regenerate();

        return back()->with('flash', [
            'type' => 'success',
            'message' => __('Şifreniz güncellendi!')
        ]);
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

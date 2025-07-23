<?php

namespace App\Http\Controllers;

use App\Models\NewsletterMember;
use Illuminate\Http\Request;

class NewsletterMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.NewsletterMember::class],
            ],
            [
                'email.required' => __('E-Posta adresinizi giriniz.'),
                'email.email' => __('Geçerli bir e-posta adresi giriniz.'),
                'email.unique' => __('Bu e-posta adresi daha önceden kayıt edilmiş..'),
            ]
        );

        $member = NewsletterMember::create([
            'email' => $request->email,
            'ip' => $request->ip()
        ]);

        return back()->with('success','E-Bülten üyeliğiniz için teşekkür ederiz.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsletterMember $newsletterMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsletterMember $newsletterMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsletterMember $newsletterMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsletterMember $newsletterMember)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\EmailContent;
use Illuminate\Http\Request;

class EmailContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        /*
        foreach (config('enums.email_types') as $key => $email) {
            
            EmailContent::updateOrCreate(
                [
                    'use_for' => $email['value']
                ],
                [
                    'use_for' => $email['value'],
                    'name' => $email['label']
                ]
            );

        }
        */

        $this->authorize('viewAny',EmailContent::class);

        return Inertia('EmailContent/Index',[
            'emails' => EmailContent::paginate(30)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',EmailContent::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',EmailContent::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailContent $emailContent)
    {
        $this->authorize('viewAny',EmailContent::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailContent $emailContent)
    {
        $this->authorize('update',EmailContent::class);

        return Inertia('EmailContent/EditEmailContent',[
            'email' => $emailContent
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailContent $emailContent)
    {
        $this->authorize('update',EmailContent::class);

        $emailContent->update($request->all());
        return back()->with('flash',[
            'type' => 'success',
            'message' => __('Şablon güncellendi.')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailContent $emailContent)
    {
        $this->authorize('forceDelete',EmailContent::class);
    }
}

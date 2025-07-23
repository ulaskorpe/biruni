<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormEntry;
use Illuminate\Http\Request;
use App\Exports\ExportFormEntries;
use Maatwebsite\Excel\Facades\Excel;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->wantsJson() ){
            return Form::all();
        }

        $this->authorize('viewAny',Form::class);

        return Inertia('Form/Index',[
            'forms' => Form::withCount('entries')->get(),
            'filters' => [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Form::class);

        return Inertia('Form/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',Form::class);

        $request->validate([
            'name' => 'required|string',
            'sender_name' => 'required|string',
            'success_type' => 'required|string',
            'to_email' => 'required|email',
            'subject' => 'required|string',
            'button_text' => 'required|string',
        ]);

        $form = Form::create($request->all());

        return redirect()->route('forms.index')->with('flash',[
            "type" => "success",
            "message" => "Form başarıyla oluşturuldu.",
            "data" => $form
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Form $form)
    {
        $this->authorize('viewAny',Form::class);

        $search = $request->search;

        $entries_query = FormEntry::where('form_id',$form->id)
        ->when($search && !empty($search), function($query) use($search) {
            $query->where('json_data','like','%'.$search.'%');
        })
        ->latest();

        if( $request->has('export') && $request->export === "true" ){

            $entries = $entries_query->get();

            $export = new ExportFormEntries($entries->toArray(),$form->json_data);

            return Excel::download($export, $form->name. ' - Data.xlsx');

        }

        $entries = $entries_query->paginate(30)->withQueryString();

        return inertia('Form/Entries',[
            'form' => $form,
            'entries' => $entries,
            'filters' => [],
            'queryParams' => $request->query()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form)
    {
        $this->authorize('update',Form::class);

        return Inertia('Form/Edit',[
            'form' => $form,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Form $form)
    {
        $this->authorize('update',Form::class);

        $request->validate([
            'name' => 'required|string',
            'sender_name' => 'required|string',
            'success_type' => 'required|string',
            'to_email' => 'required|email',
            'subject' => 'required|string',
            'button_text' => 'required|string',
        ]);

        $form->update($request->all());

        return back()->with('flash',[
            "type" => "success",
            "message" => "Form başarıyla güncellendi!",
            "data" => $form
        ]);
    }

    public function delete(Form $form)
    {
        $this->authorize('delete',Form::class);

        $form->delete();
        return back();
    }

    public function restore(Form $form)
    {
        $this->authorize('restore',Form::class);

        $form->restore();
        return back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        $this->authorize('restore',Form::class);

        $form->forceDelete();
        return back();
    }
}

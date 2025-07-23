<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        seo()->title('Adreslerim');
        return view('profile.address', [
            'user' => $request->user(),
            'addresses' => $request->user()->addresses,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return response()->json([
            'success' => true,
            'html' => View::make('profile.partials.add-new-address-form',[
                'user' => $request->user()
            ])->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'name' => 'required|string|regex:/^\S+\s+\S+/',
            'email' => 'required|email',
            'phone' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'address' => 'required',
            'billing_type' => [Rule::requiredIf($request->has('use_for_billing') && $request->use_for_billing)],
            'tc_no' => [
                Rule::requiredIf($request->use_for_billing && $request->has('billing_type') && $request->billing_type == 'Bireysel'),
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->use_for_billing && $request->billing_type == 'Bireysel') {
                        if (!is_numeric($value)) {
                            return $fail('TC kimlik numarası sadece sayılardan oluşmalıdır.');
                        }
                        if (strlen($value) !== 11) {
                            return $fail('TC kimlik numarası tam olarak 11 haneli olmalıdır.');
                        }
                    }
                }
            ],
            'company_name' => [Rule::requiredIf($request->use_for_billing && $request->has('billing_type') && $request->billing_type == 'Kurumsal')],
            'vd' => [Rule::requiredIf($request->use_for_billing && $request->has('billing_type') && $request->billing_type == 'Kurumsal')],
            'vkn' => [Rule::requiredIf($request->use_for_billing && $request->has('billing_type') && $request->billing_type == 'Kurumsal')],
        ]);
        
        $request->merge([
            'user_id' => $request->user()->id,
            'use_for_billing' => $request->use_for_billing ? true : false,
            'e_fatura' => $request->use_for_billing && $request->has('billing_type') && $request->billing_type == 'Kurumsal' && $request->e_fatura ? true : false,
        ]);
        
        $address = UserAddress::create($request->all());
        return back()->with('success','Adres eklendi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserAddress $adre)
    {
        return response()->json([
            'success' => true,
            'html' => View::make('profile.partials.update-address-form',[
                'adres' => $adre
            ])->render()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserAddress $adre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserAddress $adre)
    {
        $request->validate([
            'title' => 'required|string',
            'name' => 'required|string|regex:/^\S+\s+\S+/',
            'email' => 'required|email',
            'phone' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'address' => 'required',
            'billing_type' => [Rule::requiredIf($request->has('use_for_billing') && $request->use_for_billing)],
            'tc_no' => [
                Rule::requiredIf($request->use_for_billing && $request->has('billing_type') && $request->billing_type == 'Bireysel'),
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->use_for_billing && $request->billing_type == 'Bireysel') {
                        if (!is_numeric($value)) {
                            return $fail('TC kimlik numarası sadece sayılardan oluşmalıdır.');
                        }
                        if (strlen($value) !== 11) {
                            return $fail('TC kimlik numarası tam olarak 11 haneli olmalıdır.');
                        }
                    }
                }
            ],
            'company_name' => [Rule::requiredIf($request->use_for_billing && $request->has('billing_type') && $request->billing_type == 'Kurumsal')],
            'vd' => [Rule::requiredIf($request->use_for_billing && $request->has('billing_type') && $request->billing_type == 'Kurumsal')],
            'vkn' => [Rule::requiredIf($request->use_for_billing && $request->has('billing_type') && $request->billing_type == 'Kurumsal')],
        ]);
        
        $request->merge([
            'use_for_billing' => $request->use_for_billing ? true : false,
            'e_fatura' => $request->use_for_billing && $request->has('billing_type') && $request->billing_type == 'Kurumsal' && $request->e_fatura ? true : false,
        ]);
        
        $adre->update($request->all());
        return back()->with('success','Adres güncellendi!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAddress $adre)
    {
        $adre->delete();
        return back();
    }
}

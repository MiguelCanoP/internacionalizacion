<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAgreementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contact_info' => 'required|string|min:10',
            'information' => 'required|string|min:10',
            'status' => 'required|in:vigente,en renovación,vencido',
            'university' => 'required',
            'programs' => 'required',
            'agreement_type' => 'required'
        ];
    }
}

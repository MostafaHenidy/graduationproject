<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHospitalsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'address' => 'required|string',
            'body' => 'required|string|min:10',
            'info' => 'required',
            'cover_image' => 'required',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }
}

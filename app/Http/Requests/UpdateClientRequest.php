<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:3|max:255',
            'is_project' => 'required|boolean',
            'self_capture' => 'required|boolean',
            'client_prefix' => 'required|min:4|max:4',
            'client_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address' => 'required|min:3|max:255',
            'phone_number' => 'required|min:3|max:255',
            'city' => 'required|min:3|max:255',
        ];
    }
}

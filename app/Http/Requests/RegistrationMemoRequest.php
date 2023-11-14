<?php

namespace App\Http\Requests;

class RegistrationMemoRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            //
            'latitude' => ['required', 'numeric', 'regex:/^[-]?((([0-8]?[0-9])(\.[0-9]{6}))|90(\.0{6}))$/'],
            'longitude' => ['required', 'numeric', 'regex:/^[-]?(((([1][0-7][0-9])|([0-9]?[0-9]))(\.[0-9]{6}))|180(\.0{6}))$/'],
            'content' => ['required', 'string', 'regex:/^(?!\s*$).{1,254}$/'],
        ];
    }
}

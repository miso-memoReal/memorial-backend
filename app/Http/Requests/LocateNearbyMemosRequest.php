<?php

namespace App\Http\Requests;

/**
 * @extends ApiRequest<array>
 */
class LocateNearbyMemosRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'latitude' => ['required', 'numeric', 'regex:/^[-]?((([0-8]?[0-9])(\.[0-9]{1,7}))|90(\.0{1,7})?)$/'],
            'longitude' => ['required', 'numeric', 'regex:/^[-]?(((([1][0-7][0-9])|([0-9]?[0-9]))(\.[0-9]{1,7}))|180(\.0{1,7}))$/'],
        ];
    }
}

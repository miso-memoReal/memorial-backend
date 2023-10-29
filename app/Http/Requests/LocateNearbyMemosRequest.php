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
            // TODO: 小数何桁以上を要求するのか確認
            'latitude' => ['required', 'numeric', 'regex:/^[-]?((([0-8]?[0-9])(\.[0-9]{1,}))|90(\.0{1,})?)$/'],
            'longitude' => ['required', 'numeric', 'regex:/^[-]?(((([1][0-7][0-9])|([0-9]?[0-9]))(\.[0-9]{1,}))|180(\.0{1,})?)$/'],
        ];
    }
}

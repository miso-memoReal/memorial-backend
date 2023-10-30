<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @link https://laravel.com/docs/9.x/validation#form-request-validation
 *
 * @template T of array
 */
abstract class ApiRequest extends FormRequest
{
    /**
     * @return T
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);
        assert(is_array($validated));

        return $validated;
    }

    /**
     * 更新、削除時に渡されるルート引数を Request Parametersに含める。
     * ただし、すでにキーが存在している場合は上書きしない。
     */
    public function validationData(): array
    {
        $params = $this->all();
        $route = $this->route();

        if ($route === null) {
            return $params;  // or throw an exception, or handle this case in other way
        }

        $route_params = $route->parameters();

        return $params + $route_params;
    }

    /**
     * @Override
     * 勝手にリダイレクトさせないためのHack
     * バリデーションはFormRequestの拡張ではなくApiRequestの拡張で行うようにすること
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        $data = [
            'message' => 'The given data was invalid.',
            'errors' => $validator->errors()->toArray(),
        ];

        throw new HttpResponseException(response()->json($data, 400));
    }
}

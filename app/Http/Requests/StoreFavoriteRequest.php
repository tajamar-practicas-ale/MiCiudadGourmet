<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFavoriteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            // El Restaurant se obtiene por parámetro {restaurant}; ya validado vía route‑model‑binding
        ];
    }
}

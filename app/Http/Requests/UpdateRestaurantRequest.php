<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantRequest extends FormRequest
{
    public function authorize(): bool
    {
        $restaurant = $this->route('id'); // ID pasado en ruta
        return auth()->check() && auth()->id() === \App\Models\Restaurant::find($restaurant)->user_id;
    }

    public function rules(): array
    {
        return [
            'name'         => 'sometimes|required|string|max:255',
            'description'  => 'nullable|string',
            'address'      => 'sometimes|required|string|max:255',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Restaurant;

class StorePhotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        $restaurant = Restaurant::find($this->route('restaurant'));
        return auth()->check() && auth()->id() === optional($restaurant)->user_id;
    }

    public function rules(): array
    {
        return [
            'url' => 'required|url',
        ];
    }
}

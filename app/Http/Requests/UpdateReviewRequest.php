<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Review;

class UpdateReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        $review = Review::find($this->route('id'));
        return auth()->check() && auth()->id() === optional($review)->user_id;
    }

    public function rules(): array
    {
        return [
            'rating'  => 'sometimes|integer|between:1,5',
            'comment' => 'nullable|string',
        ];
    }
}

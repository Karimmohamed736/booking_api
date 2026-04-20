<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'           => 'sometimes|max:20|string',
            'description'     => 'sometimes|nullable|string',
            'location'        => 'sometimes|nullable',
            'start_date'      => 'sometimes|date',
            'available_seats' => 'sometimes|integer|min:0',
            'category_id'     => 'sometimes|integer|exists:categories,id'
        ];
    }
}

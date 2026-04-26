<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => 'required|max:20|string' ,
            'description' => 'nullable|string',
            'location' =>'nullable' ,
            'start_date'=>'required|date',
            'available_seats'=>'required|integer|min:0',
            'category_id'=> 'required|integer|exists:categories,id',
            'images' => 'required|array', // Validate as an array of files
            'images.*' => 'image|' // Validate each file in the array
        ];
    }
}

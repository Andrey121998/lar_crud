<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'title' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|max:1000',
            'status' => ['required', Rule::in(['pending', 'in_progress', 'completed'])]
        ];
    }
     public function messages(): array
    {
        return [
            'title.required' => 'Название задачи обязательно',
            'title.min' => 'Название должно быть не менее 3 символов',
            'title.max' => 'Название не должно превышать 255 символов',
            'status.required' => 'Статус обязателен',
            'status.in' => 'Статус должен быть: pending, in_progress или completed'
        ];
    }
}

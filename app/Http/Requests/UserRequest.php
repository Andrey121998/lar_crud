<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userId = $this->route('user'); // ID пользователя для обновления

        return [
            'name' => 'required|string|max:255|min:2',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId)
            ],
            'password' => $this->isMethod('POST')
                ? 'required|string|min:8|confirmed'
                : 'sometimes|nullable|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя пользователя обязательно',
            'name.min' => 'Имя должно быть не менее 2 символов',
            'name.max' => 'Имя не должно превышать 255 символов',

            'email.required' => 'Email обязателен',
            'email.email' => 'Введите корректный email адрес',
            'email.max' => 'Email не должен превышать 255 символов',
            'email.unique' => 'Этот email уже используется',

            'password.required' => 'Пароль обязателен при создании пользователя',
            'password.min' => 'Пароль должен быть не менее 8 символов',
            'password.confirmed' => 'Пароли не совпадают',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if ($this->isMethod('POST') && !$this->filled('password')) {
            // Для создания - генерируем пароль если не указан
            $this->merge([
                'password' => bin2hex(random_bytes(8)), // случайный пароль 16 символов
            ]);
        }
    }
}

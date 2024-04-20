<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:30',
            'username' => 'required|string|min:6|max:20|unique:users',
            'phone' => 'required|string|min:6|max:22|unique:users',
            'email' => 'required|email:rfc,dns|string|max:40|unique:users',
            'password' => 'required|min:8|max:18|confirmed',
            'gender' => 'required|string',
            'address' => 'nullable|string|max:255',
            'profile_picture' =>'nullable|file|image|mimes:jpeg,png,jpg|max:4024',
            'cover_photo' =>'nullable|file|image|mimes:jpeg,png,jpg|max:4024',
            'bio' => 'nullable|string|max:255'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}

<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $id = $this->route('user')->id;
        $user = User::firstWhere('id', $id);
        return Gate::allows('update', $user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // $user = auth()->user();
        return [
            'name' => 'nullable|string|min:3|max:30',
            // 'username' => 'nullable|string|max:20|unique:users,username,' . $user->id . ',id',
            // 'phone' => 'nullable|string|max:22|unique:users,phone,' . $user->id . ',id',
            // 'email' => 'nullable|email:rfc,dns|string|max:40|unique:users,email,' . $user->id . ',id',
            // 'password' => 'nullable|confirmed',
            // 'gender' => 'nullable|string',
            // 'address' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4024',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4024',
            'bio' => 'nullable|string|max:255',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'failed',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}

<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Propaganistas\LaravelPhone\Rules\Phone;

class RegisterRequest extends FormRequest
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
            'country' => [Rule::requiredIf($this->has('phone')), 'string', 'exists:tm_countries,iso_3166_2'],
            'username' => ['required', 'string', 'lowercase', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => [Rule::requiredIf($this->has('country')), 'unique:'.User::class, (new Phone)->countryField('country')],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     *
     * @throws \libphonenumber\NumberParseException|\Exception
     */
    protected function prepareForValidation()
    {
        if ($this->has('phone') && $this->has('country')) {
            $this->merge([
                'phone' => parse_phone($this->input('phone'), $this->country),
            ]);
        }

    }
}

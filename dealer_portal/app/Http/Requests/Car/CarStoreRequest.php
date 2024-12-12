<?php

namespace App\Http\Requests\Car;

use App\Models\Language;
use App\Rules\ImageMimeTypeRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CarStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'slider_images' => 'required',
            'price' => 'required',
        ];

        $languages = Language::all();

        foreach ($languages as $language) {
            $rules[$language->code . '_title'] = 'required|max:255';
            $rules[$language->code . '_category_id'] = 'required';
            $rules[$language->code . '_description'] = 'required|min:15';
        }

        return $rules;
    }

    /**
     * Get the validation error messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        $messageArray = [];

        $languages = Language::all();

        foreach ($languages as $language) {
            $messageArray[$language->code . '_title.required'] = 'The title field is required';
            $messageArray[$language->code . '_title.max'] = 'The title field cannot contain more than 255 characters';
            $messageArray[$language->code . '_category_id.required'] = 'The category field is required';
            $messageArray[$language->code . '_description.required'] = 'The description field is required';
            $messageArray[$language->code . '_description.min'] = 'The description field must have at least 15 characters';
        }

        $messageArray['slider_images.required'] = 'The slider images field is required';
        $messageArray['price.required'] = 'The price field is required';

        return $messageArray;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(
            response()->json(['errors' => $errors], 422)
        );
    }
}


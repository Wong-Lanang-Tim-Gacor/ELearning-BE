<?php

namespace App\Http\Requests;

use App\Enums\OptionsTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuizOptionRequest extends FormRequest
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
            'quiz_id' => 'required|exists:quiz,id',
            'options' => 'required|string',
            'type' => [
                Rule::enum(OptionsTypeEnum::class),
                'required',
            ]
        ];
    }
}

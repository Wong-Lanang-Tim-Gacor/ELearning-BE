<?php

namespace App\Http\Requests;

use App\Traits\ValidatesRequest;
use Illuminate\Foundation\Http\FormRequest;

class ModuleMaterialRequest extends FormRequest
{
    use ValidatesRequest;
    
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
            'course_module_id' => 'required|exists:course_modules,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ];
    }
}

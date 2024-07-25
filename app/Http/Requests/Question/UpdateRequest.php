<?php

namespace App\Http\Requests\Question;

use App\Rules\WithQuestionMark;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question' => [
                'required',
                'min:10',
                new WithQuestionMark(),
                Rule::unique('questions')->ignore($this->route()->question->id), //@phpstan-ignore-line
            ],
        ];
    }
}

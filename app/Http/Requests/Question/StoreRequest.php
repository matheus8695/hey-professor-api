<?php

namespace App\Http\Requests\Question;

use App\Rules\WithQuestionMark;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'question' => ['required', new WithQuestionMark()],
        ];
    }
}

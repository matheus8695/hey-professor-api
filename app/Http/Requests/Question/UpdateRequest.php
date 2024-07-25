<?php

namespace App\Http\Requests\Question;

use App\Models\Question;
use App\Rules\{WithQuestionMark, onlyAsDraft};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Question $question */
        $question = $this->route()->question; // @phpstan-ignore-line

        return Gate::allows('update', $question);
    }

    public function rules(): array
    {
        /** @var Question $question */
        $question = $this->route()->question; // @phpstan-ignore-line

        return [
            'question' => [
                'required',
                'min:10',
                new WithQuestionMark(),
                new onlyAsDraft($question),
                Rule::unique('questions')->ignoreModel($question),
            ],
        ];
    }
}

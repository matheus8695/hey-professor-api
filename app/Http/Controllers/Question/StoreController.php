<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\StoreRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request): QuestionResource
    {
        $question = Question::create([
            'user_id'  => auth()->user()->id,
            'question' => $request->question,
            'status'   => 'draft',
        ]);

        return QuestionResource::make($question);
    }
}

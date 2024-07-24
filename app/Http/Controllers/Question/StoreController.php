<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\StoreRequest;
use App\Models\Question;
use Illuminate\Http\Response;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $question = Question::create([
            'user_id'  => auth()->user()->id,
            'question' => $request->question,
            'status'   => 'draft',
        ]);

        return response([
            'data' => [
                'id'         => $question->id,
                'question'   => $question->question,
                'status'     => $question->status,
                'created_at' => $question->created_at->format('Y-m-d'),
                'updated_at' => $question->updated_at->format('Y-m-d'),
            ],
        ], Response::HTTP_CREATED);
    }
}

<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Requests\Question\StoreRequest;
use App\Models\Question;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        Question::create([
            'user_id'  => auth()->user()->id,
            'question' => $request->question,
            'status'   => 'draft',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Response;

class DeleteController extends Controller
{
    public function __invoke(Question $question): Response
    {
        $question->forceDelete();

        return response()->noContent();
    }
}

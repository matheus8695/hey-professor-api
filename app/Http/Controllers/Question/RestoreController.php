<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;

class RestoreController extends Controller
{
    public function __invoke(int $id)
    {
        $question = Question::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $question);
        $question->restore();

        return response()->noContent();
    }
}

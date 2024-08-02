<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Models\Question;

class IndexController extends Controller
{
    public function __invoke()
    {
        $questions = Question::query()
            ->published()
            ->search(request()->q)
            ->withSum('votes', 'like')
            ->withSum('votes', 'unlike')
            ->paginate();

        return QuestionResource::collection($questions);
    }
}

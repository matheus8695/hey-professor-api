<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;

class VoteController extends Controller
{
    public function __invoke(Question $question, string $vote)
    {
        $question->votes()
            ->create([
                'user_id' => user()->id,
                $vote     => 1,
            ]);

        return response()->noContent();
    }
}

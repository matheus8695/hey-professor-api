<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Support\Facades\Validator;

class VoteController extends Controller
{
    public function __invoke(Question $question, string $vote)
    {
        Validator::validate(
            compact('vote'),
            ['vote' => ['required', 'in:like,unlike']]
        );

        $question->votes()
            ->create([
                'user_id' => user()->id,
                $vote     => 1,
            ]);

        return response()->noContent();
    }
}

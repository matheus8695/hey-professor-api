<?php

namespace App\Policies;

use App\Models\{Question, User};

class QuestionPolicy
{
    public function viewAny(User $user)
    {

    }

    public function view(User $user, Question $question)
    {

    }

    public function create(User $user)
    {

    }

    public function update(User $user, Question $question): bool
    {
        return $user->is($question->user);
    }

    public function delete(User $user, Question $question)
    {

    }

    public function restore(User $user, Question $question)
    {

    }

    public function forceDelete(User $user, Question $question)
    {

    }
}

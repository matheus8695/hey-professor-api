<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\{assertDatabaseHas, postJson};

it('should be able to like a question', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $question = Question::factory()->published()->create();

    postJson(
        route('questions.vote', [
            'question' => $question,
            'vote'     => 'like',
        ])
    )->assertNoContent();

    expect($question->votes)
        ->toHaveCount(1);

    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'user_id'     => $user->id,
        'like'        => 1,
    ]);
});

it('should be able to unlike a question', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $question = Question::factory()->published()->create();

    postJson(
        route('questions.vote', [
            'question' => $question,
            'vote'     => 'unlike',
        ])
    )->assertNoContent();

    expect($question->votes)
        ->toHaveCount(1);

    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'user_id'     => $user->id,
        'unlike'      => 1,
    ]);
});

it('should guarantee that only the words like and unlike are been used to vote', function ($vote, $status) {
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $question = Question::factory()->published()->create();

    postJson(
        route('questions.vote', [
            'question' => $question,
            'vote'     => $vote,
        ])
    )->assertStatus($status);
})->with([
    'like'           => ['like', 204],
    'unlike'         => ['unlike', 204],
    'something-else' => ['something-else', 422],
]);

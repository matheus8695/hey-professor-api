<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\{assertDatabaseHas, putJson};

it('should be able to update a new question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(['user_id' => $user->id]);

    Sanctum::actingAs($user);

    putJson(route('questions.update', $question), [
        'question' => 'Update question ?',
    ])->assertOk();

    assertDatabaseHas('questions', [
        'id'       => $question->id,
        'user_id'  => $user->id,
        'question' => 'Update question ?',
    ]);
});

describe('validation rules', function () {
    test('question::required', function () {
        $user     = User::factory()->create();
        $question = Question::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        putJson(route('questions.update', $question), [
            'question' => '',
        ])->assertJsonValidationErrors([
            'question' => 'required',
        ]);
    });

    test('question::ending with a question mark', function () {
        $user     = User::factory()->create();
        $question = Question::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        putJson(route('questions.update', $question), [
            'question' => 'Question without a question mark',
        ])
            ->assertJsonValidationErrors([
                'question' => 'The question should end with question mark (?).',
            ]);
    });

    test('question::min characters should be 10', function () {
        $user     = User::factory()->create();
        $question = Question::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        putJson(route('questions.update', $question), [
            'question' => 'Question',
        ])
            ->assertJsonValidationErrors([
                'question' => 'least 10 characters.',
            ]);
    });

    test('question::should be unique', function () {
        $user     = User::factory()->create();
        $question = Question::factory()->create(['user_id' => $user->id]);

        Question::factory()->create([
            'question' => 'Lorem ipsum jeremias?',
            'status'   => 'draft',
            'user_id'  => $user->id,
        ]);

        Sanctum::actingAs($user);

        putJson(route('questions.update', $question), [
            'question' => 'Lorem ipsum jeremias?',
        ])
            ->assertJsonValidationErrors([
                'question' => 'already been taken',
            ]);
    });

    test('question::should be unique only if ID is different', function () {
        $user     = User::factory()->create();
        $question = Question::factory()->create([
            'user_id'  => $user->id,
            'question' => 'Lorem ipsum jeremias?',
        ]);

        Sanctum::actingAs($user);

        putJson(route('questions.update', $question), [
            'question' => 'Lorem ipsum jeremias?',
        ])->assertOk();
    });
});

describe('security', function () {
    test('only the person who create the question can update the same question', function () {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $question = Question::factory()->create(['user_id' => $user1->id]);

        Sanctum::actingAs($user2);

        putJson(route('questions.update', $question), [
            'question' => 'updating a question ?',
        ])->assertForbidden();

        assertDatabaseHas('questions', [
            'id'       => $question->id,
            'question' => $question->question,
        ]);
    });
});

<?php

use App\Models\{Question, User};
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\{assertDatabaseHas, postJson};

it('should be able to store a new question', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    postJson(route('questions.store', [
        'question' => 'Lorem ipsum jeremias?',
    ]))->assertSuccessful();

    assertDatabaseHas('questions', [
        'user_id'  => $user->id,
        'question' => 'Lorem ipsum jeremias?',
    ]);
});

test('With the creating of the question I need to make sure that it creates on _draft_ status', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    postJson(route('questions.store', [
        'question' => 'Lorem ipsum jeremias?',
    ]))->assertSuccessful();

    assertDatabaseHas('questions', [
        'user_id'  => $user->id,
        'status'   => 'draft',
        'question' => 'Lorem ipsum jeremias?',
    ]);
});

describe('validation rules', function () {
    test('question::required', function () {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        postJson(route('questions.store', []))
            ->assertJsonValidationErrors([
                'question' => 'required',
            ]);
    });

    test('question::ending with a question mark', function () {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        postJson(route('questions.store', [
            'question' => 'Question without a question mark',
        ]))
            ->assertJsonValidationErrors([
                'question' => 'The question should end with question mark (?).',
            ]);
    });

    test('question::min characters should be 10', function () {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        postJson(route('questions.store', [
            'question' => 'Question',
        ]))
            ->assertJsonValidationErrors([
                'question' => 'least 10 characters.',
            ]);
    });

    test('question::should be unique', function () {
        $user = User::factory()->create();

        Question::factory()->create([
            'question' => 'Lorem ipsum jeremias?',
            'status'   => 'draft',
            'user_id'  => $user->id,
        ]);

        Sanctum::actingAs($user);

        postJson(route('questions.store', [
            'question' => 'Lorem ipsum jeremias?',
        ]))
            ->assertJsonValidationErrors([
                'question' => 'already been taken',
            ]);
    });
});

test('after creating we should return a status 201 with the created question', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $request = postJson(route('questions.store', [
        'question' => 'Lorem ipsum jeremias?',
    ]))->assertCreated();

    $question = Question::latest()->first();

    $request->assertJson([
        'data' => [
            'id'         => $question->id,
            'question'   => $question->question,
            'status'     => $question->status,
            'created_by' => [
                'id'   => $user->id,
                'name' => $user->name,
            ],
            'created_at' => $question->created_at->format('Y-m-d h:i:s'),
            'updated_at' => $question->updated_at->format('Y-m-d h:i:s'),
        ],
    ]);
});

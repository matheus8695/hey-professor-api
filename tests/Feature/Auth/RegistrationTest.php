<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\{assertDatabaseHas, postJson};
use function PHPUnit\Framework\assertTrue;

it('should be able to register in application', function () {
    postJson(route('register'), [
        'name'     => 'Joe Doe',
        'email'    => 'joe@doe.com',
        'password' => 'password',
    ])->assertSessionHasNoErrors();

    assertDatabaseHas('users', [
        'name'  => 'Joe Doe',
        'email' => 'joe@doe.com',
    ]);

    $joeDoe = User::whereEmail('joe@doe.com')->first();

    assertTrue(Hash::check('password', $joeDoe->password));
});

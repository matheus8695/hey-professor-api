<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\{actingAs, assertGuest, postJson};

it('should be able to logout', function () {
    $user = User::factory()->create([
        'email'    => 'joe@doe.com',
        'password' => Hash::make('password'),
    ]);

    actingAs($user);

    postJson(route('logout'))->assertNoContent();
    assertGuest();
});

<?php

use Illuminate\Support\Facades\Mail;
use Sajjadgol\PasswordChangedNotification\Tests\Model\User;

it('can send mail to users when password is changed', function () {

    Mail::fake();

    $user = User::factory()->create();

    $user->password = bcrypt('password');
    $user->save();

    Mail::assertSent($user->passwordChangedNotificationMail()::class);

});

it('will not send email when user password not change', function () {
    Mail::fake();

    $user = User::factory()->create();
    $user->name = 'sajjad';
    $user->save();

    Mail::assertNotSent($user->passwordChangedNotificationMail()::class);

});

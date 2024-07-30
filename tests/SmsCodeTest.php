<?php

use Joy2fun\FilamentExt\Models\SmsCode;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('throws when missing sender', function () {
    SmsCode::using(null);
    SmsCode::generate('123');
})->throws(\Exception::class);

it('can generate code', function () {
    $mobile = time();
    $new = null;
    SmsCode::using(function ($model) use (&$new) {
        $new = $model;
    });
    SmsCode::generate($mobile);
    $this->assertDatabaseHas('sms_codes', ['mobile' => $mobile]);
    expect(SmsCode::canSendAfter($mobile))
        ->toBeLessThanOrEqual(60)
        ->toBeGreaterThan(50);
    expect(SmsCode::attempt($mobile, $new->code))->toBeTrue();
});

it('can regenerate code', function () {
    SmsCode::truncate();
    $mobile = time();
    $this->assertDatabaseMissing('sms_codes', ['mobile' => $mobile]);
    expect(SmsCode::canSendAfter($mobile))->toBe(0);
});
<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Joy2fun\FilamentExt\Models\SmsCode;

uses(RefreshDatabase::class);

it('throws', function () {
    SmsCode::generate('123', function (string $mobile, string $code) {
        throw new Exception("send failed");
    });
})->throws(Exception::class);

it('can generate code', function () {
    $mobile = '1' . time(); // 11位
    $newCode = '';
    SmsCode::generate($mobile, function (string $mobile, string $code) use (&$newCode) {
        $newCode = $code;
    });
    $this->assertDatabaseHas('sms_codes', ['mobile' => $mobile]);
    expect(SmsCode::canSendAfter($mobile))
        ->toBeLessThanOrEqual(60)
        ->toBeGreaterThan(50);
    expect(SmsCode::attempt($mobile, $newCode))->toBeTrue();
});

it('can regenerate code', function () {
    SmsCode::truncate();
    $mobile = time();
    $this->assertDatabaseMissing('sms_codes', ['mobile' => $mobile]);
    expect(SmsCode::canSendAfter($mobile))->toBe(0);
});

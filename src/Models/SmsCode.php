<?php

namespace Joy2fun\FilamentExt\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SmsCode extends Model
{
    use HasFactory;

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    protected static $createdCallback;

    public static function using(\Closure $callback)
    {
        static::$createdCallback = $callback;
    }

    public static function generate(string $mobile)
    {
        DB::transaction(function () use ($mobile) {
            $row = new self([
                'mobile' => $mobile,
                'code' => rand(100000, 999999),
                'expired_at' => now()->addMinutes(10),
            ]);
            $row->save();
        });
    }

    public static function canSendAfter(string $mobile): int
    {
        $row = self::where('mobile', $mobile)
            ->where('created_at', '>', now()->addSeconds(-55))
            ->first();

        if ($row) {
            return max(0, $row->created_at->diffInSeconds(now()->addSeconds(-59)));
        }

        return 0;
    }

    public static function attempt(string $mobile, string $code): bool
    {
        return self::where('mobile', $mobile)
            ->where('code', $code)
            ->where('expired_at', '>', now())
            ->exists();
    }

    protected static function booted(): void
    {
        parent::boot();

        static::created(function (SmsCode $model) {
            if (is_callable(static::$createdCallback)) {
                call_user_func(static::$createdCallback, $model);
            } else {
                throw new Exception('config sender via SmsCode::using()');
            }
        });
    }
}

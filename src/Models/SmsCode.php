<?php

namespace Joy2fun\FilamentExt\Models;

use Closure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SmsCode extends Model
{
    use HasFactory;

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    /**
     * @return SmsCode
     */
    public static function generate(string $mobile, Closure $sender)
    {
        return DB::transaction(function () use ($mobile, $sender) {
            $row = new self([
                'mobile' => $mobile,
                'code' => rand(100000, 999999),
                'expired_at' => now()->addMinutes(10),
            ]);
            $row->save();
            call_user_func($sender, $row->mobile, $row->code);

            return $row;
        });
    }

    public static function canSendAfter(string $mobile): int
    {
        $row = self::where('mobile', $mobile)
            ->where('created_at', '>', now()->addSeconds(-55))
            ->first();

        if ($row) {
            return max(0, 60 - (now()->unix() - $row->created_at->unix()));
        }

        return 0;
    }

    public static function attempt(string $mobile, string $code): bool
    {
        if (strlen($mobile) < 11) {
            return false;
        }

        if (strlen($code) < 6) {
            return false;
        }

        return self::where('mobile', $mobile)
            ->where('code', $code)
            ->where('expired_at', '>', now())
            ->exists();
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sms_codes', function (Blueprint $table) {
            $table->id();
            $table->string('mobile', 15)->default('');
            $table->unsignedInteger('code')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });
    }
};

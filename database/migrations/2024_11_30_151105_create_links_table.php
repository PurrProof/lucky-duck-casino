<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLinksTable extends Migration
{
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->uuid('code')->unique();
            $table->timestamp('valid_until');
            $table->boolean('is_deactivated')->default(false);
            $table->timestamps();
        });

        $userId = DB::table('users')->first()->id;

        DB::table('links')->insert([
            'user_id' => $userId,
            'code' => \Illuminate\Support\Str::uuid(),
            'valid_until' => now()->addDays(config('my.link_validity_mins')),
            'is_deactivated' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('links');
    }
}

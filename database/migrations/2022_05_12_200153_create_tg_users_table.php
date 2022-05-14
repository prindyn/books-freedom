<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTgUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tg_users', function (Blueprint $table) {
            $table->id();
            $table->string('tg_id', 255)->unique();
            $table->foreignId('user_id')
                ->unique()
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('first_name', 150)->nullable();
            $table->string('last_name', 150)->nullable();
            $table->string('username', 150);
            $table->string('phone', 50)->nullable();
            $table->tinyInteger('is_bot')->default(0);
            $table->string('lang_code', 10)->default('ua');
            $table->string('type', 50)->default('private');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tg_users');
    }
}

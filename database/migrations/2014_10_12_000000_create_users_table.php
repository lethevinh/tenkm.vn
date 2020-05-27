<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('phone')->unique()->nullable();
                $table->string('username')->unique();
                $table->enum('type_lb', array_keys(\App\Models\User::TYPES))->default('guest');
                $table->string('provider')->nullable();
                $table->string('provider_id')->nullable();
                $table->string('avatar')->nullable();
                $table->string('address')->nullable();
                $table->text('description')->nullable();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('userable')) {
            Schema::create('userable', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id');
                $table->nullableMorphs('userable');
                $table->unique(['user_id', 'userable_id', 'userable_type'], 'userable_ids_type_unique');
                $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->index('userable_type', 'userable_id');
                $table->string('type_lb')->default('teacher')->comment('teacher,student');
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('userable');
    }
}

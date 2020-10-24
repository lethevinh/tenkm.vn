<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_lb')->nullable();
            $table->string('slug_lb')->unique();
            $table->index(['slug_lb']);
            $table->integer('rating_nb');
            $table->text('body_lb');
            $table->enum('status_sl', array_keys(\App\Models\Post::STATUS))->default('draft');
            $table->morphs('ratingable');
            $table->morphs('creator');
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
        Schema::dropIfExists('ratings');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('reactions')) {
            Schema::create('reactions', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title_lb');
                $table->string('slug_lb')->unique();
                $table->text('description_lb')->nullable();
                $table->text('content_lb')->nullable();
                $table->text('image_lb')->nullable();
                $table->enum('status_sl', [array_keys(\App\Models\Post::STATUS)])->default('draft');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('reactable')) {
            Schema::create('reactable', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('reaction_id');
                $table->morphs('reactable');
                $table->unique(['reaction_id', 'reactable_id', 'reactable_type'], 'reactable_ids_type_unique');
                $table->foreign('reaction_id')->references('id')->on('reactions')
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->index('reactable_type', 'reactable_id');
                $table->morphs('creator');
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
        Schema::dropIfExists('reactions');
        Schema::dropIfExists('reactable');
    }
}

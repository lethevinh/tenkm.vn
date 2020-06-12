<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->text('title_lb');
            $table->text('slug_lb');
            $table->string('language_lb')->default('vi');
            $table->unsignedInteger('translation_id')->nullable();
            $table->text('image_lb')->nullable();
            $table->string('type_lb')->default('post');
            $table->text('description_lb')->nullable();
            $table->text('content_lb')->nullable();
            $table->unsignedInteger('post_nb')->default(0);
            $table->enum('status_sl', ['public', 'draft', 'private', 'trash'])
                ->default('draft');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->integer('order_column')->nullable();
            $table->timestamps();
        });

        Schema::create('taggable', function (Blueprint $table) {
            $table->integer('tag_id')->unsigned();
            $table->morphs('taggable');
            $table->unique(['tag_id', 'taggable_id', 'taggable_type']);
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
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
        Schema::dropIfExists('taggable');
        Schema::dropIfExists('tags');
    }
}

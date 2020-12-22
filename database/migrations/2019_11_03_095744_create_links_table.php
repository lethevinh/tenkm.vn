<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_lb');
            $table->string('link_lb')->unique()->nullable();
            $table->string('slug_lb')->unique();
            $table->index(['slug_lb']);
            $table->text('image_lb')->nullable();
            $table->string('type_lb')->default('post');
            $table->string('template_lb')->nullable()->default('post');
            $table->string('language_lb')->default('vi');
            $table->unsignedInteger('translation_id')->nullable();
            $table->index(['slug_lb', 'type_lb']);
            $table->text('meta_lb')->nullable();
            $table->text('description_lb')->nullable();
            $table->text('content_lb')->nullable();
            $table->enum('status_sl', ['public', 'draft', 'private', 'trash'])
                ->default('draft');
            $table->morphs('contentable');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamp('published_at')->useCurrent();
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
        Schema::dropIfExists('links');
    }
}

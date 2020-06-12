<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Kalnoy\Nestedset\NestedSet;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title_lb');
                $table->string('language_lb')->default('vi');
                $table->unsignedInteger('translation_id')->nullable();
                $table->string('slug_lb')->unique();
                $table->index(['slug_lb']);
                $table->text('image_lb')->nullable();
                $table->string('type_lb')->default('post');
                $table->index(['slug_lb', 'type_lb']);
                $table->text('description_lb')->nullable();
                $table->text('content_lb')->nullable();
                $table->unsignedInteger('post_nb')->default(0);
                $table->enum('status_sl', ['public', 'draft', 'private', 'trash'])
                    ->default('draft');
                $table->nestedSet();
                $table->unsignedInteger('created_by')->nullable();
                $table->unsignedInteger('updated_by')->nullable();
                $table->timestamp('published_at')->useCurrent();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('categorizable')) {
            Schema::create('categorizable', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('category_id');
                $table->nullableMorphs('categorizable');
                $table->unique(['category_id', 'categorizable_id', 'categorizable_type'], 'categorizable_ids_type_unique');
                $table->foreign('category_id')->references('id')->on('categories')
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->index('categorizable_type', 'categorizable_id');
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
        Schema::dropIfExists('categories');
        Schema::dropIfExists('categorizable');
    }
}

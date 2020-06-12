<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title_lb');
                $table->string('template_lb')->default('default');
                $table->string('language_lb')->default('vi');
                $table->unsignedInteger('translation_id')->nullable();
                $table->string('slug_lb')->unique();
                $table->index(['slug_lb']);
                $table->text('image_lb')->nullable();
                $table->string('type_lb')->default('post');
                $table->index(['slug_lb', 'type_lb']);
                $table->text('description_lb')->nullable();
                $table->text('content_lb')->nullable();
                $table->unsignedInteger('rating_nb')->default(0);
                $table->unsignedInteger('view_nb')->default(0);
                $table->unsignedInteger('comment_nb')->default(0);
                $table->unsignedInteger('share_nb')->default(0);
                $table->enum('status_sl', array_keys(\App\Models\Model::STATUS))->default('draft');
                $table->unsignedInteger('created_by')->nullable();
                $table->unsignedInteger('updated_by')->nullable();
                $table->timestamp('published_at')->useCurrent();
                $table->timestamp('validated_at')->nullable();
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
        Schema::dropIfExists('posts');
    }
}

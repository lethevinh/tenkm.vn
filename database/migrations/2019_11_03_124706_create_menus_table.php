<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title_lb');
            $table->string('slug_lb')->nullable();
            $table->string('language_lb')->default('vi');
            $table->string('media_lb')->nullable();
            $table->string('url_lb');
            $table->text('content_lb')->nullable();
            $table->integer('order_nb')->default(0);
            $table->nestedSet();
            $table->enum('status_sl', ['public', 'draft', 'private', 'trash'])
                ->default('draft');
            $table->unsignedInteger('link_id')->nullable();
            $table->foreign('link_id')->references('id')->on('links')->onDelete('cascade');
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
        Schema::dropIfExists('menus');
    }
}

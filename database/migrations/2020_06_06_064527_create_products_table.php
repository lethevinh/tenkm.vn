<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_lb');
            $table->string('location_lb')->comment('lat:lng');
            $table->string('address_lb')->comment('full path');
            $table->string('slug_lb')->unique();
            $table->index(['slug_lb']);
            $table->float('price_fl', 10, 0)->default(0);
            $table->float('price_sale_fl', 10, 0)->default(0);
            $table->text('image_lb')->nullable();
            $table->text('gallery_lb')->nullable();
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

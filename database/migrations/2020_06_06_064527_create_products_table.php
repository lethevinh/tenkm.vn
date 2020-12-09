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
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title_lb');
                $table->string('property_id')->nullable();
                $table->string('property_type')->nullable();
                $table->string('furnishing_status')->nullable();
                $table->string('video_lb')->nullable();
                $table->string('language_lb')->default('vi');
                $table->unsignedInteger('translation_id')->nullable();
                $table->string('slug_lb')->unique();
                $table->index(['slug_lb']);
                $table->float('price_fl', 10, 0)->default(0);
                $table->float('price_sale_fl', 10, 0)->default(0);
                $table->string('price_lb')->nullable();
                $table->string('image_lb')->nullable();
                $table->text('gallery_lb')->nullable();
                $table->string('video_lb')->nullable();
                $table->string('streetview_lb')->nullable();
                $table->string('floorplan_lb')->nullable();
                $table->string('living_room_lb')->nullable();
                $table->string('garage_lb')->nullable();
                $table->string('dining_area')->nullable();
                $table->string('gym_area')->nullable();
                $table->text('description_lb')->nullable();
                $table->text('content_lb')->nullable();
                $table->unsignedInteger('bedroom_nb')->default(0);
                $table->unsignedInteger('bathroom_nb')->default(0);
                $table->unsignedInteger('area_nb')->default(0);
                $table->unsignedInteger('parking_nb')->default(0);
                $table->unsignedInteger('rating_nb')->default(0);
                $table->unsignedInteger('view_nb')->default(0);
                $table->unsignedInteger('comment_nb')->default(0);
                $table->unsignedInteger('share_nb')->default(0);
                $table->unsignedInteger('address_id')->nullable();
                $table->foreign('address_id')->references('id')->on('address')->onDelete('cascade');
                $table->unsignedInteger('project_id')->nullable();
                $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}

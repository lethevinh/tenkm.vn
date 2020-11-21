<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('projects')) {
            Schema::create('projects', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title_lb');
                $table->string('language_lb')->default('vi');
                $table->unsignedInteger('translation_id')->nullable();
                $table->string('slug_lb')->unique();
                $table->index(['slug_lb']);
                $table->float('price_fl', 10, 0)->default(0);
                $table->float('price_sale_fl', 10, 0)->default(0);
                $table->string('price_lb')->nullable();
                $table->string('image_lb')->nullable();
                $table->text('gallery_lb')->nullable();
                $table->text('gallery_3d_lb')->nullable();
                $table->string('video_lb')->nullable();
                $table->string('type_lb')->nullable();
                $table->string('document_lb')->nullable();
                $table->string('streetview_lb')->nullable();
                $table->string('floorplan_lb')->nullable();
                $table->string('area_lb')->default(0);
                $table->string('apartment_type')->nullable();
                $table->string('management_company')->nullable();
                $table->string('design_company')->nullable();
                $table->timestamp('delivery_time')->nullable();
                $table->enum('sale_status_sl', ['open', 'coming_soon', 'pending', 'close'])->default('open');
                $table->text('description_lb')->nullable();
                $table->text('content_lb')->nullable();
                $table->unsignedInteger('bedroom_nb')->default(0);
                $table->unsignedInteger('bathroom_nb')->default(0);
                $table->unsignedInteger('area_nb')->default(0);
                $table->unsignedInteger('total_area_nb')->default(0);
                $table->unsignedInteger('block_nb')->default(0);
                $table->unsignedInteger('floor_nb')->default(0);
                $table->unsignedInteger('department_nb')->default(0);
                $table->unsignedInteger('shop_nb')->default(0);
                $table->unsignedInteger('rating_nb')->default(0);
                $table->unsignedInteger('view_nb')->default(0);
                $table->unsignedInteger('comment_nb')->default(0);
                $table->unsignedInteger('share_nb')->default(0);
                $table->unsignedInteger('address_id')->nullable();
                $table->foreign('address_id')->references('id')->on('address')->onDelete('cascade');
                $table->enum('status_sl', array_keys(\App\Models\Model::STATUS))->default('draft');
                $table->unsignedInteger('created_by')->nullable();
                $table->unsignedInteger('updated_by')->nullable();
                $table->timestamp('opened_at')->nullable();
                $table->timestamp('stopped_at')->nullable();
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
        Schema::dropIfExists('projects');
    }
}

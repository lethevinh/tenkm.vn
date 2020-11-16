<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('locations')) {
            Schema::create('locations', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title_lb');
                $table->string('code_lb')->nullable();
                $table->string('prefix_lb')->nullable();
                $table->string('location_lb')->nullable()->comment('lat:lng');
                $table->string('address_lb')->nullable()->comment('full path');
                $table->string('slug_lb')->unique();
                $table->index(['slug_lb']);
                $table->text('image_lb')->nullable();
                $table->string('type_lb')->nullable()->comment('city,district,ward,project,street');
                $table->index(['slug_lb', 'type_lb']);
                $table->text('description_lb')->nullable();
                $table->text('content_lb')->nullable();
                $table->enum('status_sl', array_keys(\App\Models\Post::STATUS))->default('draft');
                $table->nestedSet();
                $table->unsignedInteger('created_by')->nullable();
                $table->unsignedInteger('updated_by')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('locationable')) {
            Schema::create('locationable', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('location_id');
                $table->nullableMorphs('locationable');
                $table->unique(['location_id', 'locationable_id', 'locationable_type'], 'locationable_ids_type_unique');
                $table->foreign('location_id')->references('id')->on('locations')
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->index('locationable_type', 'locationable_id');
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('address')) {
            Schema::create('address', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('provincial_id');
                $table->foreign('provincial_id')->references('id')->on('locations')
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->unsignedInteger('district_id')->nullable();
                $table->foreign('district_id')->references('id')->on('locations')
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->unsignedInteger('ward_id')->nullable();
                $table->foreign('ward_id')->references('id')->on('locations')
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->unsignedInteger('street_id')->nullable();
                $table->foreign('street_id')->references('id')->on('locations')
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->unsignedInteger('postal_code_nb')->nullable();
                $table->text('address_lb')->nullable();
                $table->text('location_lb')->nullable();
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
        Schema::dropIfExists('locations');
        Schema::dropIfExists('locationable');
        Schema::dropIfExists('address');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmenitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amenities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_lb');
            $table->text('description_lb')->nullable();
            $table->string('slug_lb')->unique();
            $table->timestamps();
        });
        if (!Schema::hasTable('amenitable')) {
            Schema::create('amenitable', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('amenity_id');
                $table->morphs('amenitable');
                $table->unique(['amenity_id', 'amenitable_id', 'amenitable_type'], 'amenitable_ids_type_unique');
                $table->foreign('amenity_id')->references('id')->on('amenities')
                    ->onDelete('cascade')->onUpdate('cascade');
                $table->index('amenitable_type', 'amenitable_id');
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
        Schema::dropIfExists('amenities');
        Schema::dropIfExists('amenitable');
    }
}

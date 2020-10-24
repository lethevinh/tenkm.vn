<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetadataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('metadata')) {
            Schema::create('metadata', function (Blueprint $table) {
                $table->increments('id');
                $table->string('key_lb');
                $table->string('label_lb')->nullable();
                $table->longText('value_lb')->nullable();
                $table->string('type_lb')->default('text');
                $table->enum('status_sl', ['public', 'draft', 'private', 'trash'])->default('public');
                $table->morphs('metadatable');
                $table->unique(['metadatable_id', 'key_lb', 'metadatable_type'], 'metadatable_ids_key_unique');
                $table->index(['metadatable_id', 'key_lb', 'metadatable_type']);
                $table->unsignedInteger('created_by')->nullable();
                $table->unsignedInteger('updated_by')->nullable();
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('fieldable')) {
            Schema::create('fieldable', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name_lb');
                $table->integer('order_nb')->default(0);
                $table->string('label_lb')->nullable();
                $table->longText('default_lb')->nullable();
                $table->string('type_lb')->default('text');
                $table->enum('status_sl', ['public', 'draft', 'private', 'trash'])->default('public');
                $table->morphs('fieldable');
                $table->unique(['fieldable_id', 'name_lb', 'fieldable_type'], 'fieldable_ids_key_unique');
                $table->index(['fieldable_id', 'name_lb', 'fieldable_type']);
                $table->unsignedInteger('created_by')->nullable();
                $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('metadata');
        Schema::dropIfExists('fieldable');
    }
}

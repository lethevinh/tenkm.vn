<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title_lb');
                $table->string('slug_lb')->unique();
                $table->index(['slug_lb']);
                $table->text('image_lb')->nullable();
                $table->text('description_lb')->nullable();
                $table->text('content_lb')->nullable();
                $table->enum('status_sl', ['public', 'draft', 'private', 'trash'])
                    ->default('draft');
                $table->unsignedInteger('created_by')->nullable();
                $table->unsignedInteger('updated_by')->nullable();
                $table->unsignedInteger('paid_by')->nullable();
                $table->timestamp('published_at')->useCurrent();
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
        Schema::dropIfExists('payments');
    }
}

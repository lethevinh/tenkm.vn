<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('transaction_id')->nullable();
            $table->text('title_lb')->nullable();
            $table->text('content_lb')->nullable();
            $table->float('amount',255, 0)->unsigned()->nullable();
            $table->integer('payment_status')->unsigned()->default(0);
            $table->nullableMorphs('orderable');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['orderable_id', 'user_id', 'orderable_type'], 'orderable_ids_key_unique');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

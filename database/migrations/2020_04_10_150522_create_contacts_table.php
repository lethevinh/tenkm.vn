<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('contacts')) {
            Schema::create('contacts', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title_lb')->nullable();
                $table->string('email_lb');
                $table->string('name_lb')->nullable();
                $table->string('slug_lb')->unique();
                $table->index(['slug_lb']);
                $table->enum('status_sl', ['new', 'watched', 'draft', 'trash'])
                    ->default('new');
                $table->text('content_lb')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}

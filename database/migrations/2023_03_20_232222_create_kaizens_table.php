<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kaizens', function (Blueprint $table) {
            $table->uuid('id')->unique()->primary();
            $table->string('no');
            $table->string('name');
            $table->text('description_old');
            $table->text('description_new');
            $table->string('image_old')->nullable();
            $table->string('image_new')->nullable();
            $table->text('benefit');
            $table->string('review_pic')->nullable();
            $table->integer('point_pic')->nullable();
            $table->string('review_secretary')->nullable();
            $table->integer('point_secretary')->nullable();
            $table->foreignUuid('category_id')->constrained();
            $table->foreignUuid('departement_id')->constrained();
            $table->uuid('status_pic_id')->nullable();
            $table->uuid('status_secretary_id')->nullable();
            $table->foreign('status_pic_id')->references('id')->on('statuses');
            $table->foreign('status_secretary_id')->references('id')->on('statuses');
            $table->uuid('pic_id')->nullable();
            $table->uuid('secretary_id')->nullable();
            $table->foreign('pic_id')->references('id')->on('signatures');
            $table->foreign('secretary_id')->references('id')->on('signatures');

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
        Schema::dropIfExists('kaizens');
    }
};

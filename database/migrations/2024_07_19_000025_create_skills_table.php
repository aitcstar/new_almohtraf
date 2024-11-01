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
        if (!Schema::hasTable('skills'))
        {
            Schema::create('skills', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedBigInteger('category_id')->nullable();
                $table->unsignedBigInteger('subcategory_id')->nullable();
                $table->integer('suggested')->default(0);
                $table->integer('status')->default(1);
                $table->foreign('category_id')->references('id')->on('categories');

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
        Schema::dropIfExists('skills');
    }
};

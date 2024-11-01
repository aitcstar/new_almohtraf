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
            Schema::create('skill_user', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('skill_id');

                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('skill_id')->references('id')->on('skills');

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
        Schema::dropIfExists('skill_user');
    }
};

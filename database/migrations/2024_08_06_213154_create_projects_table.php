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
        if (!Schema::hasTable('order_status'))
        {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان المشروع
            $table->text('description'); // وصف المشروع
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->string('budget'); // الميزانية المتوقعة
            $table->integer('expected_duration'); // المدة المتوقعة للتسليم (بالأيام)
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('order_status_id')->nullable();
            $table->string('draft')->nullable();
            $table->string('is_hired')->default(false); // يحدد ما إذا تم توظيف المستخدمين لهذا المشروع
            $table->date('due_date');



            //$table->json('files'); // ملفات توضيحية (كمصفوفة JSON)
            //$table->json('questions'); // أسئلة المشروع (كمصفوفة JSON)
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('subcategory_id')->references('id')->on('categories');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('order_status_id')->references('id')->on('order_status');


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
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // المستخدم الذي تم تقييمه
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade'); // صاحب المشروع
            $table->integer('professionalism')->default(0); // الاحترافية بالتعامل
            $table->integer('communication')->default(0); // التواصل والمتابعة
            $table->integer('quality')->default(0); // جودة العمل المسلّم
            $table->integer('expertise')->default(0); // الخبرة بمجال المشروع
            $table->integer('timeliness')->default(0); // التسليم في الموعد
            $table->integer('would_work_again')->default(0); // التعامل مرة أخرى
            $table->text('comment')->nullable(); // تعليق
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
        Schema::dropIfExists('project_reviews');
    }
}

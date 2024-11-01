<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // الشخص الذي قدم التبليغ
            $table->string('reportable_type'); // نوع المحتوى المُبلغ عنه (مشروع، عرض، مستخدم، إلخ)
            $table->unsignedBigInteger('reportable_id'); // معرف المحتوى المُبلغ عنه
            $table->text('reason'); // السبب الذي دفع المستخدم للتبليغ
            $table->timestamps();

            // العلاقات
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}

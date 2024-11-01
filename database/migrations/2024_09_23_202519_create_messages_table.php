<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');   // ID المستخدم الذي أرسل الرسالة
            $table->unsignedBigInteger('receiver_id'); // ID المستخدم الذي تلقى الرسالة
            $table->text('message');                   // محتوى الرسالة
            $table->boolean('is_read')->default(false); // حالة القراءة
            $table->unsignedBigInteger('project_id');  // المشروع المرتبط بالرسالة
            $table->timestamps();

            // العلاقات
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}

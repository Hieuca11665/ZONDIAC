<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 150)->unique(); // Giới hạn độ dài email
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255); // Rõ ràng độ dài cho password
            $table->integer('age')->nullable();
            $table->string('avatar', 255)->nullable(); // Đường dẫn avatar
            $table->string('username', 50)->nullable()->unique(); // Giới hạn username
            $table->string('phone_number', 15)->nullable(); // Giới hạn số điện thoại
            $table->rememberToken();
            $table->timestamps();
            $table->index('name'); // Thêm index cho name để tìm kiếm nhanh
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};

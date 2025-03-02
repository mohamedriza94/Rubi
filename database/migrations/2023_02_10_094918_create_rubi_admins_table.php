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
        Schema::create('rubi_admins', function (Blueprint $table) {
            $table->id();
            $table->string('no')->nullable();
            $table->string('fullname')->nullable();
            $table->unsignedBigInteger('age')->nullable();
            $table->string('dob')->nullable();
            $table->string('status')->nullable();
            $table->string('email');
            $table->text('photo')->nullable();
            $table->text('photoPath')->nullable();
            $table->string('telephone')->nullable();
            $table->string('password');
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
        Schema::dropIfExists('rubi_admins');
    }
};

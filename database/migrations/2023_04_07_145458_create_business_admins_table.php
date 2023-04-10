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
        Schema::create('business_admins', function (Blueprint $table) {
            $table->id();
            $table->string('no');
            $table->string('fullname');
            $table->string('dob');
            $table->string('status');
            $table->string('email');
            $table->text('photo');
            $table->string('telephone');
            $table->string('business');
            $table->string('password');
            $table->string('role');
            $table->string('department');
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
        Schema::dropIfExists('business_admins');
    }
};

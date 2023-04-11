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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('no');
            $table->string('subject');
            $table->string('note');
            $table->unsignedBigInteger('business');
            $table->unsignedBigInteger('department');
            $table->unsignedBigInteger('employee');
            $table->tinyInteger('isViewed');
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
        Schema::dropIfExists('notes');
    }
};

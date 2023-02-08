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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('product');
            $table->string('email');
            $table->string('website')->nullable();
            $table->string('country');
            $table->text('photo');
            $table->text('photoPath');
            $table->string('no');
            $table->string('status');
            $table->string('verifiedDate')->nullable();
            $table->string('password')->nullable();
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
        Schema::dropIfExists('businesses');
    }
};

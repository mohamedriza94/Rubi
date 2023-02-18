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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->text('photo')->nullable();
            $table->text('photoPath')->nullable();
            $table->string('name');
            $table->text('description');
            $table->string('price');
            $table->integer('periodDuration');
            $table->string('periodUnit');
            $table->string('status');
            $table->tinyInteger('is_deleted');
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
        Schema::dropIfExists('packages');
    }
};

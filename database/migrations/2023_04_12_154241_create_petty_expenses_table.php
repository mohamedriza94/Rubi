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
        Schema::create('petty_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('no');
            $table->string('department');
            $table->string('business');
            $table->string('employee');
            $table->string('purpose');
            $table->text('note')->nullable();
            $table->string('amount');
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
        Schema::dropIfExists('petty_expenses');
    }
};

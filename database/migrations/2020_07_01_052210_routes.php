<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Routes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('routes', function (Blueprint $table) {
            $table->bigIncrements('id');
          
            $table->string('name');
            $table->string('path');
            $table->string('type');

            $table->unsignedBigInteger('module_id');
            $table->foreign('module_id')->references('id')->on('modules');

            $table->boolean('is_active')->default(1);
            $table->boolean('soft_delete')->default(0);
            $table->string('created_by');
            $table->string('updated_by');
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
         Schema::dropIfExists('routes');
    }
}

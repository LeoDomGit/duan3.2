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
        Schema::create('project', function (Blueprint $table) {
            $table->integer('id',true,false);
            $table->string('project_name');
            $table->string('description');
            $table->string('note')->nullable();
            $table->integer('status',false,false)->default(0);
            $table->timestamps('start_date')->nullable();
            $table->timestamps('end_date')->nullable();
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
        //
    }
};

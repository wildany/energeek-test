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
    // $table->foreignId('job_id')->constrained('jobs')->onUpdate('cascade')->onDelete('cascade');
    // $table->foreignId('job_id')->references('id')->on('jobs')->onDelete('cascade')->onUpdate('cascade');
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 255);
            $table->integer('year');
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('job_id')->references('id')->on('jobs')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('candidates');
    }
};

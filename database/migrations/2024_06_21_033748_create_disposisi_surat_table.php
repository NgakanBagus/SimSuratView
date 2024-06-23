<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisposisiSuratTable extends Migration
{
    public function up()
    {
        Schema::create('disposisi_surat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('message_id'); // Changed from 'pdf_id'
            $table->string('title');
            $table->string('sender');
            $table->string('receiver');
            $table->text('description')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('message_id')->references('id')->on('messages')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('disposisi_surat');
    }
}

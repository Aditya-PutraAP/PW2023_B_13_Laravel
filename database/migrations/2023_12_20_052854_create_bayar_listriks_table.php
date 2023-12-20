<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_tagihan')->autoIncrement();
            $table->string('no_pelanggan');
            $table->bigInteger('token');
            $table->integer('harga');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
};

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBootSeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boot_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model')->comment('機型名稱');
            $table->integer('address')->comment('位址');
            $table->integer('ch')->nullable()->comment('channel');
            $table->integer('speed')->comment('baud rate');
            $table->integer('circuit')->comment('迴路');
            $table->boolean('vaild')->default(1)->comment('驗證');
            $table->integer('sync')->nullable()->comment('同步表位');
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
        Schema::dropIfExists('boot_settings');
    }
}

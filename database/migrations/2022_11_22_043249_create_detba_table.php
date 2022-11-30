<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetbaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ba', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_vendor');
            $table->string('no_ba');
            $table->enum('status_ba',['Not Yet Verified - BA', 'Verified - BA'])->default("Not Yet Verified - BA")->nullable();
            $table->enum('status_invoice_proposal',['Not Yet Verified - BA', 'Verified - BA'])->default("Not Yet Verified - BA")->nullable();
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
        Schema::dropIfExists('detba');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vendor_id');
            $table->string('vendor_name');
            $table->string('no_po');
            $table->integer('po_item');
            $table->date('GR_Date');
            $table->string('Material_Number');
            $table->string('Mat_Desc');
            $table->string('GR_Number');
            $table->float('harga_satuan');
            $table->string('jumlah');
            $table->string('jumlah_harga');
            $table->float('total_harga');
            
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
        Schema::dropIfExists('barang');
    }
}

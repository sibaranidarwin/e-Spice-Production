<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsReceipt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_receipt', function (Blueprint $table) {
            $table->bigIncrements('id_gr');
            $table->string('vendor_id');
            $table->string('vendor_name');
            $table->string('no_po');
            $table->integer('po_item');
            $table->date('GR_Date');
            $table->string('Delivery_Note');
            $table->string('Doc_Header_Text');
            $table->string('Material_Number');
            $table->string('Vendor_Part_Number');
            $table->string('Mat_Desc');
            $table->string('Valuation_Type');
            $table->string('GR_Number');
            $table->string('UOM');
            $table->string('Currency');
            $table->float('harga_satuan');
            $table->string('jumlah');
            $table->string('jumlah_harga');
            $table->float('total_harga');
            $table->string('Tax_Code');
            $table->string('Status');
            $table->string('Mat_Doc_IT');
            $table->string('Year');
            $table->string('Comp_Code');
            $table->string('Ref_Doc_No');
            $table->float('Total_Ppn');
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
        Schema::dropIfExists('goods_receipt');
    }
}

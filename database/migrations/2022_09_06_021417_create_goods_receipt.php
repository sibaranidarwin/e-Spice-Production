<?php

use Illuminate\Auth\Events\Verified;
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
            $table->bigInteger('id_inv')->unsigned();
            $table->foreign('id_inv')->references('id_inv')->on('invoice');
            $table->bigInteger('id_vendor')->unsigned();
            $table->foreign('id_vendor')->references('id_vendor')->on('vendor');
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
            $table->string('UOM')->nullable();
            $table->string('Currency');
            $table->float('harga_satuan');
            $table->string('jumlah')->nullable();
            $table->string('jumlah_harga')->nullable();
            $table->float('total_harga');
            $table->string('Tax_Code')->nullable();
            $table->string('alasan_disp')->nullable();
            $table->enum('Status',['Not Verified', 'Verified', 'Reject', 'Dispute'])->default("Not Verified")->nullable();
            $table->enum('status_invoice',['Not Yet Verified-Draft', 'Verified Yet Verified-BA', 'Reject'])->default("Not Yet Verified-Draft")->nullable();
            $table->string('Mat_Doc_IT')->nullable();
            $table->string('Year');
            $table->string('Comp_Code');
            $table->string('Ref_Doc_No');
            $table->float('Total_Ppn');
            $table->text('lampiran');
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

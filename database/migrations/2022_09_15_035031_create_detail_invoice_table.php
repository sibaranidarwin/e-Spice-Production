<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_invoice', function (Blueprint $table) {
            $table->bigIncrements('id_invoice');
            $table->string('id_barang');
            $table->date('posting_date');
            $table->string('vendor_invoice_number');
            $table->string('everify_number');
            $table->string('faktur_pajak_number');
            $table->float('total_harga_everify');
            $table->float('total_harga_gross');
            $table->float('DEL_COSTS');
            $table->float('ppn');
            $table->date('baselinedate');
            $table->string('INVOICE_DOC_ITEM');
            $table->string('HEADER_TEXT');
            $table->string('VALUATION_TYPE');
            $table->string('status');
            $table->string('komentar');
            $table->string('Invoice_Park_Document');
          
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
        Schema::dropIfExists('detail_invoice');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->bigIncrements('id_inv');
            $table->date('posting_date');
            $table->string('vendor_invoice_number');
            $table->string('everify_number')->nullable();
            $table->string('faktur_pajak_number')->nullable();
            $table->float('total_harga_everify')->nullable();
            $table->float('total_harga_gross')->nullable();
            $table->float('DEL_COSTS')->nullable();
            $table->float('ppn')->nullable();
            $table->date('baselinedate')->nullable();
            $table->string('INVOICE_DOC_ITEM')->nullable();
            $table->string('HEADER_TEXT')->nullable();
            $table->string('VALUATION_TYPE')->nullable();
            $table->string('status')->nullable();
            $table->string('komentar')->nullable();
            $table->string('Invoice_Park_Document')->nullable();
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
        Schema::dropIfExists('invoice');
    }
}

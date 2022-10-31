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
            $table->float('del_costs')->nullable();
            $table->float('ppn')->nullable();
            $table->date('baselinedate')->nullable();
            $table->string('invoice_doc_item')->nullable();
            $table->string('header_text')->nullable();
            $table->string('valuation_type')->nullable();
            $table->string('status')->nullable();
            $table->enum('data_from',['BA', 'GR'])->default("BA")->nullable();
            $table->string('komentar')->nullable();
            $table->string('invoice_park_document')->nullable();
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

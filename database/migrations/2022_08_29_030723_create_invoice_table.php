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
            $table->bigInteger('id_vendor');
            $table->date('posting_date');
            $table->string('vendor_invoice_number');
            $table->string('no_invoice_proposal');
            $table->string('everify_number')->nullable();
            $table->string('faktur_pajak_number')->nullable();
            $table->string('total_harga_everify')->nullable();
            $table->string('total_harga_gross')->nullable();
            $table->string('del_costs')->nullable();
            $table->string('ppn')->nullable();
            $table->string('total_doc_invoice')->nullable();
            $table->string('unplan_cost')->nullable();
            $table->string('currency')->nullable();
            $table->date('baselinedate')->nullable();
            $table->string('invoice_doc_item')->nullable();
            $table->string('header_text')->nullable();
            $table->string('valuation_type')->nullable();
            $table->string('status')->nullable();
            $table->enum('status_invoice_proposal',['Not Yet Verified','Verified'])->default("Verified")->nullable();
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

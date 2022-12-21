<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ba_reconcile', function (Blueprint $table) {
            $table->bigIncrements('id_ba');
            $table->bigInteger('id_draft_ba')->unsigned()->nullable();
            $table->foreign('id_draft_ba')->references('id_draft_ba')->on('draft_ba')->nullable();
            $table->bigInteger('id_inv')->unsigned()->nullable();
            $table->foreign('id_inv')->references('id_inv')->on('invoice');
            $table->bigInteger('id_vendor')->nullable();
            $table->string('no_ba');
            $table->date('gr_date');
            $table->string('po_number');
            $table->string('item');
            $table->string('ref_doc_no');
            $table->string('uom');
            $table->string('currency');
            $table->string('delivery_note');
            $table->string('material_description')->nullable();
            $table->string('vendor_part_number')->nullable();
            $table->string('material_number')->nullable();
            $table->string('valuation_type')->nullable();
            $table->string('reference')->nullable();
            $table->string('tax_code')->nullable();
            $table->integer('qty');
            $table->string('gr_number');
            $table->string('harga_satuan');
            $table->string('jumlah_harga');
            $table->string('confirm_price')->nullable();
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
        Schema::dropIfExists('ba');
    }
}

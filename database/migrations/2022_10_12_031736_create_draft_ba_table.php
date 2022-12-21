<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftBaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_ba', function (Blueprint $table) {
            $table->bigIncrements('id_draft_ba');
            $table->bigInteger('id_gr')->unsigned();
            $table->foreign('id_gr')->references('id_gr')->on('goods_receipt');
            $table->bigInteger('id_vendor');
            $table->string('no_draft');
            $table->date('date_draft');
            $table->string('gr_number');
            $table->string('po_number');
            $table->string('mat_desc');
            $table->string('material_number');
            $table->string('ref_doc_no');
            $table->string('delivery_note');
            $table->string('uom');
            $table->string('currency');
            $table->string('vendor_part_number');
            $table->string('valuation_type');
            $table->string('tax_code');
            $table->string('doc_header_text');
            $table->integer('po_item');
            $table->integer('jumlah');
            $table->date('gr_date');
            $table->string('harga_satuan')->nullable();
            $table->string('jumlah_harga')->nullable();
            $table->string('selisih_harga')->nullable();
            $table->enum('status_draft',['Not Yet Verified - Draft BA', 'Verified - Draft BA', 'Verified - BA'])->nullable();
            $table->enum('status_invoice_proposal',['Not Yet Verified - Draft BA', 'Verified - Draft BA'])->default("Not Yet Verified - Draft BA")->nullable();
            $table->string('reason')->nullable();
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
        Schema::dropIfExists('draft_ba');
    }
}

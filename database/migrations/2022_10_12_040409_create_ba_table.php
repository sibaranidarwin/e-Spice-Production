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
            $table->bigInteger('id_draft_ba')->unsigned();
            $table->foreign('id_draft_ba')->references('id_draft_ba')->on('draft_ba');
            $table->bigInteger('id_inv')->unsigned();
            $table->foreign('id_inv')->references('id_inv')->on('invoice');
            $table->bigInteger('id_vendor');
            $table->string('no_ba');
            $table->date('gr_date');
            $table->string('po_number');
            $table->string('item');
            $table->string('material_description');
            $table->string('vendor_part_number');
            $table->string('material_number');
            $table->string('valuation_type');
            $table->string('reference');
            $table->string('tax_code')->nullable();
            $table->integer('qty');
            $table->string('amount_mkp');
            $table->string('confirm_price');
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

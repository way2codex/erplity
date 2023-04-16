<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_master', function (Blueprint $table) {
            $table->id();
            $table->date('order_date');
            $table->bigInteger('customer_id')->unsigned();
            $table->text('order_no');
            $table->double('total')->default(0);
            $table->double('discount')->default(0);
            $table->double('final_total')->default(0);
            $table->double('credit_amount')->default(0);
            $table->double('debit_amount')->default(0)->comment('deafult same as final_total amount');
            $table->date('due_date')->nullable();
            $table->string('payment_status')->default('unpaid')->comment('Paid,Unpaid');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('order_master');
    }
}

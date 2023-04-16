<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transaction', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_id');
            $table->string('transaction_type')->comment('product purchase and sell');
            $table->integer('quantity')->default(0);
            $table->text('ref_number')->nullable();
            $table->text('ref_comment')->nullable()->comment('Purchase Order, Selling Order');
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
        Schema::dropIfExists('stock_transaction');
    }
}

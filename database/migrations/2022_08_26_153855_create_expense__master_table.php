<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_master', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->double('amount')->default(0);
            $table->boolean('transaction_type')->comment('1-credit,0-debit');
            $table->longText('description')->nullable();
            $table->date('transaction_date');
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
        Schema::dropIfExists('expense__master');
    }
}

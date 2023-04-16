<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_master', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('unit_type_id')->unsigned();
            $table->string('name');
            $table->string('hsn_code')->nullable();
            $table->longText('description')->nullable();
            $table->string('main_image')->nullable();
            $table->double('base_rate')->nullable();
            $table->double('profit_rate')->nullable();
            $table->double('rate')->nullable();
            $table->double('current_stock')->default(0)->nullable();
            $table->double('minimumn_order_quantity')->nullable()->default(1);
            $table->double('stock_alert_quantity')->nullable()->default(0);
            $table->boolean('status')->default(true)->comment('1-active,0-in_active');
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
        Schema::dropIfExists('product_master');
    }
}

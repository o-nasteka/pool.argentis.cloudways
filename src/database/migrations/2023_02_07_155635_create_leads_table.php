<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('checkbox')->nullable();
            $table->string('paymentsystem')->nullable();
            $table->string('payment_order_id')->nullable();
            $table->string('payment_products_name')->nullable();
            $table->string('payment_products_quantity')->nullable();
            $table->string('payment_products_amount')->nullable();
            $table->string('payment_products_external_id')->nullable();
            $table->string('payment_products_price')->nullable();
            $table->string('payment_products_sku')->nullable();
            $table->string('payment_promocode')->nullable();
            $table->string('payment_discount_value')->nullable();
            $table->string('payment_discount')->nullable();
            $table->string('payment_subtotal')->nullable();
            $table->string('payment_amount')->nullable();
            $table->string('payment_delivery')->nullable();
            $table->string('payment_delivery_price')->nullable();
            $table->string('payment_delivery_fio')->nullable();
            $table->string('payment_delivery_address')->nullable();
            $table->string('payment_delivery_comment')->nullable();
            $table->string('payment_delivery_pickup_id')->nullable();
            $table->string('payment_delivery_zip')->nullable();
            $table->string('form_id')->nullable();
            $table->string('form_name')->nullable();

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
        Schema::dropIfExists('leads');
    }
};

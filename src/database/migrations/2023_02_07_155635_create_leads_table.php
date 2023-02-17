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
            $table->json('products')->nullable();
            $table->json('promocode')->nullable();
            $table->string('payment_subtotal')->nullable();
            $table->string('payment_amount')->nullable();
            $table->json('delivery')->nullable();
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

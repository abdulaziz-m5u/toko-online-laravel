<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('track_number')->nullable();
            $table->string('status');
            $table->integer('total_qty');
            $table->integer('total_weight');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('city_id')->nullable();
            $table->string('province_id')->nullable();
            $table->integer('postcode')->nullable();
            $table->datetime('shipped_at')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->unsignedBigInteger('shipped_by')->nullable();
            $table->foreign('shipped_by')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();

            $table->index('track_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};

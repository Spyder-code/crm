<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pembeli')->constrained('customers')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_member')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_produk')->constrained('products')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('id_harga')->constrained('prices')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('jumlah');
            $table->string('kode');
            $table->string('ongkir');
            $table->string('total');
            $table->integer('status');
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
        Schema::dropIfExists('invoices');
    }
}

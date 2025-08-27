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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_po');
            $table->date('tgl_delivery')->nullable();
            $table->string('no_po')->unique();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->integer('qty');
            $table->double('harga_satuan')->nullable();
            $table->double('jumlah');
            $table->date('tgl_beli')->nullable();
            $table->foreignId('bongkar_muat_id')->nullable()->constrained('bongkar_muats')->onDelete('set null');
            $table->double('harga_beli')->nullable();
            $table->foreignId('persentase_keuntungan_id')->nullable()->constrained('persentase_keuntungans')->onDelete('cascade');
            $table->double('uang_masuk')->nullable();
            $table->date('tgl_uang_masuk')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('estimasi_hari_pembayaran_id')->nullable()->constrained('estimasi_hari_pembayarans')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};

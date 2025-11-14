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
    Schema::create('detalles_pedido', function (Blueprint $table) {
        $table->id();

        // FK a pedidos.id
        $table->unsignedBigInteger('pedido_id');
        $table->foreign('pedido_id')
              ->references('id')
              ->on('pedidos')
              ->onDelete('cascade');

        // FK a productos.id
        $table->unsignedBigInteger('producto_id');
        $table->foreign('producto_id')
              ->references('id')
              ->on('productos')
              ->onDelete('restrict');

        $table->integer('cantidad')->default(1);
        $table->decimal('precio_unitario', 8, 2);
        $table->decimal('subtotal', 8, 2);

        $table->timestamp('fecha_creacion')->useCurrent();
        $table->timestamp('fecha_actualizacion')->nullable()->useCurrentOnUpdate();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('detalles_pedido');
    }

};

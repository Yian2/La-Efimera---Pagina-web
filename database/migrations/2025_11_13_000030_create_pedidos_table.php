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
    Schema::create('pedidos', function (Blueprint $table) {
        $table->id();

        // FK a usuarios.id
        $table->unsignedBigInteger('usuario_id');
        $table->foreign('usuario_id')
              ->references('id')
              ->on('usuarios')
              ->onDelete('cascade');

        $table->string('estado')->default('pendiente'); 
        $table->boolean('es_para_llevar')->default(false);
        $table->decimal('total', 8, 2)->default(0);

        $table->timestamp('fecha_creacion')->useCurrent();
       
    });
}

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }

};

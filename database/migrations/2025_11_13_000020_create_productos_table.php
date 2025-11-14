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
    Schema::create('productos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->text('descripcion')->nullable();
        $table->decimal('precio', 8, 2);
        $table->string('tipo')->default('pizza'); // pizza, bebida, postre, etc.
        $table->boolean('activo')->default(true);
        // Sin fechas, como tú quieres
    });
}

    public function down(): void
    {
        Schema::dropIfExists('productos');
    }

};

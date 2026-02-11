<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            
            // Relacionamento com a tabela de escritores
            // Usamos foreignId para conectar com a tabela 'escritores'
            $table->foreignId('writer_id')
                  ->constrained('escritores')
                  ->onDelete('cascade'); 

            $table->string('titulo');
            $table->string('slug')->unique(); // Para URLs amigáveis: meu-site.com/materia/titulo-da-materia
            $table->longText('conteudo');
            $table->string('capa')->nullable(); // Caminho da imagem de destaque
            $table->string('categoria')->nullable();
            
            // Status para controle de publicação
            $table->enum('status', ['rascunho', 'publicado'])->default('rascunho');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};
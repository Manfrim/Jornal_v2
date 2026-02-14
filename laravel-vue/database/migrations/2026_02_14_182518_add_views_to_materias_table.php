<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            // unsignedBigInteger garante que o número seja sempre positivo
            // default(0) evita que o campo venha vazio (null)
            $table->unsignedBigInteger('views')->default(0)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->dropColumn('views');
        });
    }
};

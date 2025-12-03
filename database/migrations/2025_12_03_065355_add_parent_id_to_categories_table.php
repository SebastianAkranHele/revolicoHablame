<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Adiciona a coluna parent_id para permitir subcategorías
            $table->foreignId('parent_id')
                  ->nullable()
                  ->after('id')
                  ->constrained('categories')
                  ->onDelete('cascade')
                  ->comment('ID da categoria pai, null para categorías principais');

            // Adiciona índice para melhor performance
            $table->index('parent_id');
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            // Remove a foreign key primeiro
            $table->dropForeign(['parent_id']);

            // Remove a coluna
            $table->dropColumn('parent_id');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Verifica se existe a coluna 'sort_order' e não existe 'order'
        if (Schema::hasColumn('categories', 'sort_order') && !Schema::hasColumn('categories', 'order')) {
            // Para MariaDB/MySQL mais antigo, usamos CHANGE COLUMN
            DB::statement('ALTER TABLE categories CHANGE sort_order `order` INT NOT NULL DEFAULT 0');
        } elseif (!Schema::hasColumn('categories', 'order')) {
            // Se não existir nenhuma, cria 'order'
            Schema::table('categories', function (Blueprint $table) {
                $table->integer('order')->default(0)->after('description');
            });
        }
    }

    public function down()
    {
        // Reverte: se existe 'order' e não existe 'sort_order', volta para 'sort_order'
        if (Schema::hasColumn('categories', 'order') && !Schema::hasColumn('categories', 'sort_order')) {
            DB::statement('ALTER TABLE categories CHANGE `order` sort_order INT NOT NULL DEFAULT 0');
        }
    }
};

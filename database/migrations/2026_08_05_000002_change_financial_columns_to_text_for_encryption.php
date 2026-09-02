<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->text('main_oeuvre')->change();
            $table->text('materiel')->change();
            $table->text('transport')->change();
            $table->text('autres_couts')->change();
        });

        Schema::table('depenses', function (Blueprint $table) {
            $table->text('montant')->change();
        });
    }

    public function down(): void
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->decimal('main_oeuvre', 15, 2)->change();
            $table->decimal('materiel', 15, 2)->change();
            $table->decimal('transport', 15, 2)->change();
            $table->decimal('autres_couts', 15, 2)->change();
        });

        Schema::table('depenses', function (Blueprint $table) {
            $table->decimal('montant', 15, 2)->change();
        });
    }
};

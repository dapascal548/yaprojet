<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->where('email', 'admin@example.com')->update(['email' => 'admin@gespro.com']);
        DB::table('users')->where('email', 'chef@example.com')->update(['email' => 'chef@gespro.com']);
        DB::table('users')->where('email', 'collab@example.com')->update(['email' => 'colla@gespro.com']);
    }

    public function down(): void
    {
        DB::table('users')->where('email', 'admin@gespro.com')->update(['email' => 'admin@example.com']);
        DB::table('users')->where('email', 'chef@gespro.com')->update(['email' => 'chef@example.com']);
        DB::table('users')->where('email', 'colla@gespro.com')->update(['email' => 'collab@example.com']);
    }
};

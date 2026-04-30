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
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->string('deleted_by_admin')->nullable()->after('is_soft_delete');
        });

        Schema::table('forum_comments', function (Blueprint $table) {
            $table->string('deleted_by_admin')->nullable()->after('is_soft_delete');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->dropColumn('deleted_by_admin');
        });

        Schema::table('forum_comments', function (Blueprint $table) {
            $table->dropColumn('deleted_by_admin');
        });
    }
};

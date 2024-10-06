<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyEmailInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the existing unique index if it exists
            $table->dropUnique(['email']);
        });

        Schema::table('users', function (Blueprint $table) {
            // Make the email column nullable
            $table->string('email')->unique()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the unique constraint before reverting changes
            $table->dropUnique(['email']);

            // Revert the email column to be not nullable
            $table->string('email')->unique()->nullable(false)->change();
        });
    }
}

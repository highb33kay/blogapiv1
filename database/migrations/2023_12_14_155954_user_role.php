<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
	public function up()
	{
    // Recreate the 'users' table
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
			$table->enum('role', ['admin', 'user'])->default('user');

            $table->timestamps();
        });
	}
	/**
	 * Reverse the migrations.
	 */
	public function down()
	{
	// Drop the 'users' table
		Schema::dropIfExists('users');
    }
};

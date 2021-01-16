<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('last_online_at')->useCurrent();
            $table->string('nric', 12)->nullable();
            $table->string('contactno', 12)->nullable();
            $table->string('memberno', 12)->nullable();
            $table->string('address')->nullable();
            $table->date('dob')->nullable();
            $table->string('plan', 32)->nullable();
            $table->string('bankname', 32)->nullable();
            $table->string('bankaccno', 32)->nullable();
            $table->string('n_name', 128)->nullable();
            $table->string('n_nric', 12)->nullable();
            $table->string('n_contactno', 12)->nullable();
            $table->string('n_bankname', 32)->nullable();
            $table->string('n_bankaccno', 32)->nullable();
            $table->string('i_memberno', 12)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

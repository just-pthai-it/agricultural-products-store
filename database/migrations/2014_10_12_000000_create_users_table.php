<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up ()
    {
        Schema::create('users', function (Blueprint $table)
        {
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->unsignedMediumInteger('id')->autoIncrement();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 50)->unique();
            $table->string('address', 100);
            $table->string('image', 1000)->nullable();
            $table->string('password', 250);
            $table->rememberToken()->nullable();
            $table->dateTime('created_at')->default(DB::raw('current_timestamp()'));
            $table->dateTime('updated_at')->default(DB::raw('current_timestamp()'))
                  ->useCurrentOnUpdate();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down ()
    {
        Schema::dropIfExists('users');
    }
}

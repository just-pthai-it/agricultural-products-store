<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up ()
    {
        Schema::create('categories', function (Blueprint $table)
        {
            $table->charset   = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->unsignedMediumInteger('id')->autoIncrement();
            $table->string('name', 200);
            $table->string('description', 1000);
            $table->string('image', 1000);
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
        Schema::dropIfExists('categories');
    }
}

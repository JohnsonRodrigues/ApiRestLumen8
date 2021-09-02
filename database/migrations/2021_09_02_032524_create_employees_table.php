<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 200);
            $table->string('email', 200)->unique();
            $table->string('cpf', 25)->unique();
            $table->string('rg', 25);
            $table->date('birth_date');
            $table->string('address', 200);
            $table->string('complement', 200)->nullable();
            $table->string('district', 150);
            $table->string('zip_code', 25);
            $table->string('number', 10);
            $table->string('city', 100);
            $table->string('state', 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}

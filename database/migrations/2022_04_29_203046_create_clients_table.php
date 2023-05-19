<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('service_request_id');
            $table->string('document_type');
            $table->string('identification_card');
            $table->string('email');
            $table->string('names');
            $table->string('surnames');
            $table->string('direction');
            $table->string('state');
            $table->string('municipality');
            $table->string('institution_name');
            $table->string('organizational_unit');
            $table->string('phone');
            $table->string('office_phone');
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('clients');
    }
}

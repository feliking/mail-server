<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceMailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_mail', function (Blueprint $table) {
            $table->id();
            $tabla->string('destinatarios');
            $tabla->string('cc')->nullable();
            $tabla->string('asunto')->nullable();
            $tabla->string('contenido')->nullable();
            $tabla->string('adjuntos')->nullable();
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
        Schema::dropIfExists('service_mail');
    }
}

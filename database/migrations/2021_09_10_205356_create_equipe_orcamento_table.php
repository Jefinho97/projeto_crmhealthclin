<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipeOrcamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipe_orcamento', function (Blueprint $table) {
            $table->foreignId('equipe_id')->constrained();
            $table->foreignId('orcamento_id')->constrained();
            $table->integer('quant');
            $table->double('soma_custo');
            $table->double('soma_venda');
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
        Schema::dropIfExists('equipe_orcamento');
    }
}

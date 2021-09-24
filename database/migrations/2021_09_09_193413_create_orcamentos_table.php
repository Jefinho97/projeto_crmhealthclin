<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrcamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('procedimento');
            $table->string('paciente')->default('Não Expecificado');
            $table->string('email_pac')->default('Não Expecificado');
            $table->string('telefone_1')->default('Não Expecificado');
            $table->string('telefone_2')->default('Não Expecificado');
            $table->string('status')->default('Não Expecificado');
            $table->string('razao_status',200)->default('Não Expecificado');
            $table->boolean('tipo')->default(false);
            $table->text('termos_condicoes')->default('Não Expecificado');
            $table->text('convenios')->default('Não Expecificado');
            $table->text('condicoes_pag')->default('Não Expecificado');
            $table->dateTime('data');
            $table->string('medico')->default('Não Expecificado');
            $table->double('preco_medico', 20, 2)->default(0.00);
            $table->double('total_equipe', 20, 2)->default(0.00);
            $table->double('total_diaria', 20, 2)->default(0.00);
            $table->double('total_material', 20, 2)->default(0.00);
            $table->double('desconto', 20, 2)->default(0.00);
            $table->double('valor_inicial', 20, 2)->default(0.00);
            $table->double('valor_final', 20, 2)->default(0.00);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orcamentos');
    }
}

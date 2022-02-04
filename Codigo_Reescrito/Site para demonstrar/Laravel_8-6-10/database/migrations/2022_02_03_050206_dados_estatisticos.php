<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DadosEstatisticos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'dadosEstatisticos',
            function (Blueprint $table) {
                $table->increments(column: 'id');

                $table->timestamp(column: 'executadoEm');

                $table->integer(column: 'jogosCadastrados');
                $table->integer(column: 'leBundles');
                $table->time(column: 'tempoDeExecucao')->nullable();
                $table->float(column: 'segundosPorJogo')->nullable();
            }    
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dadosEstatisticos');
    }
}

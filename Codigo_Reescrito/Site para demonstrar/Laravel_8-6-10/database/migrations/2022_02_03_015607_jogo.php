<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Jogo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'jogos', 
            function (Blueprint $table) {
                $table->increments(column: 'jogo_id');

                $table->string(column: 'jogo_nome', length: 255);
                $table->integer(column: 'jogo_nivelAvaliacao');
                $table->string(column: 'jogo_precoAntes', length: 9);
                $table->string(column: 'jogo_precoDepois', length: 9);
                $table->string(column: 'jogo_desconto', length: 6);
                $table->string(column: 'jogo_linkJogo', length: 255);
                $table->string(column: 'jogo_linkVideo', length: 255)->nullable();
                $table->string(column: 'jogo_linkFoto', length: 255)->nullable();
                $table->string(column: 'jogo_descricao', length: 320);

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
        Schema::drop('jogos_teste');
    }
}

<?php

use Illuminate\Database\Seeder;

class GlossarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('glossary')->insert([
        	'key' => 'A', 
        	'name' => 'Aceitação do Risco',
        	'definition' => 'Decisão de aceitar a persistência de um risco residual após o tratamento do risco.',
        	'source' => 'Decisão do Conselho n.º 2013/488/EU'
        	]);
        DB::table('glossary')->insert([
        	'key' => 'A', 
        	'name' => 'Ameaça',
        	'definition' => 'ausa potencial de incidente indesejável que pode resultar em danos para uma organização ou qualquer dos sistemas por ela utilizados. Estas ameaças podem ser acidentais ou deliberadas (com dolo) e caracterizam-se por elementos ameaçadores, alvos potenciais e métodos de ataque.',
        	'source' => 'Decisão do Conselho n.º 2013/488/EU'
        	]);
        DB::table('glossary')->insert([
        	'key' => 'A', 
        	'name' => 'Ataque',
        	'definition' => 'Qualquer tipo de atividade maliciosa que tenta coletar, perturbar, negar, degradar ou destruir recursos de sistema de informação ou a informação em si.',
        	'source' => 'Glossary of Key Information Security Terms, eds.'
        	]);
        DB::table('glossary')->insert([
        	'key' => 'B', 
        	'name' => 'Backup',
        	'definition' => 'Qualificativo de um processo, técnica ou equipamento usado para ajudar a recuperar dados perdidos ou destruídos ou para manter um sistema em funcionamento. ',
        	'source' => 'Associação para a Promoção e Desenvolvimento da Sociedade de Informação.'
        	]);
        DB::table('glossary')->insert([
        	'key' => 'B', 
        	'name' => 'Bluetooth',
        	'definition' => 'Tecnologia normalizada de ligação via rádio, com baixa potência de transmissão e de pequeno alcance, utilizando um sistema de mudança aleatória de frequência de transmissão, que permite o estabelecimento automático de ligação, sem fios ou cabos, de vários aparelhos eletrónicos (telemóveis, assistentes digitais pessoais (PDA), computadores, etc.) situados a pequena distância uns dos outros, constituindo assim uma pequena rede local sem fios.',
        	'source' => 'Associação para a Promoção e Desenvolvimento da Sociedade de Informação.'
        	]);
        DB::table('glossary')->insert([
        	'key' => 'F', 
        	'name' => 'Firewall',
        	'definition' => ' Em tecnologias da informação e da comunicação, sistema informático concebido para proteger uma rede de computadores do acesso externo de utilizadores não autorizados.',
        	'source' => 'Associação para a Promoção e Desenvolvimento da Sociedade de Informação.'
        	]);
        DB::table('glossary')->insert([
        	'key' => 'N', 
        	'name' => 'Norma',
        	'definition' => 'Em engenharia de software, requisitos obrigatórios utilizados e impostos para atingir uma abordagem disciplinada e uniforme no desenvolvimento de software.',
        	'source' => 'Associação para a Promoção e Desenvolvimento da Sociedade de Informação.'
        	]);

    }
}

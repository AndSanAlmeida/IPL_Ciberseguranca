<?php

use Illuminate\Database\Seeder;

class TextTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('texts')->insert(['key' => 'aboutUs', 'description' => 'O Centro de Investigação em Informática e Comunicações do Instituto Politécnico de Leiria, tem como uma das suas missões a transferência de tecnologia e conhecimento para a indústria e para sociedade em geral. Neste sentido pretende-se que seja desenvolvido um portal web, denominado de Oficina de Cibersegurança, vocacionado para o reforço da consciencialização em cibersegurança (security awareness) em ambientes domésticos, escolares e profissionais.']);
        DB::table('texts')->insert(['key' => 'CIIC', 'description' => ' O CIIC–IPL, Centro de Investigação em Informática e Comunicações do Instituto Politécnico de Leiria, criado em Outubro de 2008, tem por missão realizar investigação de elevada qualidade nas áreas da Informática e das Comunicações para promover transferência de tecnologia e possibilitar ainda a criação de empresas spin-off e a prestação de serviços de consultoria técnico-científica a entidades públicas e privadas. O CIIC-IPL promove as seguintes linhas de investigação: Sistemas multimédia e cognitivos, Sistemas evolucionários e complexos, Engenharia de software e sistemas, Redes e Serviços de Comunicação, Sistemas de Informação e Web e a Segurança.']);
        DB::table('texts')->insert(['key' => 'IPL', 'description' => 'O IPLeiria é uma instituição pública de ensino superior, que iniciou a sua atividade em 1980. Está presente na região de Leiria e Oeste através das suas cinco escolas superiores, localizadas nas cidades de Leiria (Escola Superior de Educação e Ciências Sociais, Escola Superior de Tecnologia e Gestão e Escola Superior de Saúde), Caldas da Rainha (Escola Superior de Artes e Design) e Peniche (Escola Superior de Turismo e Tecnologia do Mar).']);
    }
}

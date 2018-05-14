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
        DB::table('texts')->insert(['key' => 'activities', 'description' => 'Nesta secção são divulgadas atividades e eventos relacionadas com cibersegurança']);
        DB::table('texts')->insert(['key' => 'resources', 'description' => 'Nesta secção do portal encontra-se recursos disponiveis.']);
    }
}

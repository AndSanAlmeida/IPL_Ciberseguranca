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
        DB::table('texts')->insert(['key' => 'ourMission', 'description' => 'A nossa missão é contribuir para a sensibilização, educação e literacia em todas as questões que caracterizam, moldam, influenciam e conduzem ao estado-da-arte atual da Cibersegurança e do Ciberespaço.']);
        DB::table('texts')->insert(['key' => 'aboutUs', 'description' => 'O Centro de Investigação em Informática e Comunicações do Instituto Politécnico de Leiria, tem como uma das suas missões a transferência de tecnologia e conhecimento para a indústria e para sociedade em geral. Neste sentido desenvolveu-se um portal web, denominado de IPLeiria - Cibersegurança, vocacionado para o reforço da consciencialização em cibersegurança (security awareness) em ambientes domésticos, escolares e profissionais.']);
        DB::table('texts')->insert(['key' => 'activities', 'description' => 'Nesta secção do portal IPLeiria - Cibersegurança serão divulgados atividades e eventos relacionados com o mundo da cibersegurança, visto que é fundamental informar, sensibilizar e consciencializar os utilizadores que recorrem ao uso de tecnologias.']);
        DB::table('texts')->insert(['key' => 'resources', 'description' => 'A partilha de informação entre as partes interessadas no tópico de cibersegurança é um factor crítico de sucesso de uma melhor detecção, prevenção e reacção a falhas e interferências na segurança do ciberespaço, com esse pensamento foi criada esta secção com o objectivo de partilha de conteúdos relacionados à cibersegurança.']);
    }
}

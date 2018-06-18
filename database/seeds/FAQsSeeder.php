<?php

use Illuminate\Database\Seeder;

class FAQsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faqs')->insert([
        	'question' => 'O que é cibersegurança?', 
        	'answer' => 'Cibersegurança é a proteção de redes, serviços e dispositivos, e dos dados que sofrem dados ou são roubados.'
        	]);
        DB::table('faqs')->insert([
        	'question' => 'Por que o treinamento em cibersegurança é importante?', 
        	'answer' => 'O treinamento efetivo em cibersegurança pode ajudar sua equipa a reduzir os riscos e os efeitos de ataques à cibersegurança e a incentivar práticas de trabalho mais seguras.'
        	]);
        DB::table('faqs')->insert([
        	'question' => 'O que é phishing?', 
        	'answer' => 'O phishing não é segmentado, emails em massa enviados a muitas pessoas para tentar obter informações financeiras ou outras informações confidenciais (incluindo nomes de utilizador e passwords). Isso geralmente é feito enviando um email que parece ter sido enviado por uma organização legítima (geralmente um banco). O e-mail geralmente contém um link para um site falso que parece autêntico.'
        	]);
        DB::table('faqs')->insert([
        	'question' => 'Como escrevo uma política de cibersegurança?', 
        	'answer' => 'A sua política de cibersegurança deve refletir as necessidades e vulnerabilidades do seu sistema. Um bom ponto de partida é entender todos os seus ativos de TI, incluindo as suas redes. Você deve revisar e documentar o tipo de dados que está armazenando, seja pessoal, não pessoal, confidencial, confidencial ou público.'
        	]);

    }
}

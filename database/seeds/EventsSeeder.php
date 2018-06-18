<?php

use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('events')->insert([
        	'name' => 'Cyber Europe 2018', 
        	'localization' => 'Faculdade de Ciências e Tecnologia - Universidade de Coimbra',
        	'organizer' => 'Centro Nacional de Cibersegurança Portugal',
        	'description' => 'Esta conferência internacional tem como principal objetivo, a criação de um espaço para a discussão de todas as questões estratégicas, operacionais e técnicas relacionadas com cibersegurança. 
				Recorde-se que o Centro Nacional de Cibersegurança (CNCS), enquanto entidade pública com um papel central na promoção de uma cultura nacional de cibersegurança, acredita que é de extrema importância a discussão aberta e inclusiva em redor destes temas, bem como a participação ativa de todos os que intervêm nos seus diversos domínios.',
        	'date' => '2018-06-20',
        	'image_path' => 'img/eventos/Cyber Europe 2018.png',
        	'status' => 2,
        	'max_inscritos' => 999,
        	'id_user' => 1,
        	'total_interested' => 0
        	]);
    }
}

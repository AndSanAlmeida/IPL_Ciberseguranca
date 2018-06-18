<?php

use Illuminate\Database\Seeder;

class LinksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('useful_links')->insert([
        	'description' => 'CNCS', 
        	'link' => 'https://www.cncs.gov.pt/'
        	]);
        DB::table('useful_links')->insert([
        	'description' => 'Seguranca Informática', 
        	'link' => 'https://seguranca-informatica.pt/'
        	]);
        DB::table('useful_links')->insert([
        	'description' => 'Incibe_', 
        	'link' => 'https://www.incibe.es/en'
        	]);
    }
}

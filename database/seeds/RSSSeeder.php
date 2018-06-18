<?php

use Illuminate\Database\Seeder;

class RSSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rss_alerts')->insert(['website' => 'CNCS - Alertas', 'url' => 'https://www.cncs.gov.pt/recursos/alertas-de-seguranca/feed-rss/index.xml']);
        DB::table('rss_news')->insert(['website' => 'CNCS - Notícias', 'url' => 'https://www.cncs.gov.pt/recursos/noticias/feed-rss/index.xml']);
    }
}

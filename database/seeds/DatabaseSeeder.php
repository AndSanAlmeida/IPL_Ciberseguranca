<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DocumentsSeeder::class);
        $this->call(EventsSeeder::class);
        $this->call(FAQsSeeder::class);
        $this->call(GlossarySeeder::class);
        $this->call(LinksSeeder::class);
        $this->call(QuestionsSeeder::class);
        $this->call(RSSSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ConfigTableSeeder::class);
        $this->call(TextTableSeeder::class);
    }
}

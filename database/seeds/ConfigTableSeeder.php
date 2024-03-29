<?php

use Illuminate\Database\Seeder;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $platform_email = 'portal.ciberseguranca.ipl@gmail.com';
        $driver = 'smtp';
        $host = 'smtp.gmail.com';
        $port = 587;
        // está em plain text, porque depois precisso da password para criar as configuracoes do mail e não dá para decriptar a password para ser usada na criação do mail
        $password =  'projetofinal';
        $encryption = 'tls';
        $filesPath = 'tiles';
        $createdAt = Carbon\Carbon::now()->subMonths(2);

        $configInfo = [
            'platform_email' => $platform_email,
            'platform_email_properties' => "{\"driver\": \"$driver\", \"host\": \"$host\", \"port\": $port, \"password\": \"$password\", \"encryption\": \"$encryption\" }",
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];

        DB::table('config')->insert($configInfo);
    }
}

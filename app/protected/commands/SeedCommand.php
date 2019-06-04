<?php

class SeedCommand extends CConsoleCommand
{
    public function run($args)
    {
        $seeder = new \tebazil\yii1seeder\Seeder();
        $generator = $seeder->getGeneratorConfigurator();
        $faker = $generator->getFakerConfigurator();

        $password = '$2y$13$vuWxNshA/jRjdx.QrTZtp.uj8QumPknYJ7gUYR/9CyKb0R.m2sWTu'; //pass1
        $users = [
            [1, 'test1', $password, 'user'],
            [2, 'test2', $password, 'user'],
            [3, 'admin', $password, 'admin'],
        ];
        $columnUser = [false, 'username', 'password', 'role'];
        $seeder->table('tbl_users')
               ->data($users, $columnUser)
               ->rowQuantity(3);


        $seeder->table('tbl_films')->columns([
            'id',
            'name' => $faker->text(20),
            'description' => $faker->text(50),
            'user_id' => $faker->randomElement([1, 2]),
        ])->rowQuantity(30);

        $seeder->table('tbl_comments')->columns([
            'id',
            'content' => $faker->text(20),
            'film_id' => function() { return rand(1, 30); },
            'user_id' => $faker->randomElement([1, 2]),
        ])->rowQuantity(90);

        $seeder->refill();
    }
}

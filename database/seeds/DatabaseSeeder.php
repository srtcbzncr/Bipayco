<?php

use Illuminate\Database\Seeder;
use App\Models\Auth\User;
use App\Models\Base\SocialMedia;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 50)->create();
        factory(SocialMedia::class, 5)->create();
    }
}

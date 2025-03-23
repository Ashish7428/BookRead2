<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        Author::create([
            'username' => 'rknarayan',
            'full_name' => 'R.K. Narayan',
            'email' => 'rk.narayan@gmail.com',
            'phone' => '9876543210',
            'password' => Hash::make('Test@1234'),
            'bio' => 'One of India\'s most renowned and widely read authors, known for his Malgudi Days series.',
            'facebook_url' => null,
            'twitter_url' => null,
            'instagram_url' => null,
            'linkedin_url' => null,
        ]);
    }
}
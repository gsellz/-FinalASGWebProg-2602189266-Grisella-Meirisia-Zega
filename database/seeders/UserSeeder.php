<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Array of possible hobbies
        $possibleHobbies = [
            'Reading',
            'Travelling',
            'Sports',
            'Music',
            'Gaming',
            'Cooking',
            'Gardening',
            'Photography',
            'Crafting',
            'Painting'
        ];

        // Generate 10 fake users
        for ($i = 0; $i < 10; $i++) {
            // Select a random subset of hobbies (e.g., 3-5 hobbies per user)
            $hobbies = $faker->randomElements($possibleHobbies, rand(3, 5));

            // Determine payment status
            $paymentStatus = $faker->randomElement(['Not Paid', 'Paid']);

            // Generate coin data based on payment status
            $totalCoins = $paymentStatus === 'Paid' ? random_int(0, 50000) : 0;

            // Create the user with coins in the users table
            User::create([
                'name' => $faker->firstName(),
                'instagram' => 'http://www.instagram.com/' . $faker->unique()->firstName(),
                'gender' => $faker->randomElement(['Male', 'Female']),
                'password' => Hash::make('password123'),
                'hobbies' => json_encode($hobbies),
                'number' => $faker->phoneNumber,
                'age' => random_int(18, 30),
                'registration_price' => random_int(100000, 125000),
                'payment_status' => $paymentStatus,
                'coins' => $totalCoins,
                'images_url' => $faker->numberBetween(1, 5) . '.jpeg',
            ]);
        }
    }
}

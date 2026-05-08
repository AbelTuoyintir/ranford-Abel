<?php

namespace Database\Seeders;

use App\Models\Poll;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create 5 polls without using a factory
        // for ($i = 0; $i < 5; $i++) {
        //     Poll::create([
        //         'title' => fake()->title(),
        //         'description' => fake()->paragraph(),
        //         'status' => 'active',
        //         'start_time' => fake()->dateTimeBetween('-1 week', 'now'),
        //         'end_time' => fake()->dateTimeBetween('now', '+1 week'),
        //         'poll_date' => fake()->date(),
        //         'image' => fake()->imageUrl(),
        //         'poll_type' => fake()->randomElement(['Ucc General Election', 'Hall', 'Department', 'Special Voting']),
        //     ]);
        // }
        // User::factory()->create([
        //     'firstName' => 'MR.ALBERT',
        //     'middleName'=> 'K.',
        //     'lastName' => 'BAIDOO',
        //     'school_id' => '12094',
        //     // 'Programs' => 'Computer Science',
        //     'gender' => 'M',
        //     'hall' => 'SRC',
        //     'image' => 'cdn.ucc.edu.gh/photos/?tag=12094',
        //     'email' => 'srchall@ucc.edu.gh',
        //     'password' => bcrypt('srcpassword'),
        //     'role' => 'admin',
        // ]);
        
        // User::factory()->create([
        //     'firstName' => 'MR.RAYMOND',
        //     // 'middleName'=> 'K.',
        //     'lastName' => 'BENTIL',
        //     'school_id' => '8713',
        //     // 'Programs' => 'Computer Science',
        //     'gender' => 'M',
        //     'hall' => 'CASFORD',
        //     'image' => 'cdn.ucc.edu.gh/photos/?tag=8713',
        //     'email' => 'casely.hayfordhall@ucc.edu.gh',
        //     'password' => bcrypt('passwordcasford'),
        //     'role' => 'admin',
        // ]);

        // User::factory()->create([
        //     'firstName' => 'MS.SARAH',
        //     'middleName'=> 'R.',
        //     'lastName' => 'ADDAI-BUOBU',
        //     'school_id' => '11900',
        //     // 'Programs' => 'Computer Science',
        //     'gender' => 'F',
        //     'hall' => 'GUSSS',
        //     'image' => 'cdn.ucc.edu.gh/photos/?tag=11900',
        //     'email' => 'superannuationh@ucc.edu.gh',
        //     'password' => bcrypt('passwordgusss'),
        //     'role' => 'admin',
        // ]);

        // User::factory()->create([
        //     'firstName' => 'MS.PATIENCE',
        //     // 'middleName'=> 'R.',
        //     'lastName' => 'ADJABENG',
        //     'school_id' => '16407',
        //     // 'Programs' => 'Computer Science',
        //     'gender' => 'F',
        //     'hall' => 'ATLANTIC',
        //     'image' => 'cdn.ucc.edu.gh/photos/?tag=16407',
        //     'email' => 'atl.hall@ucc.edu.gh',
        //     'password' => bcrypt('passwordatl'),
        //     'role' => 'admin',
        // ]);

        // User::factory()->create([
        //     'firstName' => 'MR.STEPHEN',
        //     'middleName'=> 'E.',
        //     'lastName' => 'ESSEL',
        //     'school_id' => '15416',
        //     // 'Programs' => 'Computer Science',
        //     'gender' => 'M',
        //     'hall' => 'KNHALL',
        //     'image' => 'cdn.ucc.edu.gh/photos/?tag=15416',
        //     'email' => 'manageress.knh@ucc.edu.gh',
        //     'password' => bcrypt('passwordknk'),
        //     'role' => 'admin',
        // ]);
        // User::factory()->create([
        //     'firstName' => 'MR.GODWIN',
        //     'middleName'=> 'K.',
        //     'lastName' => 'YAWOTSE',
        //     'school_id' => '12117',
        //     // 'Programs' => 'Computer Science',
        //     'gender' => 'M',
        //     'hall' => 'VALCO',
        //     'image' => 'cdn.ucc.edu.gh/photos/?tag=12117',
        //     'email' => 'valco.hall@ucc.edu.gh',
        //     'password' => bcrypt('passwordvalco'),
        //     'role' => 'admin',
        // ]);

        // User::factory()->create([
        //     'firstName' => 'MS.REGINA',
        //     // 'middleName'=> 'R.',
        //     'lastName' => 'OBENG',
        //     'school_id' => '10535',
        //     // 'Programs' => 'Computer Science',
        //     'gender' => 'F',
        //     'hall' => 'ADEHYE',
        //     'image' => 'cdn.ucc.edu.gh/photos/?tag=10535',
        //     'email' => 'adehyehall@ucc.edu.gh',
        //     'password' => bcrypt('passwordadehye'),
        //     'role' => 'admin',
        // ]);

        // User::factory()->create([
        //     'firstName' => 'MR.MICHEAL',
        //     'middleName'=> 'A.',
        //     'lastName' => 'MINNAH',
        //     'school_id' => '14860',
        //     // 'Programs' => 'Computer Science',
        //     'gender' => 'M',
        //     'hall' => 'VTRUST',
        //     'image' => 'cdn.ucc.edu.gh/photos/?tag=14860',
        //     'email' => 'valcotrust.hall@ucc.edu.gh',
        //     'password' => bcrypt('passwordvalcotrust'),
        //     'role' => 'admin',
        // ]);

        // User::factory()->create([
        //     'firstName' => 'MS.BERTHA',
        //     // 'middleName'=> 'R.',
        //     'lastName' => 'AFREH',
        //     'school_id' => '13752',
        //     // 'Programs' => 'Computer Science',
        //     'gender' => 'F',
        //     'hall' => 'OGUAA',
        //     'image' => 'cdn.ucc.edu.gh/photos/?tag=13752',
        //     'email' => 'oguaahall@ucc.edu.gh',
        //     'password' => bcrypt('passwordoguaa'),
        //     'role' => 'admin',
        // ]);

        

        User::factory()->create([
            'firstName' => 'Admin',
            // 'middleName'=> 'KOJO',
            'lastName' => 'Phy',
            'school_id' => '1000',
            // 'Programs' => 'Computer Science',
            'gender' => 'M',
            // 'hall' => 'UHALL',
            'image' => 'cdn.ucc.edu.gh/photos/?tag=1191',
            'email' => 'uhms.office@ucc.edu.gh',
            'password' => bcrypt('@CODE_voting25'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'firstName' => 'Abel',
            // 'middleName'=> 'R.',
            'lastName' => 'Phy',
            'school_id' => '1001',
            // 'Programs' => 'Computer Science',
            'gender' => 'F',
            // 'hall' => 'GUSSS',
            'image' => 'cdn.ucc.edu.gh/photos/?tag=15657',
            'email' => 'superannuationh@ucc.edu.gh',
            'password' => bcrypt('@CODE_voting25'),
            'role' => 'moderator',
        ]);

        
    }
}

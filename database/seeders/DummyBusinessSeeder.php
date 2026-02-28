<?php

namespace Database\Seeders;

use App\NotificationTemplate;
use App\User;
use App\Utils\InstallUtil;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;

class DummyBusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        $now = Carbon::now()->format('Y-m-d H:i:s');
        $password = Hash::make('123456');

        // 1. Create a single Business
        $business_id = DB::table('business')->insertGetId([
            'name' => 'Default Shop',
            'currency_id' => 2, // USD or your preferred ID
            'start_date' => Carbon::now()->format('Y-m-d'),
            'time_zone' => 'America/Phoenix',
            'accounting_method' => 'fifo',
            'enabled_modules' => json_encode(["purchases", "add_sale", "pos_sale", "expenses"]),
            'owner_id' => 1, // Placeholder, will update later
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Create the Owner User linked to that Business
        $user_id = DB::table('users')->insertGetId([
            'surname' => 'Mr',
            'first_name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => $password,
            'language' => 'en',
            'business_id' => $business_id, // Links user to the business
            'is_cmmsn_agnt' => 0,
            'cmmsn_percent' => '0.00',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 3. Update the business with the actual owner ID
        DB::table('business')->where('id', $business_id)->update(['owner_id' => $user_id]);

        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        DB::commit();
    }
}

<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class allPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $currentTimestamp = Carbon::now();
    
            $permissions = [
                ['name' => 'pending_transaction', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'complated_transaction', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'employee', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'customer', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'service', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'category', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'report', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'staff_user', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'role', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'give_permission', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ];
    
            DB::table('general_permissions')->truncate();
            DB::table('general_permissions')->insert($permissions);
        }
    }
}

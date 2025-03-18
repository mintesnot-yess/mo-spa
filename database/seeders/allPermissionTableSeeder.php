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
                ['name' => 'order', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'payment_collection', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'commission', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'expense', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'expense_type', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'vehicles', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'drivers', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'location', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'load_type', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'bank', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'staff_user', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'client', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'role', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'give_permission', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'report', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ];
    
            DB::table('general_permissions')->truncate();
            DB::table('general_permissions')->insert($permissions);
        }
    }
}

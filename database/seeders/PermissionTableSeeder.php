<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $currentTimestamp = Carbon::now();
    
            $permissions = [
               
                ['name' => 'show_pending_transaction', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'show_complated_transaction', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                
                ['name' => 'show_category', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_category', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_category', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_category', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],

                ['name' => 'show_service', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_service', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_service', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_service', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],

                ['name' => 'show_employee', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_employee', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_employee', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_employee', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],

                ['name' => 'show_staff_user', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_staff_user', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_staff_user', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_staff_user', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                
                
                ['name' => 'show_customer', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_customer', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_customer', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_customer', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                
                ['name' => 'show_role', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_role', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_role', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_role', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                
                ['name' => 'show_give_permission', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_give_permission', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
               
                ['name' => 'show_report', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
            ];

            // DB::table('permissions')->truncate();    
            DB::table('permissions')->insert($permissions);
        }

    }
}

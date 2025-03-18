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
               
                ['name' => 'show_order', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_order', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_order', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_order', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
               
                ['name' => 'show_payment_collection', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_payment_collection', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_payment_collection', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_payment_collection', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                
                ['name' => 'show_commission', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_commission', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_commission', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_commission', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],

                ['name' => 'show_expense', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_expense', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_expense', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_expense', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],

                ['name' => 'show_expense_type', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_expense_type', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_expense_type', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_expense_type', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],

                ['name' => 'show_vehicles', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_vehicles', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_vehicles', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_vehicles', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],

                ['name' => 'show_drivers', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_drivers', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_drivers', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_drivers', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],

                ['name' => 'show_location', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_location', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_location', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_location', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                
                ['name' => 'show_load_type', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_load_type', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_load_type', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_load_type', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                
                ['name' => 'show_bank', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_bank', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_bank', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_bank', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                
                ['name' => 'show_staff_user', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_staff_user', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_staff_user', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_staff_user', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                
                
                ['name' => 'show_client', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'add_client', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'edit_client', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                ['name' => 'delete_client', 'guard_name' => 'web', 'created_at' => $currentTimestamp, 'updated_at' => $currentTimestamp],
                
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

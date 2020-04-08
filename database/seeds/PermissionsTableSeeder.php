<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('permissions')->insert([
          'category' => 'Users',
          'key' => 'user_create',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Users',
          'key' => 'user_edit',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Users',
          'key' => 'user_delete',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Employees',
          'key' => 'employee_create',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Employees',
          'key' => 'employee_edit',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Employees',
          'key' => 'employee_delete',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Manual Attendance',
          'key' => 'attendance_create',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Manual Attendance',
          'key' => 'attendance_edit',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Manual Attendance',
          'key' => 'attendance_delete',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Leaves',
          'key' => 'manage_public_leaves',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Leaves',
          'key' => 'manage_leaves_application',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Salary',
          'key' => 'manage_advance_payments',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Salary',
          'key' => 'manage_loans',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Salary',
          'key' => 'manage_overtime',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Salary',
          'key' => 'manage_basic_salary',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Shifts',
          'key' => 'shift_create',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Shifts',
          'key' => 'shift_edit',
          'created_at' => now(),
          'updated_at' => now()
      ]);

      DB::table('permissions')->insert([
          'category' => 'Shifts',
          'key' => 'shift_delete',
          'created_at' => now(),
          'updated_at' => now()
      ]);


    }
}

<?php

// database/seeders/RolesTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        // Membuat peran 'Admin' jika belum ada
        if (!Role::where('name', 'Admin')->exists()) {
            Role::create(['name' => 'Admin']);
        }

        // Menambahkan peran 'Admin' ke pengguna
        $user = User::find(1); // Ganti dengan ID pengguna yang sesuai
        if ($user && !$user->hasRole('Admin')) {
            $user->assignRole('Admin');
        }
    }
}


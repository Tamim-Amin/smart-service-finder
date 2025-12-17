<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Provider;
use App\Models\Category;
use Carbon\Carbon;

class DemoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Tamim Amin',
            'email' => 'tamimamin@gmail.com',
            'password' => Hash::make('tamimamin'),
            'email_verified_at' => now(),
        ]);

        UserRole::create([
            'user_id' => $admin->id,
            'role' => 'admin',
        ]);

        // Create Customer Users
        $customers = [
            ['name' => 'Tahmina Amin', 'email' => 'tahmina@gmail.com'],
            ['name' => 'Ayat Chowdhury', 'email' => 'ayat@gmail.com'],
            ['name' => 'Dolly Akter', 'email' => 'dolly@gmail.com'],
            ['name' => 'Rumon Dev', 'email' => 'rumon@gmail.com'],
            ['name' => 'Prottoy Talukdar', 'email' => 'prottoy@gmail.com'],
        ];

        foreach ($customers as $customerData) {
            $customer = User::create([
                'name' => $customerData['name'],
                'email' => $customerData['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            UserRole::create([
                'user_id' => $customer->id,
                'role' => 'customer',
            ]);
        }

        // Get Categories
        $electrician = Category::where('name', 'Electrician')->first();
        $plumber = Category::where('name', 'Plumber')->first();
        $technician = Category::where('name', 'Technician')->first();
        $tutor = Category::where('name', 'Tutor')->first();
        $carpenter = Category::where('name', 'Carpenter')->first();
        $cleaner = Category::where('name', 'Cleaner')->first();
        $painter = Category::where('name', 'Painter')->first();
        $gardener = Category::where('name', 'Gardener')->first();

        // Create Provider Users with Profiles
        $providers = [
            [
                'name' => 'Prianto Dey',
                'email' => 'prianto@gmail.com',
                'category_id' => $electrician->id,
                'bio' => 'Experienced electrician with 8+ years in residential and commercial wiring. Specialized in circuit repairs, lighting installations, and electrical safety inspections.',
                'experience_years' => 8,
                'hourly_rate' => 500,
                'location' => 'Tilagor, Sylhet',
                'is_verified' => true,
                'average_rating' => 4.8,
                'total_reviews' => 45,
            ],
            [
                'name' => 'Mutahar Mahmud',
                'email' => 'mutahar@gmail.com',
                'category_id' => $plumber->id,
                'bio' => 'Professional plumber offering pipe fitting, leak repairs, bathroom installations, and water heater services. Quick response and quality work guaranteed.',
                'experience_years' => 5,
                'hourly_rate' => 400,
                'location' => 'Temukhi, Sylhet',
                'is_verified' => true,
                'average_rating' => 4.5,
                'total_reviews' => 32,
            ],
            [
                'name' => 'Sadiah Rahman',
                'email' => 'sadiah@gmail.com',
                'category_id' => $tutor->id,
                'bio' => 'Dedicated mathematics and science tutor for grades 6-12. Over 3 years of teaching experience with proven results in board exams.',
                'experience_years' => 3,
                'hourly_rate' => 300,
                'location' => 'Tilagor, Sylhet',
                'is_verified' => true,
                'average_rating' => 4.9,
                'total_reviews' => 78,
            ],
            [
                'name' => 'Dhiraj Dhar Dip',
                'email' => 'dhiraj@gmail.com',
                'category_id' => $technician->id,
                'bio' => 'AC and refrigerator repair specialist. Expert in all brands with original spare parts. Same-day service available.',
                'experience_years' => 6,
                'hourly_rate' => 450,
                'location' => 'Amborkhana, Sylhet',
                'is_verified' => true,
                'average_rating' => 4.6,
                'total_reviews' => 28,
            ],
            [
                'name' => 'Anik Roy',
                'email' => 'anik@gmail.com',
                'category_id' => $carpenter->id,
                'bio' => 'Master carpenter specializing in custom furniture, door/window installations, and interior woodwork. Quality craftsmanship at affordable prices.',
                'experience_years' => 12,
                'hourly_rate' => 550,
                'location' => 'Rikabibazar, Sylhet',
                'is_verified' => true,
                'average_rating' => 4.7,
                'total_reviews' => 56,
            ],
            [
                'name' => 'Fatema Khatun',
                'email' => 'fatema@gmail.com',
                'category_id' => $cleaner->id,
                'bio' => 'Professional home cleaning services including deep cleaning, regular maintenance, and move-in/move-out cleaning. Eco-friendly products used.',
                'experience_years' => 4,
                'hourly_rate' => 250,
                'location' => 'Mejortilah, Sylhet',
                'is_verified' => true,
                'average_rating' => 4.8,
                'total_reviews' => 42,
            ],
            [
                'name' => 'Mahan Roy',
                'email' => 'mahan@gmail.com',
                'category_id' => $painter->id,
                'bio' => 'Expert house painter with 7 years experience in interior and exterior painting. Color consultation available. Fast and clean service.',
                'experience_years' => 7,
                'hourly_rate' => 400,
                'location' => 'Zindabazar, Sylhet',
                'is_verified' => true,
                'average_rating' => 4.5,
                'total_reviews' => 35,
            ],
            [
                'name' => 'Tahmid Rahman',
                'email' => 'tahmid@gmail.com',
                'category_id' => $gardener->id,
                'bio' => 'Professional gardener offering lawn maintenance, landscaping, plant care, and garden design services. Weekly/monthly packages available.',
                'experience_years' => 5,
                'hourly_rate' => 300,
                'location' => 'Supply Road, Sylhet',
                'is_verified' => true,
                'average_rating' => 4.6,
                'total_reviews' => 24,
            ],
            [
                'name' => 'Tamim Amin',
                'email' => 'tamim@gmail.com',
                'category_id' => $tutor->id,
                'bio' => 'Math tutor specializing in class 6-12 with 6 years teaching experience.',
                'experience_years' => 6,
                'hourly_rate' => 350,
                'location' => 'Shibgonj, Sylhet',
                'is_verified' => false, // Not yet verified
                'average_rating' => 0,
                'total_reviews' => 0,
            ],
            [
                'name' => 'Ishfak Akber',
                'email' => 'ishfak@gmail.com',
                'category_id' => $electrician->id,
                'bio' => 'Licensed electrician specializing in solar panel installations, generator repairs, and smart home electrical systems.',
                'experience_years' => 3,
                'hourly_rate' => 200,
                'location' => 'Khadim, Sylhet',
                'is_verified' => true,
                'average_rating' => 4.9,
                'total_reviews' => 67,
            ],
        ];

        foreach ($providers as $providerData) {
            $providerUser = User::create([
                'name' => $providerData['name'],
                'email' => $providerData['email'],
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);

            UserRole::create([
                'user_id' => $providerUser->id,
                'role' => 'provider',
            ]);

            Provider::create([
                'user_id' => $providerUser->id,
                'category_id' => $providerData['category_id'],
                'bio' => $providerData['bio'],
                'experience_years' => $providerData['experience_years'],
                'hourly_rate' => $providerData['hourly_rate'],
                'location' => $providerData['location'],
                'is_available' => true,
                'is_verified' => $providerData['is_verified'],
                'average_rating' => $providerData['average_rating'],
                'total_reviews' => $providerData['total_reviews'],
            ]);
        }

        echo "\n✅ Demo users created successfully!\n\n";
        echo "📧 LOGIN CREDENTIALS (All passwords: password)\n";
        echo "==========================================\n\n";
        echo "👤 ADMIN:\n";
        echo "   Email: tamimamin@gmail.com\n";
        echo "   Password: tamimamin\n\n";
        echo "🛒 CUSTOMERS:\n";
        echo "   tahmina@gmail.com - password (Tahmina Amin)\n";
        echo "   ayat@gmail.com - password (Ayat Chowdhury)\n";
        echo "   dolly@gmail.com - password (Dolly Akter)\n";
        echo "   rumon@gmail.com - password (Rumon Dev)\n";
        echo "   prottoy@gmail.com - password (Prottoy Talukdar)\n\n";
        echo "🔧 PROVIDERS:\n";
        echo "   prianto@gmail.com - password (Prianto Dey - Electrician)\n";
        echo "   mutahar@gmail.com - password (Mutahar Mahmud - Plumber)\n";
        echo "   sadiah@gmail.com - password (Sadiah Rahman - Tutor)\n";
        echo "   dhiraj@gmail.com - password (Dhiraj Dhar Dip - Technician)\n";
        echo "   anik@gmail.com - password (Anik Roy - Carpenter)\n";
        echo "   fatema@gmail.com - password (Fatema Khatun - Cleaner)\n";
        echo "   mahan@gmail.com - password (Mahan Roy - Painter)\n";
        echo "   tahmid@gmail.com - password (Tahmid Rahman - Gardener)\n";
        echo "   tamim@gmail.com - password (Tamim Amin - Tutor - NOT VERIFIED)\n";
        echo "   ishfak@gmail.com - password (Ishfak Akber - Electrician)\n\n";
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Provider;
use App\Models\Booking;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Fetch Customers
        $customers = [
            'tahmina' => User::where('email', 'tahmina@gmail.com')->first(),
            'ayat'    => User::where('email', 'ayat@gmail.com')->first(),
            'dolly'   => User::where('email', 'dolly@gmail.com')->first(),
            'rumon'   => User::where('email', 'rumon@gmail.com')->first(),
            'prottoy' => User::where('email', 'prottoy@gmail.com')->first(),
        ];

        // 2. Fetch Providers
        // Helper function to get Provider model by email
        $getProvider = function ($email) {
            $user = User::where('email', $email)->first();
            return $user ? Provider::where('user_id', $user->id)->first() : null;
        };

        $providers = [
            'prianto' => $getProvider('prianto@gmail.com'), // Electrician
            'mutahar' => $getProvider('mutahar@gmail.com'), // Plumber
            'sadiah'  => $getProvider('sadiah@gmail.com'),  // Tutor
            'dhiraj'  => $getProvider('dhiraj@gmail.com'),  // Technician
            'anik'    => $getProvider('anik@gmail.com'),    // Carpenter
            'fatema'  => $getProvider('fatema@gmail.com'),  // Cleaner
            'mahan'   => $getProvider('mahan@gmail.com'),   // Painter
            'tahmid'  => $getProvider('tahmid@gmail.com'),  // Gardener
            'tamim'   => $getProvider('tamim@gmail.com'),   // Tutor (Unverified)
            'ishfak'  => $getProvider('ishfak@gmail.com'),  // Electrician
        ];

        // 3. Define Demo Bookings
        $bookings = [
            // --- COMPLETED BOOKINGS (Past Dates) ---
            [
                'customer' => $customers['tahmina'],
                'provider' => $providers['prianto'],
                'problem' => 'Main circuit breaker keeps tripping repeatedly.',
                'date' => Carbon::now()->subDays(5),
                'status' => 'completed',
                'hours' => 2.5,
                'payment_status' => 'paid',
            ],
            [
                'customer' => $customers['dolly'],
                'provider' => $providers['sadiah'],
                'problem' => 'Need physics tutoring for Class 9 final exam prep.',
                'date' => Carbon::now()->subDays(3),
                'status' => 'completed',
                'hours' => 2.0,
                'payment_status' => 'paid',
            ],
            [
                'customer' => $customers['rumon'],
                'provider' => $providers['tahmid'],
                'problem' => 'Backyard lawn mowing and trimming hedges.',
                'date' => Carbon::now()->subDays(10),
                'status' => 'completed',
                'hours' => 4.0,
                'payment_status' => 'paid',
            ],
            [
                'customer' => $customers['ayat'],
                'provider' => $providers['fatema'],
                'problem' => 'Deep cleaning of 3-bedroom apartment after moving in.',
                'date' => Carbon::now()->subDays(2),
                'status' => 'completed',
                'hours' => 5.0,
                'payment_status' => 'paid',
            ],
            [
                'customer' => $customers['prottoy'],
                'provider' => $providers['dhiraj'],
                'problem' => 'Refrigerator is not cooling properly.',
                'date' => Carbon::now()->subDays(7),
                'status' => 'completed',
                'hours' => 1.5,
                'payment_status' => 'paid',
            ],

            // --- ACCEPTED/ONGOING BOOKINGS (Upcoming or Recent) ---
            [
                'customer' => $customers['ayat'],
                'provider' => $providers['mutahar'],
                'problem' => 'Kitchen sink pipe is leaking water under the cabinet.',
                'date' => Carbon::now()->addDays(1),
                'status' => 'accepted',
                'hours' => 1.0, // Estimated
                'payment_status' => 'pending',
            ],
            [
                'customer' => $customers['rumon'],
                'provider' => $providers['ishfak'],
                'problem' => 'Installation of new IPS unit and battery connection.',
                'date' => Carbon::now()->addDays(2),
                'status' => 'accepted',
                'hours' => 2.0, // Estimated
                'payment_status' => 'pending',
            ],

            // --- PENDING BOOKINGS (Future) ---
            [
                'customer' => $customers['tahmina'],
                'provider' => $providers['anik'],
                'problem' => 'Wooden door frame is broken and needs repair.',
                'date' => Carbon::now()->addDays(3),
                'status' => 'pending',
                'hours' => null,
                'payment_status' => 'pending',
            ],
            [
                'customer' => $customers['dolly'],
                'provider' => $providers['mahan'],
                'problem' => 'Painting one master bedroom wall (accent color).',
                'date' => Carbon::now()->addDays(5),
                'status' => 'pending',
                'hours' => null,
                'payment_status' => 'pending',
            ],
            [
                'customer' => $customers['prottoy'],
                'provider' => $providers['prianto'],
                'problem' => 'Install 3 ceiling fans in the new flat.',
                'date' => Carbon::now()->addDays(4),
                'status' => 'pending',
                'hours' => null,
                'payment_status' => 'pending',
            ],

            // --- CANCELLED/REJECTED BOOKINGS ---
            [
                'customer' => $customers['prottoy'],
                'provider' => $providers['tamim'], // The unverified tutor
                'problem' => 'Need math tutor immediately for tomorrow.',
                'date' => Carbon::now()->subDays(1),
                'status' => 'cancelled',
                'hours' => null,
                'payment_status' => 'failed',
            ],
        ];

        // 4. Create Bookings in Database
        foreach ($bookings as $data) {
            // Skip if provider/customer missing (safety check)
            if (!$data['provider'] || !$data['customer']) continue;

            $hourlyRate = $data['provider']->hourly_rate;
            $estimatedHours = $data['hours'] ?? 1.0; // Default 1 hour estimate if null
            $cost = $hourlyRate * $estimatedHours;

            Booking::create([
                'customer_id' => $data['customer']->id,
                'provider_id' => $data['provider']->id,
                'problem_description' => $data['problem'],
                'service_date' => $data['date']->format('Y-m-d'),
                'service_time' => '10:00:00', // Default time
                'estimated_duration' => $data['status'] === 'pending' ? null : $estimatedHours,
                'estimated_cost' => $data['status'] === 'pending' ? null : $cost,
                'total_hours' => $data['status'] === 'completed' ? $estimatedHours : null,
                'total_amount' => $data['status'] === 'completed' ? $cost : null,
                'payment_method' => $data['status'] === 'completed' ? 'cash' : null,
                'payment_status' => $data['payment_status'],
                'status' => $data['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        echo "\n✅ Demo bookings created successfully!\n";
    }
}
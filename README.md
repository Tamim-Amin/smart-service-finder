# Sylhet Sheba

A modern Laravel web application that connects customers with local service providers. Built with Laravel 12, Tailwind CSS, and MySQL.

## 📋 Project Overview

Smart Local Service Finder is a marketplace platform that enables:
- **Customers** to discover and book services from local providers
- **Providers** to offer their services and manage bookings
- **Admins** to oversee the platform and manage categories

## 🚀 Features

### Customer Features
- Browse service providers by category
- View provider profiles and ratings
- Book services with date and time selection
- Track booking status (pending, accepted, completed, cancelled)
- Make payments via multiple methods (Cash, bKash, Nagad)
- Leave reviews and ratings for completed services
- Real-time messaging with providers
- View booking history and statistics

### Provider Features
- Create and manage service profile
- Set hourly rates and availability
- View and manage incoming bookings
- Track earnings and revenue
- Manage service categories
- Accept or reject booking requests
- Communicate with customers
- View customer reviews and ratings

### Admin Features
- Dashboard with platform statistics
- Manage service categories
- Monitor users and providers
- View all bookings and transactions
- Generate reports

## 🛠️ Tech Stack

- **Backend**: Laravel 12 with PHP 8.2
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Database**: MySQL
- **Build Tool**: Vite
- **Authentication**: Laravel Breeze

## 📁 Project Structure

```
smart-service-finder/
├── app/
│   ├── Http/Controllers/          # Application controllers
│   │   ├── CustomerController.php
│   │   ├── ProviderController.php
│   │   ├── BookingController.php
│   │   ├── ReviewController.php
│   │   └── ...
│   ├── Models/                    # Eloquent models
│   │   ├── User.php
│   │   ├── Provider.php
│   │   ├── Booking.php
│   │   ├── Review.php
│   │   ├── Category.php
│   │   ├── Message.php
│   │   └── Notification.php
│   └── Providers/
├── database/
│   ├── migrations/                # Database schema
│   ├── factories/
│   └── seeders/                   # Database seeders
├── resources/
│   ├── views/                     # Blade templates
│   │   ├── auth/                  # Authentication views
│   │   ├── customer/              # Customer dashboard
│   │   ├── provider/              # Provider dashboard
│   │   ├── admin/                 # Admin dashboard
│   │   ├── bookings/
│   │   ├── reviews/
│   │   └── ...
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php                    # Web routes
│   ├── auth.php                   # Authentication routes
│   └── console.php
├── config/                        # Configuration files
├── storage/                       # File uploads
├── tests/                         # Test files
└── public/                        # Public assets
```

## 💾 Database Schema

### Key Tables
- **users** - User accounts (customers, providers, admins)
- **user_roles** - User role assignments
- **providers** - Provider profiles with hourly rates
- **categories** - Service categories
- **bookings** - Service bookings with payment info
- **reviews** - Customer reviews and ratings
- **messages** - Messaging system
- **notifications** - User notifications

## 🔧 Installation

### Prerequisites
- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js & npm

### Setup Steps

1. **Clone and setup project**
   ```bash
   cd d:\Xampp\htdocs\smart-service-finder
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Setup database**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build frontend assets**
   ```bash
   npm run build
   ```

7. **Start development server**
   ```bash
   php artisan serve
   ```

   Visit: `http://localhost:8000`

## 📚 User Roles

### Customer
- Register as customer
- Browse providers
- Book services
- Make payments
- Leave reviews

### Provider
- Register as provider
- Create service profile
- Manage availability
- Accept/reject bookings
- Earn money from services

### Admin
- Manage categories
- Monitor platform activity
- View reports
- Manage users and providers

## 💳 Payment Methods

- **Cash** - Direct payment at service location
- **bKash** - Mobile banking payment
- **Nagad** - Mobile payment service

## 📝 Key Models & Relationships

```
User
  └─ hasOne: Provider
  └─ hasMany: Booking (as customer)
  └─ hasMany: Review
  └─ hasMany: Message
  └─ hasOne: UserRole

Provider
  └─ belongsTo: User
  └─ belongsTo: Category
  └─ hasMany: Booking
  └─ hasMany: Review

Booking
  └─ belongsTo: User (customer)
  └─ belongsTo: Provider
  └─ hasOne: Review
  └─ hasMany: Message

Review
  └─ belongsTo: User (reviewer)
  └─ belongsTo: Booking

Message
  └─ belongsTo: Booking
  └─ belongsTo: User (sender)
```

## 🔐 Authentication & Authorization

- Login/Register at `/login` and `/register`
- Role-based access control via middleware
- CSRF protection on all forms
- Email verification optional
- Password reset functionality

## 📞 Support

For issues or questions, please check the error logs in `storage/logs/`.

## 📄 License

This project is open source and available under the MIT License.

## 👩‍💻 Developer

**Sadiah Rahman Chowdhury**
- ID: 232-134-023
- Batch: 5th

**Tamim Amin Suhag**
- ID: 232-134-024
- Batch: 5th

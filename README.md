Booking API Task

Author: Kareem Mohamed

Setup Instructions:

1. Clone or extract the project
2. Run: composer install
3. Copy .env file and configure database
4. Run: php artisan migrate
5. Run: php artisan serve

API Endpoints:

1. POST /api/register
2. POST /api/login
3. POST /api/bookings
4. GET /api/bookings

Notes:

* Authentication handled using Laravel Sanctum
* Password is hashed
* Booking system prevents duplicate bookings (same date & time)
* Validation applied to all endpoints

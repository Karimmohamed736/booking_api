# 🎟️ Booking API

A RESTful API built with **Laravel 13** for managing event bookings with authentication, role-based access control, and online payment via **Paymob**.

---

## 🚀 Features

- ✅ User Authentication (Register / Login / Logout) via **Laravel Sanctum**
- ✅ Email Verification
- ✅ Role-based Access Control (`admin` / `user`)
- ✅ Category Management (CRUD)
- ✅ Event Management with Image Uploads
- ✅ Event Booking with Seat Availability Check
- ✅ Online Payment Integration via **Paymob**
- ✅ HMAC Signature Verification on Payment Callbacks

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 11 |
| Authentication | Laravel Sanctum |
| Payment Gateway | Paymob |
| Database | MySQL |
| Media Handling | Custom MediaService |

---

## ⚙️ Installation

### 1. Clone the repository
```bash
git clone https://github.com/Karimmohamed736/booking_api.git
cd booking_api
```

### 2. Install dependencies
```bash
composer install
```

### 3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure `.env`
```env
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

PAYMOB_BASE_URL=https://accept.paymob.com
PAYMOB_API_KEY=your_paymob_api_key
PAYMOB_HMAC=your_paymob_hmac_secret
PAYMOB_INTEGRATION_IDS=id1,id2
```

### 5. Run migrations
```bash
php artisan migrate
```

### 6. Start the server
```bash
php artisan serve
```

---

## 🔐 Authentication

All protected routes require a **Bearer Token** in the Authorization header:

```
Authorization: Bearer {token}
```

Tokens are issued on `register` and `login` and must be included in every authenticated request.

---

## 📡 API Endpoints

### Auth

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| POST | `/api/register` | ❌ | Register a new user |
| POST | `/api/login` | ❌ | Login and get token |
| DELETE | `/api/logout` | ✅ | Logout current user |
| POST | `/api/verify-email` | ✅ | Verify email address |

---

### Categories

| Method | Endpoint | Role | Description |
|---|---|---|---|
| GET | `/api/categories` | Public | List all categories |
| GET | `/api/categories/{id}` | Public | Show single category |
| POST | `/api/categories` | Admin | Create category |
| PUT | `/api/categories/{id}` | Admin | Update category |
| DELETE | `/api/categories/{id}` | Admin | Delete category |

---

### Events

| Method | Endpoint | Role | Description |
|---|---|---|---|
| GET | `/api/events` | Public | List all events |
| GET | `/api/events/{id}` | Public | Show single event |
| GET | `/api/events-with-category` | Public | List events with category |
| GET | `/api/events-with-category/{id}` | Public | Show event with category |
| POST | `/api/events` | Admin | Create event (supports image upload) |
| PUT | `/api/events/{id}` | Admin | Update event |
| DELETE | `/api/events/{id}` | Admin | Delete event |

---

### Booking

| Method | Endpoint | Role | Description |
|---|---|---|---|
| POST | `/api/events/{event_id}/book` | User | Book an event            |
| GET    | `/api/my-bookings`        | User | List current user bookings |
| DELETE | `/api/bookings/{id}`      | User | Cancel a booking           |

**Business Rules:**
- A user cannot book the same event twice
- Booking is rejected if no available seats remain
- Available seats are decremented automatically on successful booking

---

### Payment

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| POST | `/api/payment/process`   | Initiate payment via Paymob |
| POST | `/api/payment/callback`  | Paymob payment callback (HMAC verified) |
| GET | `/api/payment/success`    | Payment success page |
| GET | `/api/payment/failed`     | Payment failed page |

**Payment Flow:**
```
User → POST /payment/process
            ↓
       Paymob API (get token → create order → return URL)
            ↓
       User completes payment on Paymob
            ↓
       Paymob → POST /payment/callback (HMAC verified)
            ↓
       Redirect to /payment/success or /payment/failed
```

---

## 📦 Request Examples

### Register
```json
POST /api/register
{
    "name": "Karim Mohamed",
    "email": "karim@example.com",
    "password": "Password@123"
}
```

### Login
```json
POST /api/login
{
    "email": "karim@example.com",
    "password": "Password@123"
}
```

### Book an Event
```json
POST /api/events/1/book
Headers: Authorization: Bearer {token}
```

### Initiate Payment
```json
POST /api/payment/process
Headers: Authorization: Bearer {token}
{
    "amount": 500,
    "currency": "EGP",
    "billing_data": {
        "first_name": "Karim",
        "last_name": "Mohamed",
        "email": "karim@example.com",
        "phone_number": "01000000000"
    }
}
```

---

## 🏗️ Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   ├── Auth/          # AuthController, EmailVerificationController
│   │   │   └── Event/         # EventController
│   │   ├── Book/              # BookController
│   │   ├── CategoryController.php
│   │   └── PaymentController.php
│   ├── Requests/              # Form Request Validation
│   └── Resources/             # API Resources (JSON transformation)
├── Models/                    # Eloquent Models
├── Services/                  # Business Logic Layer
│   ├── EventService.php
│   ├── CategoryService.php
│   ├── MediaService.php
│   └── PaymobPaymentService.php
└── Interfaces/
    └── PaymentGatewayInterface.php
```

---

## 🔒 Security

- Passwords are hashed using **bcrypt**
- Tokens managed by **Laravel Sanctum**
- Payment callbacks verified using **HMAC SHA-512** signature
- Role-based middleware protects admin and user routes
- Input validation applied on all endpoints

---

## 👤 Author

**Karim Mohamed**
[GitHub](https://github.com/Karimmohamed736)

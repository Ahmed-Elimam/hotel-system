# Laravel 12 Hotel Management System

## Overview
This project is a comprehensive Hotel Management System built with Laravel 12. It provides functionalities for managing hotel operations, including room and floor management, reservations, and user roles such as Admin, Manager, Receptionist, and Client. The system integrates Spatie Laravel Permission for robust role and permission management and leverages PHP 8.3 features for optimal performance.

## Features
- **Role-Based Access Control (RBAC)**: Managed using Spatie Laravel Permission.
- **User Authentication**: Secure authentication with Laravel Breeze/Fortify.
- **Room and Floor Management**: CRUD operations for rooms and floors with appropriate access restrictions.
- **Reservation System**: Clients can make reservations, and receptionists can approve them.
- **Stripe Integration**: Clients can pay for reservations via Stripe.
- **Statistics & Reports**: Various charts to track reservations and revenue.

## Installation
### Prerequisites
Ensure you have the following installed:
- PHP 8.3
- Composer
- Laravel 12
- MySQL

### Steps
1. **Clone the repository:**
   ```bash
   git clone https://github.com/Ahmed-Elimam/hotel-system.git
   cd hotel-system
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Set up environment variables:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Configure database settings in the `.env` file.

4. **Run migrations:**
   ```bash
   php artisan migrate --seed
   ```
   This will create the necessary tables and seed roles/permissions.

5. **Start the server:**
   ```bash
   php artisan serve
   ```

## Usage
- Visit `http://127.0.0.1:8000/register` to register as a client.
- Admins can assign roles and permissions using Spatie's built-in functionality.
- Managers can manage floors, rooms, and receptionists.
- Receptionists can approve clients and manage reservations.
- Clients can make and view reservations.

## Role and Permission Management
- Run the following to check existing roles/permissions:
  ```bash
  php artisan permission:show
  ```
- Assign a role to a user:
  ```php
  $user = User::find(1);
  $user->assignRole('client');
  ```

## Testing
Run tests using PHPUnit:
```bash
php artisan test
```

## Postman Collection  
To import the Postman collection, open Postman and go to **File > Import**, then select the JSON file from the `postman/` directory.

## Contributing
Contributions are welcome! If you would like to contribute, please fork the repository, create a feature branch, make your changes, and submit a pull request.

## License
This project is open-source and licensed under the [MIT License](LICENSE).

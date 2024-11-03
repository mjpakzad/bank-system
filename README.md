# bank-system
A banking system implemented with Laravel 11.

## Features
- **Money Transfer API:** Transfer funds between cards using a RESTful API.
- **Card Number Validation:** Validate card numbers using predefined bank prefixes.
- **Persian and English Numerals Support:** Accepts both Persian and English numerals for card numbers and amounts.
- **ACID Transactions:** Processes transactions with full compliance to ACID principles.
- **Email Notifications:** Sends email notifications to users after transactions.
- **Top Users API:** Retrieve the top three users with the most transactions in the last 10 minutes, along with their last 10 transactions.
- **Dockerized:** Fully containerized using Docker for easy setup and deployment.
- **Redis Queue:** Utilizes Redis for queue management.
- **Laravel Horizon and Telescope:** Integrated for monitoring queues and debugging.

## Prerequisites
- **Docker**
- **Docker Compose**
- **Make** (optional, for using the provided Makefile)

## How to Use
### Using the Makefile
1. **Initial Setup**
```
make setup
```
This command will:

- Copy ```.env.example``` to ```.env```
- Build and start the Docker services
- Install Composer dependencies
- Generate the application key
- Run migrations and seed the database
2. **Start Services**
```
make up
```
3. **Stop Services**
```
make down
```
4. **Rebuild Services**
```
make rebuild
```
5. **Run Tests**
```
make test
```
6. **Run Artisan Commands**
```
make artisan migrate
```
7. **Run Composer Commands**
```
make composer require vendor/package-name
```
8. **View Logs**
```
make logs
```
### Without Using the Makefile
1. **Clone the Repository**
```
git clone https://github.com/mjpakzad/bank-system.git
cd bank-system
```
2. **Copy the ```.env``` File**
```
cp .env.example .env
```
3. **Build and Start the Docker Services**
```
docker-compose up -d --build
```
4. **Install Composer Dependencies**
```
docker-compose exec bank-app composer install
```
5. **Generate the Application Key**
```
docker-compose exec bank-app php artisan key:generate
```
6. **Run Migrations and Seed the Database**
```
docker-compose exec bank-app php artisan migrate --seed
```
7. Run Tests
```
docker-compose exec bank-app php artisan test
```
### Accessing the Application
- Application URL: http://localhost
- Laravel Telescope: http://localhost/telescope
- Laravel Horizon: http://localhost/horizon

## Additional Information
### Queue Management
- The ```queue``` service in ```docker-compose.yml``` continuously processes the queues.
- Redis is used as the queue driver.

### Email Sending
- Emails are sent to users after each transaction.
- Use Laravel Telescope to view the sent emails.

### Redis Configuration
- The ```phpredis``` extension is used to connect to Redis.
- Ensure ```REDIS_CLIENT=phpredis``` is set in the ```.env``` file.

### Running Artisan or Composer Commands
- **Artisan:**
```
docker-compose exec bank-app php artisan {command}
```
- **Composer:**
```
docker-compose exec bank-app composer {command}
```

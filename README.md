Back End

-   JWT authentication (login/logout)
-   CRUD Authors
-   CRUD Publishers
-   CRUD Books
-   Pagination & search
-   Seeder with dummy data

1. Clone repo
2. Copy `.env.example` ke `.env` dan sesuaikan konfigurasi
3. Install dependencies:
   composer install
4. Generate app key:
   php artisan key:generate
5. Run migrations & seeders:
   php artisan migrate --seed
6. Generate JWT
   php artisan jwt:secret
7. Start server:
   php artisan serve

Swagger Documentation = http://192.168.56.56:8000/api/documentation
url menyesuaikan running local

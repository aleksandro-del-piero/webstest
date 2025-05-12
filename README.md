## 🚀 Installation

Laravel is a web application framework with expressive and elegant syntax. It provides tools and resources to build modern PHP applications quickly and efficiently by simplifying common development tasks.

### 📦 Steps to install

1. **Clone the repository**:

    ```bash
    git clone https://github.com/aleksandro-del-piero/webstest.git
    cd webstest
    ```

2. **Create the database**:

   Before you proceed with the Laravel setup, make sure to create a new database for your application. You can do it via your database management system (e.g., MySQL, PostgreSQL, etc.) or using a CLI command:

    - **For MySQL**:

      ```bash
      mysql -u root -p
      CREATE DATABASE webstest;
      exit;
      ```

3. **Copy the example environment file and install dependencies**:

    ```bash
    cp .env.example .env
    composer install
    ```

4. **Configure database connection**:

   Open the `.env` file and configure the database connection. For MySQL, it might look like this:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=webstest
   DB_USERNAME=root
   DB_PASSWORD=

5. **Generate application key**:

    ```bash
    php artisan key:generate
    ```

6. **Migrate database and seeding**:

    ```bash
    php artisan migrate --seed
    ```

7. **Start the development server**:

    ```bash
    php artisan serve
    ```

   Your application should now be accessible at `http://127.0.0.1:8000/`
---

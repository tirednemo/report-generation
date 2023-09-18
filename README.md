# Report Generation

This guide is a walk-through of the steps required to run this Laravel application locally. The project uses Blade templates with Tailwind CSS for the views and Vite to bundle assets.

## Prerequisites
- PHP (8.1 or higher)
- Laravel (10.10 or higher)
- Composer
- Node.js (16 or higher)
- MySQL or any other compatible database management system

## Clone the Repository
Start by cloning the project repository from GitHub onto local machine.\
Open terminal and navigate to the directory where you want to clone the repository, then run: `git clone https://github.com/tirednemo/demo.git`

## Install Dependencies
Once the repository is cloned, navigate into the project directory and install the PHP dependencies using Composer: `composer install`\
After the PHP dependencies are installed, install the JavaScript dependencies using NPM: `npm install`

## Configure the Environment
Copy the **.env.example** file and rename it to **.env**: `cp .env.example .env`\
Open the **.env** file in a text editor and configure the necessary environment variables, such as database connection details.\
Generate app key. `php artisan key:generate`

## Migrate the Database
Before running the application, you need to migrate the database tables. Run: `php artisan migrate`

## Build Assets
To start the Vite development server for automatically compiling the assets (CSS and JavaScript files), run the following command: `npm run dev`

## Serve the Application
You can now run the Laravel application using the built-in development server. Run the following command: `php artisan serve`

By default, the application will be accessible at http://localhost:8000. Open your web browser and visit that URL to view the application.

## Conclusion
Congratulations! You have successfully set up the application locally.

For more information about Laravel and Laravel Breeze, refer to the official documentation:

* [Laravel](https://laravel.com/docs)

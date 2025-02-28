# Task Manager (Laravel + React) 🚀  

This project is a task management web application built with **Laravel** for the backend and **React** for the frontend.

---

## 📌 Features
✅ CRUD operations for tasks (Create, Read, Update, Delete)  
✅ Task categories  
✅ Filtering and sorting tasks  
✅ Pagination  
✅ Reactive UI with React  
✅ REST API with Laravel  

---

## 🔧 Installation & Setup

### 1. Clone the Repository

git clone https://github.com/IhZhur/my-laravel-app.git
cd my-laravel-app

### 2. Install Dependencies

Install Laravel and Node.js dependencies:
composer install
npm install

### 3. Configure Environment

Copy the .env.example file to .env:
cp .env.example .env

Generate the Laravel application key:
php artisan key:generate

Set up the database in .env:
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

Create the database file:
touch database/database.sqlite                      # MacOS/Linux
type nul > database/database.sqlite                 # Windows (CMD)
New-Item database/database.sqlite -ItemType File    # Windows (PowerShell)

Run migrations:
php artisan migrate

### 4. Start the Development Server

Run Laravel:
php artisan serve

Run Vite for the frontend:
npm run dev

Then, open http://localhost:8000 in your browser.

### Project Structure

my-laravel-app/
app/                        # Laravel controllers, models, services
database/                   # Migrations and SQLite database
resources/
        js/                     # React files
            components/         # React components
                TaskList.jsx
                TaskItem.jsx
                TaskForm.jsx
            app.jsx             # React entry point
        views/                  # Blade templates
routes/                     # Laravel routes
public/                     # Compiled CSS/JS files
package.json                # NPM dependencies
vite.config.js              # Vite configuration
.env                        # Environment variables
README.md                   # Documentation

🛠 API Endpoints

1. Get all tasks
📌 GET /api/tasks
Response Example:

[
  {
    "id": 1,
    "title": "Complete test assignment",
    "description": "Need to finish the task and submit",
    "completed": false
  }
]

2. Create a new task
📌 POST /api/tasks
Request Body (JSON):

{
  "title": "New Task",
  "description": "Task description",
  "completed": false
}

3. Update a task
📌 PUT /api/tasks/{id}
Request Body (JSON):

{
  "title": "Updated Task",
  "description": "Updated description",
  "completed": true
}

4. Delete a task
📌 DELETE /api/tasks/{id}

Useful Commands

Clear Laravel cache:
php artisan cache:clear
php artisan config:clear
php artisan view:clear

Build frontend for production:
npm run build

Run tests:
php artisan test

📜 License
This project is licensed under the MIT License.
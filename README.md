# School Attendance System

A simple Laravel 12 + React  project for managing student attendance.
Supports Admin and Teacher roles.

## Features

### Admin
Register students
Register teachers
View Student Report (daily records + summary)
View Class Monthly Report

### Teacher
Mark daily attendance for a class
View Student Report (daily records + summary)
View Class Monthly Report

## Backend Setup (Laravel 12)

1) Clone the repo & install dependencies:
composer install
cp .env.example .env
php artisan key:generate

2) Configure .env for database:
    DB_CONNECTION=mysql
    DB_DATABASE=school_attendance
    DB_USERNAME=root
    DB_PASSWORD=

3) Run migrations & seeders:
php artisan migrate --seed

### This seeds two users:

Admin: admin@school.com / password

Teacher: teacher@school.com / password

4) Start server: php artisan serve



## Frontend Setup (React)

1) Go into frontend folder:
cd school-attendance-web
npm install

2) Create .env file: VITE_API_URL=http://127.0.0.1:8000/api

3) Run frontend: npm run dev 
App runs at: http://127.0.0.1:5173

## Usage
### Admin Dashboard

Manage Students → Add/list students
Manage Teachers → Add/list teachers
Student Report → Enter student ID → view daily attendance + summary
Class Report → Enter class name + month → view class attendance summary

### Teacher Dashboard

Mark Attendance → Select class, pick date, mark present/absent → save
Student Report → Enter student ID → view daily attendance + summary
Class Report → Enter class name + month → view class attendance summary






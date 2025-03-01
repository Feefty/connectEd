# ConnectEd - Learning Management System

## Overview
**connectEd** is a Learning Management System (LMS) developed as a thesis project using **Laravel 5**. The platform is designed to facilitate school operations by providing an online environment where teachers, students, and administrators can manage courses, exams, grades, and notifications. The goal of the project is to improve the learning experience and streamline administrative workflows within schools.

## Features

### Working Features:
- **User Management**: Create and manage users (students, teachers, administrators).
- **Course Management**: Organize and manage subjects, lessons, and class schedules.
- **Exam Management**: Create, manage, and grade student exams and assignments.
- **Gradebook**: Track student grades and monitor academic performance.
- **Room Scheduling**: Assign and manage classroom schedules for different subjects and exams.
- **Notifications**: Notify users about important updates such as upcoming exams, deadlines, and announcements.

## Requirements

- **PHP**: Version 5.6 or later
- **Laravel**: Version 5.x
- **MySQL**: Database for storing application data
- **Web Server**: Apache or Nginx

## Installation

### Step 1: Clone the Repository
Clone the **connectEd** repository to your local machine:
```bash
git clone https://github.com/Keinstah/connectEd.git
```

### Step 2: Set Up Environment
1. Navigate to the project directory.
2. Copy `.env.example` to `.env`:
```bash
cp .env.example .env
```
3. Configure your database and other environment settings in the `.env` file.

### Step 3: Install Dependencies
Run the following command to install Laravel dependencies:
```bash
composer install
```

### Step 4: Generate Application Key
Generate the application key using the following command:
```bash
php artisan key:generate
```

### Step 5: Migrate the Database
Run the database migrations to set up the necessary tables:
```bash
php artisan migrate
```

### Step 6: Run the Application
Start the Laravel development server:
```bash
php artisan serve
```
The application will now be accessible at `http://localhost:8000`.

## Usage

- **Admin Dashboard**: Admin users can manage students, teachers, courses, and overall settings.
- **Student Dashboard**: Students can view their classes, assignments, grades, and upcoming exams.
- **Teacher Dashboard**: Teachers can create assignments, grade exams, and manage their lessons.

## Contribution

Contributions are welcome! To contribute:
1. Fork the repository.
2. Create a new branch for your feature (`git checkout -b feature-name`).
3. Commit your changes (`git commit -am 'Add new feature'`).
4. Push your branch (`git push origin feature-name`).
5. Submit a pull request.

## License

This project is open-source and available under the MIT License.

## Acknowledgments

- **Laravel**: For providing an elegant and robust framework for building this application.
- All contributors who have helped improve the project.

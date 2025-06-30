# Person Registration System

A Laravel-based web application for managing person registrations with user authentication, role-based access control, and dashboard statistics.

---

## Features

- User authentication (Login and Register) using Laravel Breeze  
- Role-based access (Data Entry and Viewer roles)  
- Full Person CRUD (Create, Read, Update, Delete) functionality  
- Dashboard with statistics:
  - Age group distribution
  - Birth month breakdown
  - Religion-wise categorization  
- Responsive user interface built with Bootstrap and Tailwind CSS  

---

## Requirements

- PHP 8.2 or higher  
- Composer  
- Node.js and npm  
- MySQL or any compatible relational database  

---

## Installation Instructions

### 1. Clone the repository

```bash
git clone https://github.com/Eshan231998/Practical-Assessment-Task.git
cd Practical-Assessment-Task
```

### 2. Install PHP dependencies
```bash
composer install
```

### 3. Install Node dependencies
```bash
npm install
npm run dev
```

### 4. Configure environment variables
```bash
cp .env.example .env
```

### Open the .env file and update the following database credentials: 
```bash
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### Generate the application key:
```bash
php artisan key:generate
```

### 5. Run database migrations and seeders
```bash
php artisan migrate --seed
```

###  6. Start the development server
```bash
php artisan serve
```

Visit: http://localhost:8000


### Dashboard Overview
The dashboard displays key statistics about registered persons, including:

```*. Total number of persons ```
```*. Age group distribution ```
```*. Birth month statistics ```
```*. Religion-wise counts ```


| Role       | Permissions                                   |
| ---------- | --------------------------------------------- |
| Data Entry | Create, Edit, View, and Search person records |
| Viewer     | View and Search only                          |



### Additional Notes
```Frontend uses a combination of Tailwind CSS and Bootstrap```
```Laravel Breeze handles the authentication system```
```The project is configured for MySQL by default, but you can modify the .env file for other databases```


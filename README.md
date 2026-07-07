# Legends Fitness - Gym Management System
A full-stack gym management system built with **PHP, MySQL, HTML, CSS, and JavaScript**. 
It was developed as a semester project for Introduction to Database Systems, focusing on 
relational database design (3NF normalization) with a functional web interface for 
real-world gym operations.

## Features

### Member Features
- Sign up / Sign in
- Dashboard with fitness overview (workout streak, calories burned, body measurements)
- View and manage membership plan
- Browse and enroll in fitness programs & schedules
- Track personal fitness goals
- View assigned trainers
- Submit support requests

### Admin Features
- Admin dashboard (total earnings, members, trainers, active programs)
- Manage members, trainers, and programs
- Manage membership plans
- View recent activity
- Handle member support requests

## Tech Stack
- **Backend:** PHP
- **Database:** MySQL (MariaDB)
- **Frontend:** HTML, CSS

## Database Design
The database follows **Third Normal Form (3NF)** and consists of 10 related tables:
- `admin` — admin accounts
- `members` — member profiles
- `trainers` — trainer profiles and specializations
- `plans` — membership plans
- `programs` — fitness programs and schedules
- `plan_programs` — junction table (plans ↔ programs)
- `member_plans` — member subscriptions
- `member_programs` — member program enrollments
- `goals` — member fitness goals
- `requests` — support/password reset requests

All relationships are enforced using primary and foreign keys to maintain data integrity.

## Setup Instructions

1. **Clone the repository**

2. **Add images**
   - Download all images from the `images` branch of this repository.
   - Create a folder named `pics` in the same directory as the website files.
   - Place all downloaded images inside the `pics` folder.

3. **Set up the database**
   - Open **phpMyAdmin** (via XAMPP).
   - Create a new database called `gym`.
   - Import the `gym.sql` file to load all required tables and data.

4. **Start the server**
   - Open **XAMPP Control Panel**.
   - Start **Apache** and **MySQL**.
   - Move the project folder into `htdocs` (if not already there).

5. **Run the project**
   - Open your browser and go to `http://localhost/your-project-folder-name`.

## Requirements
- XAMPP (Apache + MySQL + PHP)
- Web browser

## Conclusion
This project demonstrates practical relational database design, SQL query implementation, 
and the integration of a simple front-end interface for a real-world gym management scenario.

# 3D Consulting Learning & Tutor Management Platform (3D-LTP)

**Enterprise-Grade Tutoring Operations Platform**

A modern, production-ready SaaS platform for managing one-on-one tutoring, small group classes, online learning, tutor management, parent communication, attendance, assignments, evaluations, automatic teacher timesheets, and comprehensive reporting.

## Tech Stack

- **Laravel 12** with **PHP 8.3+**
- **Livewire** + **Volt** (Reactive components)
- **Tailwind CSS** + **Alpine.js** (Modern UI)
- **MySQL 8** (Production database)
- **Spatie Laravel Permission** (RBAC)
- **Google Calendar & Meet APIs**
- **PDF & Excel Export**

## Core Features

✅ One-on-one tutoring with automatic scheduling  
✅ Google Calendar sync & Google Meet integration  
✅ Automatic timesheet generation from completed classes  
✅ Monthly evaluations automatically distributed to parents  
✅ Parent portal with multi-child switching  
✅ Attendance tracking with automatic recording  
✅ Assignments & grading with rubrics  
✅ Role-based dashboards (Super Admin, Admin, Head of Study, Teacher, Student, Parent)  
✅ Dark mode & responsive design  

## User Roles

- **Super Admin** - Full platform management
- **Admin** - Organization management
- **Head of Study** - Academic oversight
- **Teacher** - Class delivery & grading
- **Student** - Learning & submission
- **Parent** - Child monitoring & communication

## Database Architecture

### Core Tables

**Authentication**
- users
- roles
- permissions
- role_has_permissions
- model_has_permissions
- sessions
- password_resets
- personal_access_tokens

**Academic**
- students
- teachers
- parents
- subjects
- academic_levels
- subject_categories
- enrollments
- enrollment_schedules

**Teaching & Learning**
- class_sessions
- attendance
- assignments
- assignment_submissions
- projects
- project_submissions
- learning_resources
- quizzes
- quiz_questions
- quiz_attempts

**Assessment & Evaluation**
- scores
- monthly_evaluations
- behaviour_reports
- student_progress
- teacher_comments

**Operations**
- teacher_timesheets
- teacher_timesheet_items
- calendar_events
- google_meet_sessions
- reschedule_requests

**Communication**
- notifications
- messages
- announcements
- email_logs

**CMS & Audit**
- pages
- posts
- testimonials
- faqs
- gallery
- site_settings
- activity_logs
- audit_logs
- login_history

## Development Order

1. Database Architecture & Migrations
2. Core Models & Relationships
3. Authentication System
4. Spatie Permission Setup
5. Enrollment Engine (Core Business Logic)
6. Class Scheduling & Google Integration
7. Attendance System
8. Assignment & Grading System
9. Evaluation System
10. Automatic Timesheet Engine
11. Parent Portal
12. Reporting & Analytics
13. CMS & Landing Page
14. Deployment & Testing

## Architecture Principles

- **Clean Architecture**: Services, Repositories, Policies, DTOs, Events, Jobs
- **SOLID Principles** + **PSR Standards**
- **No business logic in controllers**
- **Production-ready code only**
- **Comprehensive testing**

## Getting Started

```bash
git clone https://github.com/abdulvatsa/-Tutor-Management-Platform-3D-LTP-.git
cd -Tutor-Management-Platform-3D-LTP-
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan seed:PermissionsSeeder
php artisan serve
```

## License

Proprietary - 3D Consulting

## Status

🚀 Under Development - Database Architecture Phase

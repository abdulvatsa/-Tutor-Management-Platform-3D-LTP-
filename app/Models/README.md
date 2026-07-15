# Core Models - Eloquent Models with Relationships

This directory contains all Eloquent models for the 3D-LTP platform with comprehensive relationships and scopes.

## Model Hierarchy

### User Management Models

**User** (`app/Models/User.php`)
- Core authentication model extending Laravel's Authenticatable
- Relations: Organization, Student, Teacher, Parent, Children
- Traits: HasRoles, HasPermissions (Spatie), HasApiTokens
- Scopes: `active()`, `inOrganization()`, `withRole()`

**Organization** (`app/Models/Organization.php`)
- Multi-tenant organization container
- Relations: Users, Students, Teachers, Subjects, Enrollments, ClassSessions, Assignments, Timesheets
- Settings stored as JSON for flexibility

**Student** (`app/Models/Student.php`)
- Student profile with academic information
- Relations: User, Organization, AcademicLevel, Enrollments, Attendance, Assignments, Scores, Evaluations, Parents
- Scopes: `active()`, `inOrganization()`, `byAcademicLevel()`
- Appends: `full_name` attribute

**Teacher** (`app/Models/Teacher.php`)
- Teacher profile with employment details
- Relations: User, Organization, Subjects, ClassSessions, Assignments, Timesheets, Evaluations, CalendarEvents
- Scopes: `active()`, `inOrganization()`, `teachingSubject()`
- Appends: `full_name` attribute

**Parent** (`app/Models/Parent.php`)
- Parent/Guardian profile
- Relations: User, Organization, Students (children)
- Scopes: `active()`, `inOrganization()`
- Appends: `full_name` attribute

### Academic Models

**Subject** (`app/Models/Subject.php`)
- Subject/Course definition
- Relations: Organization, Teachers, ClassSessions, Assignments
- Scopes: `active()`, `inOrganization()`

**AcademicLevel** (`app/Models/AcademicLevel.php`)
- Grade levels and academic progression
- Relations: Organization, Students
- Scopes: `active()`, `inOrganization()`

**Enrollment** (`app/Models/Enrollment.php`)
- Core: Student-Teacher-Subject binding for a course
- Relations: Organization, Student, Teacher, Subject, AcademicLevel, Schedules, ClassSessions
- Scopes: `active()`, `completed()`, `inOrganization()`
- Fields: Enrollment date, completion date, rate, currency, status

**EnrollmentSchedule** (`app/Models/EnrollmentSchedule.php`)
- Recurring schedule pattern for enrollment
- Relations: Enrollment
- Fields: Day of week, start/end times, duration

### Teaching & Learning Models

**ClassSession** (`app/Models/ClassSession.php`)
- Individual class session occurrence
- Relations: Organization, Enrollment, Teacher, Subject, Attendance, Evaluations
- Scopes: `upcoming()`, `completed()`, `inOrganization()`
- Fields: Scheduled date/time, duration, status, location, meeting URL

**Attendance** (`app/Models/Attendance.php`)
- Student attendance record for each class
- Relations: Organization, ClassSession, Enrollment, Student
- Scopes: `present()`, `absent()`, `late()`
- Statuses: present, absent, late, excused

**Assignment** (`app/Models/Assignment.php`)
- Assignment definition by teacher
- Relations: Organization, Teacher, Subject, Submissions, Classes
- Scopes: `dueToday()`, `overdue()`, `inOrganization()`
- Types: homework, project, quiz, essay, etc.

**AssignmentSubmission** (`app/Models/AssignmentSubmission.php`)
- Student assignment submission
- Relations: Assignment, Student
- Scopes: `submitted()`, `graded()`, `pending()`
- Fields: Points earned, feedback, graded by, graded at

**Quiz** (`app/Models/Quiz.php`)
- Quiz assessment definition
- Relations: Organization, Teacher, Subject, Questions, Attempts
- Fields: Duration, total points, passing score, publish status

**QuizQuestion** (`app/Models/QuizQuestion.php`)
- Individual quiz question
- Relations: Quiz
- Types: multiple choice, essay, true/false, short answer

**QuizAttempt** (`app/Models/QuizAttempt.php`)
- Student quiz attempt
- Relations: Quiz, Student
- Fields: Started at, completed at, score, percentage, answers

### Assessment & Evaluation Models

**Score** (`app/Models/Score.php`)
- Individual score record
- Relations: Student, Subject, Enrollment
- Fields: Assessment type, points, percentage, grade

**MonthlyEvaluation** (`app/Models/MonthlyEvaluation.php`)
- Monthly evaluation report for parents
- Relations: Organization, ClassSession, Student, Teacher
- Scopes: `sent()`, `draft()`
- Fields: Academic performance, behaviour, attendance rate, comments

**BehaviourReport** (`app/Models/BehaviourReport.php`)
- Incident/behaviour report
- Relations: Organization, Student, Teacher, ClassSession
- Fields: Behaviour type, severity, action taken, parent notified

**StudentProgress** (`app/Models/StudentProgress.php`)
- Monthly progress tracking
- Relations: Student, Subject, Enrollment
- Fields: Overall score, learning objectives, challenges, recommendations

### Operations Models

**TeacherTimesheet** (`app/Models/TeacherTimesheet.php`)
- Monthly timesheet for teacher payment
- Relations: Organization, Teacher, Items
- Scopes: `submitted()`, `approved()`, `draft()`
- Statuses: draft, submitted, approved, rejected

**TeacherTimesheetItem** (`app/Models/TeacherTimesheetItem.php`)
- Individual timesheet line item
- Relations: Timesheet, ClassSession
- Fields: Date, start/end time, hours worked, rate, amount

**CalendarEvent** (`app/Models/CalendarEvent.php`)
- Calendar events (synced with Google Calendar)
- Relations: Organization, Teacher
- Fields: Start/end date and time, location, Google event ID

### Communication Models

**Notification** (`app/Models/Notification.php`)
- In-app notifications
- Relations: User
- Scopes: `unread()`, `read()`
- Fields: Type, title, message, data (JSON), action URL

**Message** (`app/Models/Message.php`)
- Direct messages between users
- Relations: Organization, Sender, Recipient
- Scopes: `unread()`, `read()`
- Fields: Subject, message, attachment URL

### Audit & Logging Models

**ActivityLog** (`app/Models/ActivityLog.php`)
- Audit trail of all model changes
- Relations: User
- Fields: Action, model type/id, old/new values, IP address, user agent

**LoginHistory** (`app/Models/LoginHistory.php`)
- Login/logout tracking
- Relations: User
- Fields: IP address, user agent, login/logout timestamps

## Relationship Diagrams

### User-Centric
```
User ──┬─ Organization (belongs to)
       ├─ Student (has one)
       ├─ Teacher (has one)
       ├─ Parent (has one)
       ├─ Children → Student (many-to-many)
       ├─ Notifications (has many)
       ├─ Messages (has many - sent & received)
       └─ LoginHistory (has many)
```

### Academic Flow
```
Enrollment ──┬─ Student
             ├─ Teacher
             ├─ Subject
             ├─ AcademicLevel
             ├─ EnrollmentSchedule (has many)
             └─ ClassSession (has many)
                      ├─ Attendance (has many)
                      ├─ MonthlyEvaluation (has many)
                      └─ Teacher
```

### Assignment Flow
```
Assignment ──┬─ Teacher
             ├─ Subject
             └─ AssignmentSubmission (has many)
                      ├─ Student
                      └─ Points/Feedback
```

## Using Models

### Basic Operations

```php
// Retrieve with relationships
$student = Student::with('user', 'organization', 'enrollments.teacher')
    ->find($id);

// Use scopes
$activeStudents = Student::active()->inOrganization($orgId)->get();

// Access relationships
foreach ($student->enrollments as $enrollment) {
    echo $enrollment->teacher->full_name;
}

// Get computed attribute
echo $student->full_name; // Uses $appends
```

### Eager Loading

```php
// Prevent N+1 queries
$enrollments = Enrollment::with([
    'student',
    'teacher',
    'subject',
    'classSessions' => fn ($q) => $q->upcoming()
])->inOrganization($orgId)->get();
```

### Custom Scopes

```php
// Combine scopes
$teachers = Teacher::active()
    ->inOrganization($orgId)
    ->teachingSubject($subjectId)
    ->get();
```

## Soft Deletes

Most models use SoftDeletes trait for safe deletion:

```php
// Soft delete
$student->delete();

// Query without deleted
Student::active()->get();

// Query only deleted
Student::onlyTrashed()->get();

// Restore
$student->restore();

// Force delete
$student->forceDelete();
```

## Timestamps

All models use timestamps (`created_at`, `updated_at`) except:
- `ActivityLog` - custom `created_at` only
- `LoginHistory` - custom `login_at`, `logout_at`

## Mass Assignment

All fillable attributes are explicitly defined. Never use `$guarded = []`.

## Performance Tips

1. **Always eager load relationships**
2. **Use scopes to filter efficiently**
3. **Leverage JSON fields for settings**
4. **Index frequently queried columns**
5. **Use pagination for large datasets**

## Next Steps

After models:
1. Create migrations for database schema
2. Create factories for testing
3. Create model observers for events
4. Create services for business logic
5. Create API resources

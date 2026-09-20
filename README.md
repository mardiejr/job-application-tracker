# Job Application Tracker

A full-stack web app for tracking job applications, built with Laravel. Users can log applications, manage companies, track status through a pipeline, attach notes, upload resumes, track interview dates, and get automated reminders — all backed by a real dashboard with statistics and charts.

## Tech Stack

- **Backend:** Laravel 13 (PHP 8.4)
- **Templating:** Blade
- **Styling:** Tailwind CSS
- **Database:** MySQL
- **Auth:** Laravel Breeze
- **Charts:** Chart.js
- **Testing:** PHPUnit (Feature tests)

## Features

### Authentication & Core CRUD
- Full authentication (register, login, logout, password reset) via Laravel Breeze
- Complete CRUD for job applications (create, view, edit, delete)
- Full CRUD for companies — add/edit/delete companies directly in-app
- Resume uploads (PDF/Word) with download and delete, linkable to any application

### Organization & Search
- Search applications by company or position
- Filter by status (Applied, Interviewing, Offer, Rejected, Withdrawn)
- Pagination on the applications list
- Notes on each application (add/delete), with timestamps

### Dashboard & Insights
- Real-time stat cards: total applications, interviewing, offers, activity in the last 30 days
- Status breakdown shown as a Chart.js doughnut chart
- Recent applications feed

### Interview Tracking & Notifications
- Interview date & time tracking per application
- Automated interview reminders via a scheduled Artisan command
- In-app notification bell with unread badge and mark-as-read

### Testing
- Feature test suite covering authentication, CRUD operations, and validation
- Isolated test database (separate from development data)

## Database Structure

```
User
 ├── hasMany → JobApplications
 ├── hasMany → Resumes
 └── notifiable (interview reminders)

Company
 └── hasMany → JobApplications

JobApplication
 ├── belongsTo → User
 ├── belongsTo → Company
 ├── belongsTo → Resume (nullable)
 └── hasMany → Notes

Resume
 ├── belongsTo → User
 └── hasMany → JobApplications

Note
 └── belongsTo → JobApplication
```

## Routes

| Route | Description |
|---|---|
| `/login`, `/register` | Authentication |
| `/dashboard` | Stats, chart, and recent activity |
| `/applications` | List, search, and filter applications |
| `/applications/create` | Log a new application |
| `/applications/{id}` | View application details and notes |
| `/applications/{id}/edit` | Edit an application |
| `/companies` | Manage companies |
| `/resumes` | Upload and manage resumes |
| `/profile` | User profile settings |

## Setup

```bash
# Clone the repo
git clone <your-repo-url>
cd job-application-tracker

# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Configure your MySQL database in .env, then:
php artisan migrate

# Create the storage symlink (for resume uploads)
php artisan storage:link

# Build frontend assets
npm run build

# Serve the app
php artisan serve
```

### Interview Reminders (optional)

To enable automated interview reminders locally, run:

```bash
php artisan app:send-interview-reminders
```

In production, this would be scheduled via `routes/console.php` and a real cron job.

## Testing

Create a separate test database, then configure it in `phpunit.xml`:

```bash
php artisan test
```

## Screenshots

*(Add dashboard, applications list, and company management screenshots here.)*

## Author

MardieJr — BSIT student, STI College Santa Rosa

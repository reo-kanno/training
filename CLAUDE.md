# CLAUDE.md

## Project Overview

A fitness and health tracking web application built with **Laravel 12 + React 18 (Inertia.js)**. Users can log workouts, meals, body weight, and manage exercise definitions. The app uses Inertia.js as the bridge between Laravel and React (no separate API — server-driven SPA).

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | PHP 8.2+, Laravel 12 |
| Frontend | React 18, Inertia.js 2.0 |
| CSS | Tailwind CSS 3.2 (utility classes) |
| Build | Vite 7 |
| Auth | Laravel Sanctum, Laravel Breeze scaffolding |
| Database | SQLite (dev default), MySQL supported |
| Testing | PHPUnit 11 |
| Docker | Laravel Sail (compose.yaml) |
| Code Style | Laravel Pint (PHP formatter) |

## Directory Structure

```
app/
├── Http/Controllers/       # Route controllers (auth fully implemented, domain controllers are stubs)
├── Http/Middleware/         # HandleInertiaRequests
├── Http/Requests/          # Form request validation classes
├── Models/                 # Eloquent models (User complete, domain models are stubs)
├── Providers/              # Service providers
config/                     # Laravel config files (app, auth, database, etc.)
database/
├── migrations/             # 8 migrations (users, exercises, workout_logs, workout_exercises, meal_logs, body_weights, cache, jobs)
├── factories/              # Model factories
├── seeders/                # Database seeders
resources/
├── js/
│   ├── app.jsx             # React entry point
│   ├── bootstrap.js        # Axios setup
│   ├── Components/         # 12 reusable UI components (TextInput, Modal, Dropdown, etc.)
│   ├── Layouts/            # AuthenticatedLayout, GuestLayout
│   └── Pages/              # React pages organized by feature (Auth/, Profile/, Dashboard, Welcome)
├── css/app.css             # Tailwind entry
├── views/app.blade.php     # Single Blade template (Inertia root)
routes/
├── web.php                 # Main routes
├── auth.php                # Auth routes (Breeze-generated)
tests/
├── Feature/                # Feature tests (Auth, Profile)
├── Unit/                   # Unit tests
```

## Key Commands

```bash
# Full project setup (install deps, generate key, migrate, build assets)
composer setup

# Run dev environment (concurrent: PHP server, queue worker, log tail, Vite HMR)
composer dev

# Run tests
composer test
# or directly:
php artisan config:clear && php artisan test

# PHP code formatting
./vendor/bin/pint

# Frontend build
npm run build

# Frontend dev server only
npm run dev
```

## Database Schema

- **users** — Standard Laravel auth (name, email, password)
- **exercises** — Exercise definitions (name, category, description)
- **workout_logs** — Workout sessions (user_id FK, date, total_duration, memo, condition 1-5)
- **workout_exercises** — Sets within a workout (workout_log_id FK, exercise_id FK, sets, reps, weight, order)
- **meal_logs** — Meal entries (user_id FK, date, meal_type enum, calories, protein, carbs, fat, image)
- **body_weights** — Body measurements (user_id FK, date, weight, body_fat_percentage)

## Implementation Status

**Complete:**
- Authentication (register, login, password reset, email verification)
- Profile management (edit, update, delete account)
- All database migrations
- Reusable React UI component library
- Layout system (Authenticated + Guest)

**Stubs / Not Yet Implemented:**
- Domain controllers (WorkoutLog, Exercise, MealLog, BodyWeight, WorkoutExercise) — empty
- Domain model relationships and business logic
- Domain-specific form request validation
- Frontend pages for domain features
- Domain feature tests

## Code Conventions

### PHP (Backend)
- PSR-4 autoloading under `App\` namespace
- PascalCase for classes, snake_case for methods/variables/database columns
- Type hints on method parameters and return types
- Validation via FormRequest classes (not inline in controllers)
- Eloquent models define `$fillable`, `$hidden`, `$casts` as needed
- Format with `./vendor/bin/pint` (Laravel Pint)

### JavaScript/React (Frontend)
- Functional components with hooks (no class components)
- PascalCase for components, camelCase for functions/variables
- Inertia.js `useForm()` for form state and submission
- Inertia.js `usePage()` for accessing shared server data
- `router.visit()` / `router.post()` for navigation (no axios calls for page transitions)
- Tailwind utility classes for all styling (no custom CSS)
- Components accept props directly (no Redux/Context for domain state)

### Routing
- Named routes: `route('dashboard')`, `route('profile.edit')`
- Middleware groups: `auth`, `verified`, `guest`
- Inertia responses: `return Inertia::render('PageName', $props);`

### Testing
- PHPUnit with `RefreshDatabase` trait
- SQLite in-memory for test database
- Feature tests for HTTP endpoints, Unit tests for isolated logic
- Config in `phpunit.xml`

## Architecture Notes

- **Inertia.js pattern**: No REST API. Controllers return `Inertia::render()` with props. React pages receive props directly. Forms submit via Inertia's `useForm().post()` / `.patch()` / `.delete()`.
- **No separate API layer**: All communication goes through Inertia's protocol (XHR with JSON payloads, managed by the framework).
- **Asset path aliases**: `@` maps to `resources/js/` (configured in `jsconfig.json` and Vite).
- **Docker**: Laravel Sail with MySQL, Redis, Meilisearch, Mailpit, phpMyAdmin, Selenium (see `compose.yaml`).

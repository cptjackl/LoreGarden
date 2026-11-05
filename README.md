# LoreGarden

LoreGarden is a worldbuilding app for tabletop RPG and fiction writers. Authenticated users catalogue the pieces of a setting — **locations**, **characters** and **artifacts** — and the relationships between them (who lives where, who owns which item, where an item is kept). Records can be created, searched, viewed, edited and deleted.

Created as a term capstone project for Web Programming Languages, and also serves as a portfolio piece demonstrating a modern Laravel + Livewire stack.

The app follows RESTful resource routing: each record type (`locations`, `characters`, `artifacts`) is registered with `Route::resource`, giving `GET /locations`, `GET /locations/{id}`, `PUT /locations/{id}` and `DELETE /locations/{id}`, all behind authentication (see [routes/web.php](routes/web.php)). Records are created through Livewire components rather than a `POST` route.

## Tech stack

| Layer | Technology | Role |
|---|---|---|
| Language | PHP 8.2+ | Backend language |
| Framework | **Laravel 12** | Routing, controllers, Eloquent ORM, migrations, validation, queues |
| Reactive UI | **Livewire** + **Volt** | Server-driven components without writing a JS SPA; Volt provides single-file components for the auth/settings screens |
| Component library | **Flux UI** (`livewire/flux`) | Prebuilt, accessible UI components (inputs, buttons, navigation, modals) |
| Authentication | **Laravel Fortify** | Headless auth backend (registration, login, password reset, 2FA support) |
| Styling | **Tailwind CSS 4** | Utility-first CSS via `@tailwindcss/vite` |
| Build tool | **Vite 7** + `laravel-vite-plugin` | Asset bundling and hot reload |
| Database | **SQLite** (default) | Zero-config storage; swappable for MySQL/PostgreSQL via `.env` |
| Data generation | Faker | Seed data via model factories |

The project started from the official **Laravel Livewire starter kit**, then was extended with the lore-management domain.

## Authentication

Authentication is handled by **Laravel Fortify**, with the UI built from **Livewire Volt** components (`resources/views/livewire/auth`) and Flux components.

- Registration, login/logout and password reset flows (enabled in `config/fortify.php`)
- Login, register, forgot/reset password, confirm password, email verification and two-factor challenge views
- Two-factor authentication columns are migrated and the settings UI is included; the feature is toggled in `config/fortify.php`
- User settings pages: profile, password, appearance (light/dark) and account deletion
- Every lore route is protected by the `auth` middleware, so the whole app requires login (see [routes/web.php](routes/web.php))
- Database-backed sessions (`SESSION_DRIVER=database`)
- Fortify actions in `app/Actions/Fortify` handle user creation and password rules

## ORM and data model

Data access uses **Eloquent**, Laravel's Active Record ORM, with schema managed by migrations and seeded by model factories.

| Model | Relationships |
|---|---|
| `User` | Creator of every location, character and artifact |
| `Location` | `belongsTo` User (creator); `hasMany` Characters; `hasMany` Artifacts |
| `Character` | `belongsTo` User (creator); `belongsTo` Location; `hasMany` Artifacts (as owner) |
| `Artifact` | `belongsTo` User (creator); `belongsTo` Location; `belongsTo` Character (owner) |

Eloquent and database features in use:

- **Relationships:** `belongsTo` and `hasMany` across all models
- **Migrations** (`database/migrations`) with foreign keys: deleting a user cascades to their records, while deleting a location or character sets dependent foreign keys to `NULL`, so nothing is orphaned
- **Mass assignment** protection via `$fillable`
- **Factories and seeders** (`database/factories`, `DatabaseSeeder`) generate demo users, 5 locations, 10 characters and 25 artifacts
- **Query builder** filtering and `LIKE` search in the Livewire `Search` component

## Features

- Dashboard plus index and detail pages for locations, characters and artifacts
- Create forms implemented as Livewire components (`CreateLocation`, `CreateCharacter`, `CreateArtifact`)
- Reusable live **search/filter** component that works for any model
- Update and delete through resource routes (`PUT` / `DELETE`) on controllers (`show`, `update`, `destroy`)
- Reusable Blade components (`record-card`, `record-table`) shared across the three record types
- Light/dark appearance setting

## Project structure

```
app/
  Actions/Fortify/     Fortify user creation and password logic
  Http/Controllers/    Location, Character and Artifact controllers
  Livewire/            Create* forms and the Search component
  Models/              Eloquent models
database/
  factories/ migrations/ seeders/
resources/views/
  livewire/            Volt auth and settings components, Livewire views
  components/          Shared Blade components
routes/web.php         Authenticated application routes
tests/                 Pest tests
```

## Getting started

Requirements: PHP 8.2+ (with `pdo_sqlite`), Composer, Node.js 20+ and npm.

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

Run the development servers:

```bash
composer run dev          # PHP server, queue worker and Vite together
# or separately:
php artisan serve
npm run dev
```

The app is then available at <http://localhost:8000>. To serve without Vite, run `npm run build` once and use only `php artisan serve`.

On Windows it also runs under [Laravel Herd](https://herd.laravel.com), which replaces `php artisan serve`.

### Demo accounts

The seeder creates several users (for example `jack@example.com`) with the password `jackpassword`. These are for local development only.

## Testing and code style

```bash
php artisan test      # or: composer test
./vendor/bin/pint     # format code
```

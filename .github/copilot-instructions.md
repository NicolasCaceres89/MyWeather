<!-- Copilot / AI agent instructions for the MyWeather repository -->
# MyWeather — Copilot Instructions

Purpose: give AI coding agents immediate, practical context to be productive in this Laravel + Inertia + React project.

- **Big picture**: This is a Laravel (PHP) backend serving an Inertia + React frontend. PHP handles routing, auth, and business logic (controllers, models, services). React lives in `resources/js` as Inertia "pages" and components. Vite builds the JS assets (`resources/js/app.jsx` is the entry). Data flows from controllers (server) to Inertia pages (client) via props.

- **Key files / locations**:
  - `routes/web.php` — primary web routes, uses `Inertia::render(...)` for pages.
  - `app/Http/Controllers/` — controllers return Inertia pages and handle server logic.
  - `app/Models/` — Eloquent models and model-specific logic (see `User.php`).
  - `app/Enums/` — typed enums used across the app (e.g. `UserTypes.php`, `TimeFormatType.php`). Prefer these enums for relevant fields.
  - `resources/js/app.jsx` — JS entry; `resources/js/Pages/` are Inertia pages, `resources/js/Components/` are shared UI.
  - `resources/js/bootstrap.js` — global axios setup (default X-Requested-With header).
  - `vite.config.js` — Vite + `laravel-vite-plugin` config; input is `resources/js/app.jsx`.
  - `app/Providers/WeatherServiceProvider.php` — extension point for weather-specific bindings/services (currently empty).

- **Build / dev / test workflows** (use these exact commands):
  - One-time setup: `composer run setup` (will install PHP deps, create `.env`, migrate, then run `npm install` and build assets).
  - Development (convenience script): `composer run dev` — runs `php artisan serve`, `php artisan queue:listen`, `php artisan pail` and `npm run dev` together via `concurrently`.
  - Frontend only: `npm run dev` (Vite dev server). Build assets: `npm run build`.
  - Tests: `composer run test` or `php artisan test` (Pest + PHPUnit). Tests use `phpunit.xml` which sets `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:` — no DB file required for tests.
  - Formatting / linting: project includes `laravel/pint` (run via `vendor/bin/pint` or add script if needed).

- **Dependencies & runtime**:
  - PHP 8.2+ and Laravel 12 are required (see `composer.json`).
  - Node (project lists Node 20 in `package.json`) and `vite` for building frontend.
  - Integrations: `inertiajs/inertia-laravel`, `laravel/sanctum`, `tightenco/ziggy` (JS route helpers), TailwindCSS.

- **Project-specific patterns and gotchas (be concrete)**:
  - Inertia-first: Controllers typically `return Inertia::render('PageName', $props)`. Examples: `routes/web.php` renders `Welcome`, `Index`, `Dashboard`.
  - JS structure: `resources/js/Pages/<Name>.jsx` corresponds to Inertia page names used in `Inertia::render`.
  - Global axios: `resources/js/bootstrap.js` sets `window.axios` and the `X-Requested-With` header — rely on that for AJAX calls.
  - Enums: Use `app/Enums/*` when reading or writing fields such as user type or time format.
  - Service provider hooks: `WeatherServiceProvider` exists as a registration/bootstrap location for weather-related bindings; prefer registering domain services there.
  - Tests use in-memory sqlite (see `phpunit.xml`): avoid test code that expects a persistent DB file unless explicitly created in the test.
  - Model casts: `app/Models/User.php` implements `protected function casts(): array` rather than the typical `$casts` property. Treat this as an authoritative pattern in this repo — verify behavior when changing model serialization/casting.

- **How to add a new page / change frontend behavior** (example):
  1. Add a controller method that `return Inertia::render('MyPage', ['data' => $value])`.
  2. Create `resources/js/Pages/MyPage.jsx` and import any `resources/js/Components/*` as needed.
  3. Run `npm run dev` (or `composer run dev`) and visit the route.

- **How to add a background job or queue listener**:
  - Dev script already runs `php artisan queue:listen --tries=1` and `php artisan pail` for logs. In production use a queue worker (supervisor/systemd) and forward logs accordingly.

- **Tests and CI hints**:
  - `phpunit.xml` ensures tests run with in-memory DB and common env settings. CI should run `composer install --prefer-dist --no-progress --no-suggest` then `composer run test`.

- **Where to look when things break**:
  - Backend errors: `storage/logs/laravel.log` and `php artisan pail` can tail logs.
  - Frontend HMR/build problems: check Vite output in terminal and `resources/js/app.jsx` for entry issues.

If anything here is unclear or you want more examples (e.g., a small end-to-end change showing controller → model → Inertia page), tell me which area to expand and I will iterate.

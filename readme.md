# wduyck.me

The personal website of William Duyck, served at [wduyck.me](https://wduyck.me/).

The site is a Laravel app that is exported to a static bundle via
[`spatie/laravel-export`](https://github.com/spatie/laravel-export) and deployed to GitHub Pages
on every push to `main`.

## Stack

- **Laravel 11** (PHP 8.2+) with [Filament](https://filamentphp.com/) for local content authoring
- **Blade** views, **Tailwind CSS**, **Alpine.js**, bundled with **Vite**
- **Sushi** for file-backed Eloquent models (skills, positions, etc.)
- **Spatie Laravel PDF** + Puppeteer for the printable CV view
- Static export deployed via GitHub Actions (`.github/workflows/deploy.yml`)

## Requirements

- PHP 8.2+ and Composer
- Node.js (see [`.nvmrc`](.nvmrc))
- A Chromium install for Puppeteer (only needed for PDF rendering)

## Local development

```sh
composer install
npm install
cp .env.example .env
php artisan key:generate

# run the app + asset pipeline
php artisan serve
npm run dev
```

The CV PDF route (`/cv.pdf`) is only registered when `APP_ENV=local`.

## Building the static site

```sh
npm run build
php artisan export
```

The exported site is written to `dist/`. Routes to crawl are listed in
[`config/export.php`](config/export.php).

## Routes

| Path | Description |
| --- | --- |
| `/` | Landing page |
| `/skills` | Skills index |
| `/positions/{position}` | Individual role / position page |
| `/cv` | HTML CV |
| `/cv.pdf` | PDF render of the CV (local only) |

## License

Code is released under the [MPL-2.0](https://www.mozilla.org/en-US/MPL/2.0/) license.
Content (copy, CV data, imagery) is © William Duyck.

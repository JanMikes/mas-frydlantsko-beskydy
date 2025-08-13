# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a website for MAS Frýdlantsko-Beskydy with a headless CMS architecture:
- **Strapi** (headless CMS) for content management
- **Symfony** frontend application consuming Strapi data
- **Docker Compose** setup for local development

## Development Setup

Start the entire development environment:
```bash
docker compose up
```

This provides:
- Frontend: http://localhost:8080
- Strapi admin: http://localhost:1337  
- Adminer (database UI): http://localhost:8000

## Essential Commands

### Symfony Frontend (in /frontend directory)

Run every command prepended with `docker compose exec frontend` - to run in the Symfony application container.

**Static Analysis & Quality:**
```bash
# PHPStan static analysis (MUST pass after any PHP changes)
composer phpstan

# Run tests
vendor/bin/phpunit
```

**IMPORTANT:** Always run `composer phpstan` after making any PHP code changes. PHPStan must pass without errors before considering the work complete.

**Asset Management:**
```bash
# Install importmap dependencies
php bin/console importmap:install

# Update assets
php bin/console asset-map:compile
```

### Strapi CMS (in /strapi directory)

Run every command prepended with `docker compose exec strapi` - to run in the Strapi container.

**Development:**
```bash
# Start development server
npm run develop

# Build for production
npm run build

# Start production server
npm run start
```

## Architecture

### Content Flow
1. Content is managed in Strapi CMS
2. Symfony frontend fetches data via `StrapiApiClient`
3. Data is transformed into typed Data Transfer Objects (DTOs)
4. Components render data using Twig templates

### Key Components

**Strapi Integration:**
- `StrapiApiClient` - HTTP client for Strapi API calls
- `StrapiContent` - Service for fetching specific content types
- Data classes in `src/Value/Content/Data/` - Strongly typed DTOs

**Frontend Structure:**
- Controllers handle routes and fetch data from Strapi
- Twig components in `templates/components/` render UI elements
- Live Components for interactive features (filtering, etc.)
- Uses Bootstrap 5 for styling
- Asset management via Symfony Asset Mapper (importmap) - no build step required

### Content Types
The project uses a component-based content system where pages are built from reusable components like:
- `Aktuality` (News/Articles)
- `UredniDeska` (Official Notice Board)
- Various UI components (forms, galleries, maps, etc.)

### Development Patterns

**Data Transformation:**
```php
// Example pattern for Strapi data consumption
$strapiData = $this->strapiClient->getApiResource('aktuality');
$aktualityData = AktualityData::createManyFromStrapiResponse($strapiData);
```

**Error Handling:**
Controllers gracefully handle Strapi API failures with try/catch blocks, showing fallback content when CMS is unavailable.

**Asset Management:**
The frontend uses Symfony Asset Mapper (importmap.php) for managing JavaScript and CSS dependencies without a build step. Assets are served directly and dependencies are managed via importmaps.

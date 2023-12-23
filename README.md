<h1 align="center">Menu</h1>

This package provides implementation of Menu in repository pattern for Lumen and Laravel besides REST API starterpack of admin management with no intervention to codebase and keep clean.

Getting Started
---

Installation :

```
composer require tripteki/laravelphp-menu
```

How to use it :

- Put `Tripteki\Menu\Providers\MenuServiceProvider` to service provider configuration list.

- Put `Tripteki\Menu\Providers\MenuServiceProvider::ignoreMigrations()` into `register` provider, then publish migrations file into your project's directory with running (optionally) :

```
php artisan vendor:publish --tag=tripteki-laravelphp-menu-migrations
```

- Migrate.

```
php artisan migrate
```

- Sample :

```php
use Tripteki\Menu\Contracts\Repository\Admin\IMenuAdminRepository;
use Tripteki\Menu\Contracts\Repository\IMenuRepository;

$menuAdminRepository = app(IMenuAdminRepository::class);

// $menuAdminRepository->create([ "platform" => "desktop", "route" => "ads", "nth" => 0, "title" => "ads_gallery", "metadata" => [ "icon" => "ic-gallery", "sound" => "tones/default.mp3", ], "description" => "Gallery", ]); //
// $menuAdminRepository->delete("identifier"); //
// $menuAdminRepository->update("identifier", [ "platform" => "desktop", "route" => "ads", "nth" => 1, "title" => "ads_gallery", "metadata" => [ "icon" => "ic-gallery", "sound" => "tones/default.mp3", ], "description" => "Gallery", ]); //
// $menuAdminRepository->activate("identifier"); //
// $menuAdminRepository->deactivate("identifier"); //
// $menuAdminRepository->get("identifier"); //
// $menuAdminRepository->all(); //

$repository = app(IMenuRepository::class);

// $repository->get("desktop", "ads", 5); //
// $repository->all("web", "ads"); //
// $repository->all("mobile", "ads"); //
// $repository->all("desktop", "ads"); //
```

- Generate swagger files into your project's directory with putting this into your annotation configuration (optionally) :

```
base_path("app/Http/Controllers/Menu")
```

```
base_path("app/Http/Controllers/Admin/Menu")
```

Usage
---

`php artisan adminer:install:menu`

Author
---

- Trip Teknologi ([@tripteki](https://linkedin.com/company/tripteki))
- Hasby Maulana ([@hsbmaulana](https://linkedin.com/in/hsbmaulana))

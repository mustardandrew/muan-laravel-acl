# ACL package for Laravel

[![Latest Version on Packagist][ico-version]](link-packagist)
[![Software License][ico-license]](LICENSE.md)
[![Quality Score][ico-code-quality]][link-code-quality]
[![Style CI](https://styleci.io/repos/58740020/shield)](https://styleci.io/repos/58740020)
[![Total Downloads][ico-downloads]][link-downloads]

Packages is not complated!..

## Install

1) Type next command in your terminal:

```bash
composer require muan/laravel-acl
```

2) Add the service provider to your config/app.php file in section providers:

```php
'providers' => [
    // ...
    Muan\Acl\AclServiceProvider::class,
    // ...
],
```

3) Run the migrations:

```bash
php artisan migration
```

4) Use the following traits on your User model:

```php
// ...

use Muan\Acl\Traits\{HasRolesTrait, HasPermissionsTrait};
 
class User extends Authenticatable
{
    use HasRolesTrait, HasPermissionsTrait;
    
    // ... Your User Model Code
}
```

## Usage

### Using in code

// TODO

### Commands for manipulation

// TODO

### Using blade directives

You also can use directives to verify the currently logged in user has any roles or permissions.

Check roles:

 ```blade
 @role('admin')
    <!-- User has role admin -->
 @elserole('writer')   
    <!-- User has role writer -->
    <!-- ... -->
 @else
    <!-- User with other roles -->
 @endrole
 ```

or check more roles in one directive:

```blade
 @role(['admin', 'writer'])
    <!-- User has next roles: admin, writer -->
 @endrole
```

Check permissions:

```blade
@can('create post')
    <!-- User can create post -->
@elsecan('edit post')
    <!-- User can edit post  -->
@endcan
```

### Using middlewares

// TODO
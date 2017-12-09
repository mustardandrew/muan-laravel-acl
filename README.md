# Muan Laravel Acl package (not completed)

[![Maintainability](https://api.codeclimate.com/v1/badges/aafb0da4bb6b457f635b/maintainability)](https://codeclimate.com/github/mustardandrew/muan-laravel-acl/maintainability)

Muan Acl is a PHP package for Laravel Framework, used for manipulation of access control list. Package is providing an easier way to control roles and permissions of users on your site.

## Requirements

- PHP >=7.0

## Install

1) Type next command in your terminal:

```bash
composer require muan/laravel-acl
```

2) Add the service provider to your config/app.php file in section providers:

> Laravel 5.5 uses Package Auto-Discovery, so does not require you to manually add the ServiceProvider.

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

## Usage

### Use the following traits on your User model:

```php
// ...

use Muan\Acl\Traits\{HasRolesTrait, HasPermissionsTrait};
 
class User extends Authenticatable
{
    use HasRolesTrait, HasPermissionsTrait;
    
    // ... Your User Model Code
}
```

### Using observer

To bind the base role to the user after registration, you can specify a public property $baseRole.

For example:

```php
class User extends Authenticatable
{
    // ...
    
    /**
     * Attach base role
     */
    public $baseRole = 'user';
    
    // ...
}
```

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

You can use role middleware for check access to some routes

```php
Route::middleware(['role:admin'])->group(function() {
    
    // Only for user with role admin
    Route::get('/admin', function() {
        // some code
    });

});
```

also you can use permission middleware

```php
Route::middleware(['permission:create post'])->group(function() {
    
    // Only for user with permission create post
    Route::get('/admin/post', function() {
        // some code
    });
    
});
```

or use role and permission middleware together

```php
Route::middleware(['role:moderator', 'permission:remove post'])->group(function() {
    
    // Only for user with role moderator and with permission create post
    Route::get('/admin/post/remove', function() {
        // some code
    });
    
});
```

## License

Muan Laravel Acl package is licensed under the [MIT License](http://opensource.org/licenses/MIT).

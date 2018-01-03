# Muan Laravel Acl package v1.1

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
php artisan migrate
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

Check role
```php
if ($user->hasRole('admin')) {
    // User is admin
}
// or
if ($user->hasRole('admin', 'writer')) {
    // User is admin or writer
}
```

Attach role 
```php
$user->attachRole(10, "moderator")
```

The same function, detach role 
```php
$user->detachRole('moder');
// ...
$user->detachRole('admin', '3', '2');
```

Clear all roles
```php
$user->clearRoles();
```

Check permission
```php
if ($user->hasPermission('create post')) {
    // User has permission "create post"
}
```

Attach permissions
```php
$user->attachPermission("update post");
```

Detach permissions
```php
$user->detachPermission("remove post");
```

Clear all permissions
```php
$user->clearPermissions();
```

See the code for more information... =)

### Commands for manipulation

#### Permissions

Create new permission
```bash
php artisan permission:add "create post"
```

Rename permission
```bash
php artisan permission:rename "create post" create.post
```

Remove permission
```bash
php artisan permission:remove "create post"
```

Show all permissions
```bash
php artisan permission:list
```

#### Roles

Create new role
```bash
php artisan role:add admin
```

Rename role
```bash
php artisan role:rename admin superuser
```

Remove role
```bash
php artisan role:remove admin
```

View all roles
```bash
php artisan role:list
```

Attach permissions to role
```bash
php artisan role:attach admin --id=2 --id=3 --name="create post"
```

Detach permissions from role
```bash
php artisan role:detach admin --id=3 --name="destroy user"
```

Clear all attached permissions
```bash
php artisan role:clear
```

View information about role and show all attached permissions
```bash
php artisan role:view admin
```

#### Users

Attach roles
```bash
php artisan user:role-attach 5 --id=2 --name=moderator
```

Detach roles
```bash
php artisan user:role-detach 5 --id=2 --name=admin
```

Detached all roles from user
```bash
php artisan user:role-clear
```

Attach permissions
```bash
php artisan user:permission-attach 5 --id=7 --name="remove comment"
```

Detach permissions
```bash
php artisan user:permission-detach 5 --id=2 --name="read secret post"
```

Detached all permission from user
```bash
php artisan user:permission-clear
```

View information about user, all attached roles and permissions
```bash
php artisan user:view 5
```
where 5 is ID of user.

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

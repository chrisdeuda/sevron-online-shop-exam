## Your Role
You're an expert developer tasked with cleaning up and optimizing the existing Laravel PHP codebase.

# Functions
While PHP doesn't support arrow functions in the same way some other languages do, you should aim for consistent function declarations.

#In Laravel, consider using higher-order messages or Eloquent when dealing with collections instead of traditional loops.

## Types
PHP 7.4+ supports type declarations for function parameters and return types. Make sure to add these where applicable.

You can also use DocBlocks to specify types and expectations for your methods and properties.
Example:

```
/**
 * @param int $id
 * @return User|null
 */
public function getUserById(int $id): ?User {
    // ...
}

```


## DRY Code
Keep your code DRY (Don't Repeat Yourself).
Identify any repetitive query scopes in Eloquent Models and abstract them.
Use Laravel's Service Providers, Repositories, or Services to abstract logic from controllers.
Consider using traits for methods that are used in multiple classes.

Example:

```php
// Instead of using this line everywhere you need it
$query->where('active', 1)->where('banned', 0);

// Add a scope to your Eloquent Model
public function scopeActive($query) {
    return $query->where('active', 1)->where('banned', 0);
}

// Then use the scope in your code
$query->active();

```


## Bugs:


Examine the code for any bugs.
Leverage Laravel's extensive logging features to pinpoint errors.
Use PHPUnit for unit testing and Dusk for browser testing to ensure the codebase is robust.
Investigate and fix any "N+1 query" problems using Laravel Debugbar or Telescope.
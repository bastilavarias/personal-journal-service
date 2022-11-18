# Changes

## Stubs
`php artisan stub:publish` was pre-executed to uniformly extend the widely-used generators for laravel's artisan.

## Controller Namespace
This boilerplate activates by default the old *App\Http\Controllers* namespace from older Laravel version.
Changes found on `App\Providers\RouteServiceProviders` on `protected $namespace`

## Throttle / Rate-limiting
`$this->configureRateLimiting()` on `App\Providers\RouteServiceProviders` is commented-out by default. The typical use-case for our apps requires users to send dozens of requests during production. The `throttle` middleware is also commented-out on `App\Http\Kernel.php`.


## Default Packages

### laravel/passport
By default, this boilerplate includes `laravel/passport` package and set the `auth` config to use passport as default API driver. The `User` model also includes `HasApiTokens` trait by default.

### doctrine/dbal
By default, `doctrine/dbal` package has been added on this boilerplate

### league/flysystem-aws-s3-v3
By default, `league/flysystem-aws-s3-v3` has been added on this boilerplate

## customResponse Helper
You can find on `App\Helpers\CustomHelpers.php` that an `customResponse()` function was added. This can be used to create a uniform format for all future laravel projects.

## S3 Visibility
By default, the `visibility` is set to `public` in `filesystems.php` s3 disk.

## Abstract Model
An abstract model was added that all new models will automatically extend.

## Abstract Form Request
An abstract form request was added that all new requests will automatically extend. It also has default condition for checking authenticated, unauthenticated and superadmin users

## Request Stub
The request stub at `/stubs/request.stub` has been set to TRUE on authorize function by default

## Uploadable Cast
The `Uploadable` Cast was added to help with uploading file.
Read more about the Cast on `App\Casts\Uploadable`
This has been tested on public, local and s3 filesystems as well as passing a valid URL for the file

## JSONable Cast
The `JSONable` Cast was added to help with casting JSONs automatically
Read more about the Cast on `App\Casts\JSONable`

## php artisan magic:controller
The magic command `php artisan magic:controller` has been added.
This command will generate a very useful API Controller that allows you to speed up development.
The generated controller contains the basic functionality of the APIs, custom request files for each methods as well as invididual events on each methods.
Find out more at `App\Console\Commands\ExtendedMakeController`

---

# Todo
- Create a logger that saves to S3 and add it as default logger

# Photon
 
An Extension to Laravel with SRP Design Pattern.

### How to use

install the package using the following command

```bash
composer require moeen-basra/photon
```

Open the file `public/index.php`

Replace the following code

```
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
```
with

```
$app->alias('request', \Photon\Foundation\Http\Request::class);

$response = $kernel->handle(
    $request = \Photon\Foundation\Http\Request::capture()
);
```

Open the class `App\Http\Controllers\Controller` and replace the following code

`use Illuminate\Routing\Controller as BaseController;`

with

`use Photon\Foundation\Controller as BaseController;`

Finally you can extends the `app\Exceptions\Handler` with the following class

```\Photon\Foundation\Exceptions\Handler\Handler```

or use the following traits in your existing exception handler

```
use Photon\Foundation\Traits\MarshalTrait;
use Photon\Foundation\Traits\JobDispatcherTrait;
```

and in the render method run the following job if request accepts `application\json`

```
$message = $exception->getMessage();
$class = get_class($exception);
$code = $exception->getCode();

if ($request->expectsJson()) {
    return $this->run(JsonErrorResponseJob::class, [
        'message' => $message,
        'code' => $class,
        'status' => ($code < 100 || $code >= 600) ? 400 : $code,
    ]);
}
```

Now you can create the following directories in the `app` folder.

```
|-- app
|  |-- Domains
|  |-- Features
|  |-- Operations
```

Here is a sample code for a controller serving the feature.

```php
namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\JsonResponse;
use Photon\Foundation\Controller;
use App\Features\Api\Auth\RegisterFeature;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['only' => 'me', 'logout', 'refresh']);
    }

    /**
     * Register user
     *
     * @return JsonResponse
     */
    public function register(): JsonResponse
    {
        return $this->serve(RegisterFeature::class);
    }
}

```

Here is sample code for Feature running the job

```php
namespace App\Features\Api\Auth;

use Photon\Foundation\Feature;
use App\Operations\Auth\RegisterOperation;
use Photon\Domains\Http\Jobs\JsonResponseJob;
use App\Domains\Auth\Jobs\Register\ValidateRegisterRequestJob;

class RegisterFeature extends Feature
{
    public function handle()
    {
        $input = $this->run(ValidateRegisterRequestJob::class);

        $data = $this->run(RegisterOperation::class, compact('input'));

        return $this->run(new JsonResponseJob($data));
    }
}

```

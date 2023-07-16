# Photon
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

Photon is a lightweight extension framework for Laravel that implements the Single Responsibility Principle (SRP) design pattern. It draws inspiration from the [Lucid Framework](https://docs.lucidarch.dev/installation).

## How to Use

To use Photon in your Laravel project, follow these steps:

1. Open your terminal and execute the following command:

```shell
composer require moeen-basra/photon
```

2. Open the `App\Http\Controllers\Controller` class and replace the following code:

```php
use Illuminate\Routing\Controller as BaseController;
```

with:

```php
use MoeenBasra\Photon\Http\Controller as BaseController;
```

3. Extend the `app\Exceptions\Handler` class with the following class:

```php
MoeenBasra\Photon\Foundation\Exceptions\Handler\Handler
```

Alternatively, you can use the following traits in your existing exception handler:

```php
use MoeenBasra\Photon\Concerns\Marshal;
use MoeenBasra\Photon\Concerns\ActionRunner;
```

In the `render` method, execute the following job if the request accepts `application\json`:

```php
$message = $exception->getMessage();
$code = $exception->getCode();
$errors = ($exception instanceof \Illuminate\Validation\ValidationException) ? $exception->errors() : [];

if ($request->expectsJson()) {
    return $this->run(JsonErrorResponseJob::class, [
        'message' => $message,
        'errors' => $errors,
        'status' => ($code < 100 || $code >= 600) ? 400 : $code,
    ]);
}
```

4. Create the following directories inside the `app` folder:

```
|-- app
|  |-- Actions
|  |-- Features
|  |-- Operations
```

5. Here's an example code for a controller that serves the feature:

```php
namespace App\Http\Controllers\Api\Auth;

use App\Features\Api\Auth\RegisterFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MoeenBasra\Photon\Http\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['me', 'logout']]);
    }

    public function register(Request $request): JsonResponse
    {
        return $this->serve(RegisterFeature::class, [
            'data' => $request->validated(),
        ]);
    }
}
```

6. Lastly, here's an example code for a feature that runs the job:

```php
namespace App\Features\Api\Auth;

use App\Operations\Auth\RegisterOperation;
use Illuminate\Http\JsonResponse;
use Photon\Actions\JsonResponseAction;
use MoeenBasra\Photon\Features\Feature;

final class RegisterFeature extends Feature
{
    public function __construct(
        readonly private array $input
    ){}
    
    public function handle(): JsonResponse
    {
        $data = $this->run(RegisterOperation::class, [
            'input' => $this->input
        ]);

        return $this->run(new JsonResponseAction($data));
    }
}
```

## License

Photon is released under the [MIT License](https://opensource.org/licenses/MIT). See the [LICENSE](LICENSE) file for details.

## Contact
You can reach me here [moeen.basra@gamil.com](mailto:moeen.basra@gamil.com)
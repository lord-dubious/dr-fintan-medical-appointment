# TEST.md

## Testing Strategy

### Test Pyramid
```
          /\
         /  \  E2E Tests (10%) - Cypress/Playwright (Frontend)
        /----\
       /      \  Feature/Integration Tests (30%) - PHPUnit (Backend)
      /--------\
     /          \  Unit Tests (60%) - PHPUnit (Backend)
    /____________\
```

## Test Stack

### Testing Frameworks
- **Backend Unit/Feature Tests**: PHPUnit
- **Frontend E2E Tests**: Cypress or Playwright (if implemented)

## Running Tests

### Commands
```bash
# Run all PHPUnit tests
php artisan test

# Run a specific test class
php artisan test --filter UserTest

# Run tests and generate coverage report (requires Xdebug or PCOV)
php artisan test --coverage

# Run tests in a specific directory
php artisan test tests/Unit
php artisan test tests/Feature
```

## Test Structure

### Unit Test Example (PHPUnit)
```php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * Test if a user can be created.
     */
    public function test_user_can_be_created(): void
    {
        $user = new User();
        $user->name = 'Test User';
        $user->email = 'test@example.com';
        $user->password = bcrypt('password');

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
    }

    /**
     * Test password hashing.
     */
    public function test_password_is_hashed(): void
    {
        $user = new User();
        $user->password = 'password123';

        $this->assertTrue(password_verify('password123', $user->password));
    }
}
```

### Feature Test Example (PHPUnit with Laravel)
```php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test user registration.
     */
    public function test_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(302); // Redirects after successful registration
        $this->assertCount(1, User::all());
    }

    /**
     * Test user login.
     */
    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }
}
```

### E2E Test Example (Conceptual, if Cypress/Playwright were set up)
```javascript
// cypress/integration/login.spec.js
describe('User Login Flow', () => {
  it('should allow user to login', () => {
    cy.visit('/login');
    
    cy.get('input[name="email"]').type('user@example.com');
    cy.get('input[name="password"]').type('password123');
    cy.get('button[type="submit"]').click();
    
    cy.url().should('include', '/dashboard');
    cy.contains('Welcome back!').should('be.visible');
  });
});
```

## Test Patterns

### Setup and Teardown
Laravel's `TestCase` provides `RefreshDatabase` trait to reset the database for each test.
```php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Additional setup for each test
    }

    protected function tearDown(): void
    {
        // Additional teardown for each test
        parent::tearDown();
    }
}
```

### Test Data Factories
Laravel factories (`database/factories/` and `php artisan make:factory`)
```php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
}

// Usage in tests
$user = User::factory()->create();
$users = User::factory()->count(5)->create();
```

### Mocking
Laravel provides helper functions for mocking facades, classes, and HTTP requests.
```php
// Mocking a Facade
use Illuminate\Support\Facades\Mail;

Mail::fake();

// ... call code that sends mail ...

Mail::assertSent(NewUserWelcomeMail::class);

// Mocking a class (using Laravel's container binding)
$this->mock(PaymentGateway::class, function (MockInterface $mock) {
    $mock->shouldReceive('processPayment')->once()->andReturn(true);
});

// Mocking HTTP requests
use Illuminate\Support\Facades\Http;

Http::fake([
    'daily.co/*' => Http::response(['room_url' => 'test_url'], 200),
]);
```

## Coverage Goals

Laravel's PHPUnit integration can generate detailed coverage reports.

### Minimum Coverage Targets
(These are example targets, adjust as needed for project requirements)
```
Statements: 80%
Branches: 75%
Functions: 80%
Lines: 80%
```

### Generating Coverage Report
```bash
php artisan test --coverage
# The report will be generated in storage/logs/coverage (or similar, depending on config)
```

## Common Test Scenarios

### Authentication Tests
- User registration and login.
- Password reset.
- Role-based access control (Admin, Doctor, Patient).

### API Tests
- Video consultation room creation and joining.
- Payment processing (mocked).
- CRUD operations for resources (Appointments, Doctors, Patients).

### UI Tests (Frontend)
- Form submission and validation feedback.
- Navigation flows.
- Responsive behavior across devices.

## Debugging Tests

### Debugging PHPUnit Tests
- Use `dd()` or `dump()` helper functions for quick inspection.
- Utilize Xdebug with your IDE for step-through debugging.
- Run tests with `--debug` flag for more verbose output.

## Performance Testing

(For Laravel applications, performance testing can involve tools like Laravel Telescope for local debugging, or external tools like JMeter/k6 for load testing.)

## Keywords <!-- #keywords -->
- testing
- phpunit
- laravel
- unit tests
- feature tests
- mocking
- coverage
- e2e tests
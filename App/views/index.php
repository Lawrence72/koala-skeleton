<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koala Framework Documentation</title>
    <style>
        body {
            font-family: system-ui, -apple-system, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        pre {
            background-color: #f6f8fa;
            padding: 16px;
            border-radius: 6px;
            overflow-x: auto;
        }

        code {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, Courier, monospace;
            font-size: 14px;
        }

        h1,
        h2,
        h3 {
            color: #24292e;
        }

        h1 {
            border-bottom: 1px solid #eaecef;
            padding-bottom: 0.3em;
        }

        h2 {
            margin-top: 24px;
            margin-bottom: 16px;
            font-size: 1.5em;
            border-bottom: 1px solid #eaecef;
            padding-bottom: 0.3em;
        }

        .nav {
            background-color: #f6f8fa;
            padding: 16px;
            border-radius: 6px;
            margin-bottom: 24px;
        }

        .nav ul {
            list-style: none;
            padding-left: 0;
        }

        .nav li {
            margin-bottom: 8px;
        }

        .nav a {
            color: #0366d6;
            text-decoration: none;
        }

        .nav a:hover {
            text-decoration: underline;
        }

        .code-block {
            background-color: #f6f8fa;
            padding: 16px;
            border-radius: 6px;
            margin: 16px 0;
        }
    </style>
</head>

<body>
    <h1>Koala Framework Documentation</h1>

    <nav class="nav">
        <h2>Table of Contents</h2>
        <ul>
            <li><a href="#introduction">Introduction</a></li>
            <li><a href="#getting-started">Getting Started</a></li>
            <li><a href="#core-concepts">Core Concepts</a></li>
            <li><a href="#components">Components</a></li>
            <li><a href="#usage-guide">Usage Guide</a></li>
        </ul>
    </nav>

    <section id="introduction">
        <h2>Introduction</h2>
        <p>Koala is a lightweight PHP framework focusing on simplicity and flexibility. It provides a robust foundation for building web applications with features like dependency injection, routing, database abstraction, and middleware support.</p>
    </section>

    <section id="getting-started">
        <h2>Getting Started</h2>

        <h3>Installation</h3>
        <div class="code-block">
            <code>composer require lawrence72/koala</code>
        </div>

        <h3>Basic Setup</h3>
        <p>1. Create an entry point (public/index.php):</p>
        <pre><code>&lt;?php
require_once __DIR__ . '/../vendor/autoload.php';

use Koala\Application;
use App\Config\Routes;

$app = new Application();
Routes::register($app->getRouter());
$app->start(__DIR__ . '/../config.php');</code></pre>

        <p>2. Create a configuration file (config.php):</p>
        <pre><code>&lt;?php
return [
    'paths' => [
        'base_directory' => __DIR__,
        'app_directory' => __DIR__ . '/app'
    ],
    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => 'your_database',
        'username' => 'your_username',
        'password' => 'your_password',
        'charset' => 'utf8mb4'
    ],
    'autoload' => [
        'paths' => [
            'Controllers',
            'Logic',
            'Middleware'
        ]
    ]
];</code></pre>
    </section>

    <section id="core-concepts">
        <h2>Core Concepts</h2>

        <h3>Application Structure</h3>
        <p>The framework follows a modular structure with clear separation of concerns:</p>
        <ul>
            <li>Controllers: Handle HTTP requests</li>
            <li>Logic: Business logic layer</li>
            <li>Middleware: Request/Response filters</li>
            <li>Config: Application configuration</li>
            <li>Database: Data access layer</li>
            <li>Router: URL routing</li>
            <li>Container: Dependency injection</li>
        </ul>

        <h3>Dependency Injection</h3>
        <p>The framework uses a service container for dependency management:</p>
        <pre><code>class YourController {
    public function __construct(
        protected Application $app,
        protected YourLogic $logic
    ) {}
}</code></pre>

        <h3>Routing</h3>
        <p>Routes can be defined with groups and middleware:</p>
        <pre><code>public static function register(Router $router): void
{
    $router->group('/users', function ($router) {
        $router->addRoute('GET', '', UserController::class, 'index');
        $router->addRoute('GET', '/@id[0-9]', UserController::class, 'show');
    }, ['middleware' => [[AuthMiddleware::class, 'handle']]]);
}</code></pre>
    </section>

    <section id="components">
        <h2>Components</h2>

        <h3>Application Class</h3>
        <p>The Application class serves as the framework's core, initializing and managing all components:</p>
        <ul>
            <li>Router management</li>
            <li>Database connections</li>
            <li>Request/Response handling</li>
            <li>Error handling</li>
            <li>Configuration management</li>
        </ul>

        <h3>Database</h3>
        <p>Supports multiple database drivers:</p>
        <ul>
            <li>MySQL</li>
            <li>PostgreSQL</li>
            <li>SQLite</li>
            <li>SQL Server</li>
        </ul>

        <p>Database Methods:</p>

        <h4>Data Retrieval</h4>
        <ul>
            <li><code>fetchAll(string $sql, array $params = [])</code>: Fetch multiple rows</li>
            <li><code>fetchRow(string $sql, array $params = [])</code>: Fetch a single row</li>
            <li><code>fetchField(string $sql, array $params = [])</code>: Fetch single field from first row</li>
        </ul>

        <h4>Data Modification</h4>
        <ul>
            <li><code>runQuery(string $sql, array $params = [])</code>: Execute any query (INSERT, UPDATE, DELETE, etc.)</li>
        </ul>

        <h4>Examples:</h4>
        <pre><code>// Fetch all users
$users = $this->database->fetchAll("SELECT * FROM users");

// Fetch single user
$user = $this->database->fetchRow("SELECT * FROM users WHERE id = ?", [$id]);

// Fetch just the email field
$email = $this->database->fetchField("SELECT email FROM users WHERE id = ?", [$id]);

// Insert new user
$this->database->runQuery(
    "INSERT INTO users (name, email) VALUES (?, ?)",
    ['John Doe', 'john@example.com']
);

// Update user
$this->database->runQuery(
    "UPDATE users SET status = ? WHERE id = ?",
    ['active', $id]
);

// Delete user
$this->database->runQuery(
    "DELETE FROM users WHERE id = ?",
    [$id]
);</code></pre>

        <h3>Request Handling</h3>
        <p>The Request class provides comprehensive methods to access request data:</p>

        <h4>GET Parameters</h4>
        <ul>
            <li><code>getQueryParams()</code>: Get all GET parameters as array</li>
            <li><code>getQueryParam($key, $default = null)</code>: Get specific GET parameter by key</li>
        </ul>

        <h4>POST Data</h4>
        <ul>
            <li><code>getPostParams()</code>: Get all POST data as array</li>
            <li><code>getPostParam($key, $default = null)</code>: Get specific POST parameter by key</li>
        </ul>

        <h4>JSON Data</h4>
        <ul>
            <li><code>getJsonParams()</code>: Get all JSON data as array</li>
            <li><code>getJsonParam($key, $default = null)</code>: Get specific JSON parameter by key</li>
        </ul>

        <h4>Request Information</h4>
        <ul>
            <li><code>getMethod()</code>: Get HTTP method (GET, POST, etc.)</li>
            <li><code>getRoute()</code>: Get current route path</li>
            <li><code>isJson()</code>: Check if request is JSON</li>
            <li><code>has($key)</code>: Check if parameter exists in current request type</li>
            <li><code>getAll()</code>: Get all parameters based on request type</li>
        </ul>

        <h4>Example Usage</h4>
        <pre><code>// Get specific parameters
$userId = $request->getQueryParam('user_id', 0);  // with default value
$name = $request->getPostParam('name');
$email = $request->getJsonParam('email');

// Get all parameters
$allQueryParams = $request->getQueryParams();
$allPostData = $request->getPostParams();
$allJsonData = $request->getJsonParams();

// Check parameter existence
if ($request->has('email')) {
    // Process email
}

// Get all data based on request type
$allRequestData = $request->getAll();  // Returns GET, POST, or JSON data based on request type</code></pre>

        <h3>Response Handling</h3>
        <p>Multiple response types supported:</p>
        <pre><code>// View response
return $response->view('template', ['data' => $value]);

// JSON response
return $response->json(['status' => 'success']);</code></pre>

        <h3>Middleware</h3>
        <p>Middleware can be used to filter requests:</p>
        <pre><code>class AuthMiddleware {
    public function handle(Request $request, callable $next) {
        // Validation logic
        return $next();
    }
}</code></pre>
    </section>

    <section id="usage-guide">
        <h2>Usage Guide</h2>

        <h3>Creating a Controller</h3>
        <pre><code>namespace App\Controllers;

use Koala\Request\Request;
use Koala\Response\Response;
use Koala\Response\ResponseInterface;

class UserController {
    public function index(Request $request, Response $response, $args): ResponseInterface
    {
        return $response->view('users/index', [
            'users' => $this->logic->getAllUsers()
        ]);
    }
}</code></pre>

        <h3>Creating Business Logic</h3>
        <pre><code>namespace App\Logic;

use Koala\Logic\BaseLogic;

class UserLogic extends BaseLogic {
    public function getAllUsers(): array {
        return $this->database->fetchAll("SELECT * FROM users");
    }
}</code></pre>

        <h3>Implementing Middleware</h3>
        <pre><code>namespace App\Middleware;

use Koala\Request\Request;

class AuthMiddleware {
    public function handle(Request $request, callable $next) {
        // Authentication logic
        return $next();
    }
}</code></pre>

        <h3>Custom View Engines</h3>
        <p>The framework supports custom view engines through the ResponseInterface:</p>
        <pre><code>Response::setviewEngine(YourCustomResponse::class);</code></pre>

        <h3>Utility Classes</h3>

        <h4>Session Management</h4>
        <p>The Session utility provides secure session handling with optional encryption:</p>
        <pre><code>use Koala\Utils\Session;

// In your controller constructor
protected Session $session;

// Basic usage
$this->session->set('user_id', 123);
$userId = $this->session->get('user_id');
$this->session->remove('user_id');

// Flash messages
$this->session->setFlash('Profile updated successfully!', 'success');
$messages = $this->session->getFlash();  // Returns and clears flash messages

// Checking existence
if ($this->session->has('user_id')) {
    // Process
}

// Session destruction
$this->session->destroy();</code></pre>

        <h4>Cookie Management</h4>
        <p>The Cookie utility simplifies cookie operations:</p>
        <pre><code>use Koala\Utils\Cookie;

// Basic usage
$cookie->set('user_pref', 'dark_mode', 3600);  // Set cookie with 1 hour expiry
$preference = $cookie->get('user_pref');

// Advanced options
$cookie->set(
    'user_token',
    'abc123',
    3600,           // Time in seconds
    '/',           // Path
    'domain.com',  // Domain
    true,         // Secure
    true          // HTTP Only
);

// Check existence
if ($cookie->has('user_pref')) {
    // Process
}

// Remove cookie
$cookie->remove('user_pref');</code></pre>

        <h4>Data Sanitization</h4>
        <p>The Sanitize utility provides comprehensive data cleaning functionality:</p>
        <pre><code>use Koala\Utils\Sanitize;

$sanitizer = new Sanitize();

// Basic string cleaning
$clean = $sanitizer->clean($userInput);

// Allow specific HTML tags
$allowedTags = ['b', 'i', 'a'];
$cleanHtml = $sanitizer->clean($userInput, $allowedTags);

// Clean arrays
$cleanData = $sanitizer->clean([
    'name' => ' John Doe ',
    'bio' => '<p>My &lt;b&gt;bio&lt;/b&gt;</p>'
]);

// Clean with custom encoding
$cleanText = $sanitizer->clean($input, [], 'UTF-8');</code></pre>

        <p>The sanitizer handles:</p>
        <ul>
            <li>String trimming</li>
            <li>HTML special characters</li>
            <li>Allowed HTML tags</li>
            <li>Non-printable characters removal</li>
            <li>Nested arrays and objects</li>
            <li>Custom character encoding</li>
        </ul>

    </section>
</body>

</html>
<?php
declare(strict_types = 1);

define('BASE_PATH', dirname(path: __DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

use Framework\Http\{Request, Kernel};

$container = require_once(BASE_PATH . '/config/services.php');

$request = Request::createFromGlobals();

$kernel = $container->get(Kernel::class);

$response = $kernel->handle($request);
$response->send();

//var_dump($request);

print(phpinfo());

// $host = "postgres"; 
// $port = 5432;
// $dbName = "sample_db";
// $username = "admin";
// $password = "password";

// $dsn = "pgsql:host={$host};port={$port};dbname={$dbName};user={$username};password={$password}";

/*try {
    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to the DataBase successfully!<br>";

    //$query = $pdo->prepare("INSERT INTO test (name) VALUES('Mike');");

    $query = "SELECT * FROM test WHERE name=:name ORDER BY name;" ;
    
    $query_prepared = $pdo->prepare($query);

    $query_prepared->execute(['name' => 'Alice']);

    //$results = $query_prepared->fetchAll();
    $results = $query_prepared->fetch();

    var_dump($results);

    

} catch(PDOException $err) {
    echo "Connection failed!<br>";
    print($err);
}*/

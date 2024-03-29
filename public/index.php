<?php
declare(strict_types = 1);

require_once dirname(path: __DIR__) . '/vendor/autoload.php';

use App\{TestClass/*, AnotherClass, */};

(new TestClass())->printHello();

//print(phpinfo());

$host = "postgres";
$port = 5432;
$dbName = "sample_db";
$username = "admin";
$password = "password";

$dsn = "pgsql:host={$host};port={$port};dbname={$dbName};user={$username};password={$password}";

//Error Control Operator @ -> error_get_last() contains error message
@var_dump($a);
print(error_get_last()['message'] . "<br>");

//match operator resolves into an expression 
$status_code = 200;
$result = match($status_code) {
    200 => "OK",
    301 => "Redirected",
    404 => "Not found",
    500 => "Server error"
};
echo "Match result is {$result}<br>";

//array_values() reindexes an array 
$names = [0 => "Alice", 2 => "Bob"];
$new_names = array_values($names);
var_dump($new_names);

//static variables keeps their values even after function execution
function foo() {
    static $i = 1;

    return $i++;
}

echo foo() . "<br>"; // 1
echo foo() . "<br>"; // 2
echo foo() . "<br>"; // 3

//callable type
function sum(int $a, int $b, callable $callback) {
    return $callback($a + $b);
}

//destructuring an array
$numbers = [1, 3, 6, 12, 8];
list($a, $b) = $numbers;
echo "a: $a<br>"; // 1
echo "b: $b<br>"; // 3

//destructuring an associative array
$numbers = ["key1" => 5, 2, 7, 3, 12];
["key1" => $a, 0 => $b] = $numbers;
echo "a: $a<br>"; // 5
echo "b: $b<br>"; // 2

//nullsafe operator, prevents errors on calling methods of null objects
$object?->method();

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




dd("dd working great!");
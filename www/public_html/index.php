<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>docker-lamp</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container my-5">
    <h1>Hura, działa ;)</h1>
    <a href="http://127.0.0.1:1<?= $_SERVER['SERVER_PORT'] ?>">phpMyAdmin</a> |
    <a href="/?info=1">phpinfo()</a>
    <hr>
    <?php


    putenv('MSSQL_HOST=app-mssql');
    putenv('MSSQL_PORT=1433');
    putenv('MSSQL_DATABASE=master');
    putenv('MSSQL_USERNAME=sa');
    putenv('MSSQL_PASSWORD=superSecr3t');


    function test_sqlsrv_connection(&$errors)
    {
      $host = getenv('MSSQL_HOST');
      $port = getenv('MSSQL_PORT');

      $connection = sqlsrv_connect("${host},${port}", [
        'UID' => getenv('MSSQL_USERNAME'),
        'PWD' => getenv('MSSQL_PASSWORD'),
        'Database' => getenv('MSSQL_DATABASE'),
      ]);

      if ($connection === false) {
        $errors[] = json_encode(sqlsrv_errors());

        return false;
      }

      $success = sqlsrv_query($connection, 'SELECT 1');

      if ($success === false) {
        $errors[] = json_encode(sqlsrv_errors());

        return false;
      }

      return true;
    }

    function test_pdo_sqlsrv_connection(&$errors)
    {
      $host = getenv('MSSQL_HOST');
      $port = getenv('MSSQL_PORT');
      $database = getenv('MSSQL_DATABASE');
      $username = getenv('MSSQL_USERNAME');
      $password = getenv('MSSQL_PASSWORD');

      try {
        $connection = new PDO("sqlsrv:server=${host},${port};Database=${database};ConnectionPooling=0", $username, $password, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $success = $connection->query('SELECT 1');

        if ($success === false) {
          return false;
        }
      } catch (PDOException $e) {
        $errors[] = json_encode($e->getMessage());

        return false;
      }

      return true;
    }

    echo '<pre>== PHP extensions ==' . PHP_EOL;
    echo 'sqlsrv version: ' . phpversion('sqlsrv') . PHP_EOL;
    echo 'pdo_sqlsrv version: ' . phpversion('pdo_sqlsrv') . PHP_EOL;
    echo PHP_EOL;

    echo '== Environment variables ==' . PHP_EOL;
    echo 'MSSQL_HOST: ' . getenv('MSSQL_HOST') . PHP_EOL;
    echo 'MSSQL_PORT:' . getenv('MSSQL_PORT') . PHP_EOL;
    echo 'MSSQL_USERNAME:' . getenv('MSSQL_USERNAME') . PHP_EOL;
    echo 'MSSQL_PASSWORD:' . getenv('MSSQL_PASSWORD') . PHP_EOL;
    echo 'MSSQL_DATABASE:' . getenv('MSSQL_DATABASE') . PHP_EOL;
    echo PHP_EOL;

    $errors = [];

    echo '== Testing `sqlsrv` extension ==' . PHP_EOL;
    $sqlsrvSuccess = test_sqlsrv_connection($errors);
    echo 'Establishing connection ' . ($sqlsrvSuccess ? 'successful!' : 'failed.') . PHP_EOL;

    echo '== Testing `pdo_sqlsrv` extension ==' . PHP_EOL;
    $pdoSqlsrvSuccess = test_pdo_sqlsrv_connection($errors);
    echo 'Establishing connection ' . ($pdoSqlsrvSuccess ? 'successful!' : 'failed.') . PHP_EOL;

    var_dump($errors);





    echo ("</pre><hr>");

    print_r("<h2>PHP " . phpversion() . "</h2><code>");

    echo (print_r(get_loaded_extensions(), true));

    echo ("</code><hr>");







    if (isset($_GET['info'])) {
      phpinfo();
    }

    ?>
  </div>
</body>

</html>
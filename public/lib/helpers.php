<?php

if (!defined('APP_ROOT')) {
    define('APP_ROOT', str_replace('/lib', '', __DIR__));
    DB::build();
}

function relative_path($path) {
    return str_replace(APP_ROOT, '', $path);
}

function dd($object) {
    print_r($object);
}

class DB {
    private static $instance;
    private static $root_pdo;
    private static $table_pdo;
    
    private $db = 'erp';
    private $dsn = 'mysql:host=127.0.0.1';
    private $user = 'root';
    private $pass = '';
    
    public function __construct()
    {
        try {
            self::$root_pdo = new PDO("$this->dsn", $this->user, $this->pass);
            self::$root_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            self::$root_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->createDatabaseSchema();
            
            self::$table_pdo = new PDO("{$this->dsn};dbname={$this->db}", $this->user, $this->pass);
            self::$table_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            self::$table_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {}
    }

    public static function build()
    {
        if (!self::$instance) {
            self::$instance = new static;
        }
    }
    
    public static function pdo()
    {
        return self::$table_pdo;
    }
    
    private function createDatabaseSchema()
    {
        try {
            self::$root_pdo->exec($sql = /** @lang MySQL */ "
                CREATE DATABASE `{$this->db}`;
                CREATE USER '{$this->user}'@'localhost' IDENTIFIED BY '{$this->pass}';
                GRANT ALL ON `{$this->db}`.* TO '{$this->user}'@'localhost';
                FLUSH PRIVILEGES;
            ");

            self::$root_pdo->exec($sql = /** @lang MySQL */ "
                CREATE TABLE `{$this->db}`.`users` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `first_name` varchar(255) NOT NULL,
                    `last_name` varchar(255) NOT NULL,
                    `active` tinyint(1) NOT NULL DEFAULT '1',
                    `created_at` timestamp NULL DEFAULT NULL,
                    `updated_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`id`)
                );
                INSERT INTO `{$this->db}`.`users` 
                    (first_name, last_name, active, created_at, updated_at) VALUES 
                    ('Daniel', 'Alamo', true, now(), now())
                    ,('Steven', 'Parson', true, now(), now())
                    ,('Alix', 'Segura', true, now(), now())
                ;
                
                CREATE TABLE `{$this->db}`.`users` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `first_name` varchar(255) NOT NULL,
                    `last_name` varchar(255) NOT NULL,
                    `active` tinyint(1) NOT NULL DEFAULT '1',
                    `created_at` timestamp NULL DEFAULT NULL,
                    `updated_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`id`)
                );
            ");
        } catch (Exception $e) {}
    }
}

function pdo() {
    $db = 'erp';
    $dsn = 'mysql:host=127.0.0.1';
    $user = 'root';
    $pass = '';
    if (empty($GLOBALS['APP_PDO'])) {
        try {
            $GLOBALS['APP_PDO'] = new PDO("{$dsn};dbname={$db}", $user, $pass);
            $GLOBALS['APP_PDO']->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $GLOBALS['APP_PDO']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $GLOBALS['APP_PDO'];
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
    return $GLOBALS['APP_PDO'];
}

function render($data, $callback) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>ERP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
        <link rel="stylesheet" href="/assets/app.css">
    </head>
    <body>
        <div class="container">
            <div class="menu-links">
                <a href="/">HOME</a> |
                <span>
                    Employees: 
                    <a href="/employees/add.php">ADD</a> |
                    <a href="/employees/edit.php">EDIT</a> |
                    <a href="/employees/delete.php">DELETE</a>
                </span>
            </div>
            <div><?php $callback($data); ?></div>
        </div>
    </body>
</html>
<?php
}

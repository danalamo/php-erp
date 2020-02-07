<?php

function getUsersWithLocations($options) {
    $column = arrget($options, 'column');
    $direction = arrget($options, 'direction');
    
    $orderBy = ($column && $direction) ? "ORDER BY $column $direction" : "";
    
    $sth = DB::pdo()->prepare($sql = "
        SELECT  
            u.*
            ,loc.line1 
            ,loc.city 
            ,loc.state 
            ,loc.zip 
        FROM users AS u
        LEFT JOIN locations AS loc ON loc.id = u.location_id
        $orderBy
    ");
    $sth->execute();
    return $sth->fetchAll();
}

function getLocations() {
    $sth = DB::pdo()->prepare($sql = "
        SELECT * 
        FROM locations
    ");
    $sth->execute();
    return $sth->fetchAll();
}

function pdo() {
    $db = env('PHP_ERP_DB_NAME');
    $host = env('PHP_ERP_DB_HOST');
    $user = env('PHP_ERP_DB_USER');
    $pass = env('PHP_ERP_DB_PASS');
    $dsn = "mysql:host={$host}";

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

class DB {
    private static $instance;
    private static $root_pdo;
    private static $table_pdo;

    private $db;
    private $dsn;
    private $host;
    private $user;
    private $pass;

    public function __construct()
    {
        $this->db = env('PHP_ERP_DB_NAME');
        $this->host = env('PHP_ERP_DB_HOST');
        $this->user = env('PHP_ERP_DB_USER');
        $this->pass = env('PHP_ERP_DB_PASS');
        $this->dsn = "mysql:host={$this->host}";

        if (!'debug') {
            echo "<pre>",print_r($this),'</pre>';
        }

        try {
            self::$root_pdo = new PDO("$this->dsn", $this->user, $this->pass);
            self::$root_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            self::$root_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->createDatabaseSchema();

            self::$table_pdo = new PDO("{$this->dsn};dbname={$this->db}", $this->user, $this->pass);
            self::$table_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            self::$table_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
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
                -- DROP DATABASE IF EXISTS `{$this->db}`;
            
                CREATE DATABASE `{$this->db}`;
                CREATE USER '{$this->user}'@'localhost' IDENTIFIED BY '{$this->pass}';
                GRANT ALL ON `{$this->db}`.* TO '{$this->user}'@'localhost';
                FLUSH PRIVILEGES;
            ");

            self::$root_pdo->exec($sql = /** @lang MySQL */ "
                CREATE TABLE `{$this->db}`.`locations` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `line1` varchar(255) NOT NULL,
                    `line2` varchar(255) NOT NULL,
                    `city` varchar(255) NOT NULL,
                    `state` varchar(255) NOT NULL,
                    `zip` varchar(255) NOT NULL,
                    `created_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`id`)
                );
                INSERT INTO `{$this->db}`.`locations` 
                    (line1, line2, city, state, zip, created_at) VALUES  
                    ('123 Main St', '', 'New York', 'NY', '10037', now())
                    ,('1424 Hills Pl NW', '', 'Atlanta', 'GA', '30318', now())
                    ,('Ellsworth Blvd NW', '', 'Marietta', 'GA', '30062', now())
                    ,('88 Sunny Drive', '', 'Los Angeles', 'CA', '30318', now())
                    ,('PO Box 1033', '', 'Birmingham', 'AL', '30318', now())
                ;
                
            
                CREATE TABLE `{$this->db}`.`users` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `first_name` varchar(255) NOT NULL,
                    `last_name` varchar(255) NOT NULL,
                    `active` tinyint(1) NOT NULL DEFAULT '1',
                    `location_id` int(11) NOT NULL,
                    `created_at` timestamp NULL DEFAULT NULL,
                    `updated_at` timestamp NULL DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    KEY `locations_location_id_foreign` (`location_id`),
                    CONSTRAINT `locations_location_id_foreign` 
                        FOREIGN KEY (`location_id`) REFERENCES `{$this->db}`.`locations` (`id`)
                );
                INSERT INTO `{$this->db}`.`users` 
                    (location_id, first_name, last_name, active, created_at, updated_at) VALUES 
                    (1, '<div onMousemove=\"javascript:alert(\'XSS Attack\')\">Daniel</div>', 'Alamo', true, now(), now())
                    -- (1, 'Daniel', 'Alamo', true, now(), now())
                    ,(5, 'Steven', 'Parson', false, now(), now())
                    ,(3, 'Alix', 'Segura', false, now(), now())
                    ,(2, 'Matt', 'Reiner', true, now(), now())
                    ,(4, 'Chuck', 'Norris', false, now(), now())
                ;
            ");
        } catch (Exception $e) {
            //print_r($e->getMessage());
        }
    }
}
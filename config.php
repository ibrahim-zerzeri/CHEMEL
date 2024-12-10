<?php
class config
{
    private static $pdo = null;

    public static function getConnexion()
    {
        // Check if the PDO instance is already created, if not, create it
        if (!isset(self::$pdo)) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "chemel";

            try {
                // Create a new PDO connection
                self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                // If the connection fails, display the error message and stop execution
                die('Erreur: ' . $e->getMessage());
            }
        }
        // Return the PDO instance
        return self::$pdo;
    }
}
?>

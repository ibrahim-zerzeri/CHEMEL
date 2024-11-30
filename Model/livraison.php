<?php

class Database
{
    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection == null) {
            try {
                self::$connection = new PDO("mysql:host=localhost;dbname=livraison", "utilisateur", "mot_de_passe");
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}

class livraison {
    private ?int $idL;
    private ?int $idp;
    private ?boolval $status;

    // Constructeur
    public function __construct(?int $idL, ?int $idP, ?boolval $status) {
        $this->idL = $idL;
        $this->idP = $idP;
        $this->status = $status;
    }

    // Getters et Setters

    public function getIdL(): ?int {
        return $this->idL;
    }

    public function setIdL(?int $idL): void {
        $this->idL = $idL;
    }

    public function getIdP(): ?int {
        return $this->idP;
    }

    public function setIdP(?int $idP): void {
        $this->idP = $idP;
    }
    public function getStatus(): ?boolval {
        return $this->Status;
    }

    public function setStatus(?boolval $Status): void {
        $this->Status = $Status;
    }

    
}

?>

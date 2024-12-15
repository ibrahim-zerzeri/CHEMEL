<?php

class Database
{
    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection == null) {
            try {
                self::$connection = new PDO("mysql:host=localhost;dbname=nom_de_la_base", "utilisateur", "mot_de_passe");
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}

class Order {
    private ?int $id;
    private ?string $client_name;
    private ?string $product;
    private ?string $address;
    private ?string $postal_code;
    private ?string $phone;
    private ?int $basket_id;

    // Constructeur
    public function __construct(?int $id, ?string $client_name, ?string $product, ?string $address, ?string $postal_code, ?string $phone, ?int $basket_id) {
        $this->id = $id;
        $this->client_name = $client_name;
        $this->product = $product;
        $this->address = $address;
        $this->postal_code = $postal_code;
        $this->phone = $phone;
        $this->basket_id = $basket_id;
    }

    // Getters et Setters

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getClientName(): ?string {
        return $this->client_name;
    }

    public function setClientName(?string $client_name): void {
        $this->client_name = $client_name;
    }

    public function getProduct(): ?string {
        return $this->product;
    }

    public function setProduct(?string $product): void {
        $this->product = $product;
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function setAddress(?string $address): void {
        $this->address = $address;
    }

    public function getPostalCode(): ?string {
        return $this->postal_code;
    }

    public function setPostalCode(?string $postal_code): void {
        $this->postal_code = $postal_code;
    }

    public function getPhone(): ?string {
        return $this->phone;
    }

    public function setPhone(?string $phone): void {
        $this->phone = $phone;
    }

    public function getBasketId(): ?int {
        return $this->basket_id;
    }

    public function setBasketId(?int $basket_id): void {
        $this->basket_id = $basket_id;
    }
}

?>

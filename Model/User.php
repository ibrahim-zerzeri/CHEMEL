<?php

class User {
    private ?int $id;
    private ?string $username;
    private ?string $password;
    private ?int $birthday;
    private ?string $establishment;

    // Constructor
    public function __construct(?int $id, ?string $username, ?string $password, ?int $birthday, ?string $establishment) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->birthday = $birthday;
        $this->establishment = $establishment;
    }

    // Getters and Setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getUsername(): ?string {
        return $this->username;
    }

    public function setUsername(?string $username): void {
        $this->username = $username;
    }

    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(?string $password): void {
        $this->password = $password;
    }

    public function getBirthday(): ?int {
        return $this->birthday;
    }

    public function setBirthday(?int $birthday): void {
        $this->birthday = $birthday;
    }

    public function getEstablishment(): ?string {
        return $this->establishment;
    }

    public function setEstablishment(?string $establishment): void {
        $this->establishment = $establishment;
    }
}

?>

<?php

class User {
    private ?int $id;
    private ?string $email;
    private ?string $username;
    private ?string $password;
    private ?int $birthday;
    private ?string $establishment;
    private ?bool $ban;
    private ?string $activation_token_hash;
    

    // Constructor
    public function __construct(?int $id,?string $email, ?string $username, ?string $password, ?int $birthday, ?string $establishment,?string $activation_token_hash) {
        $this->id = $id;
        $this->email=$email;
        $this->username = $username;
        $this->password = $password;
        $this->birthday = $birthday;
        $this->establishment = $establishment;
        $this-> $ban=FALSE;
        $this->activation_token_hash= $activation_token_hash;
        
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
    public function getEmail(): ?string {
        return $this->email;
    }
    
    public function setEmail(?string $email): void {
        $this->email = $email;
    }
    public function getToken(): ?string {
        return $this->activation_token_hash;
    }
    
    public function setToken(?string $activation_token_hash): void {
        $this->activation_token_hash = $activation_token_hash;
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
    public function getBan(): ?bool {
        return $this->ban;
    }

    public function setBan(?bool $ban): void {
        $this->ban = !($ban);
    }
}

?>

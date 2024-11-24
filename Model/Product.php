<?php

class Product {
    private ?int $id;
    private ?string $product_name;
    private ?string $category;
    private ?float $price;
    private ?int $quantity;
    private ?string $description;
    private ?string $image_path;

    // Constructor
    public function __construct(?int $id, ?string $product_name, ?string $category, ?float $price, ?int $quantity, ?string $description, ?string $image_path) {
        $this->id = $id;
        $this->product_name = $product_name;
        $this->category = $category;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->image_path = $image_path;
    }

    // Getters and Setters
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getProductName(): ?string {
        return $this->product_name;
    }

    public function setProductName(?string $product_name): void {
        $this->product_name = $product_name;
    }

    public function getCategory(): ?string {
        return $this->category;
    }

    public function setCategory(?string $category): void {
        $this->category = $category;
    }

    public function getPrice(): ?float {
        return $this->price;
    }

    public function setPrice(?float $price): void {
        $this->price = $price;
    }

    public function getQuantity(): ?int {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): void {
        $this->quantity = $quantity;
    }

    public function getDescription(): ?string {
        return $this->description;
    }

    public function setDescription(?string $description): void {
        $this->description = $description;
    }

    public function getImagePath(): ?string {
        return $this->image_path;
    }

    public function setImagePath(?string $image_path): void {
        $this->image_path = $image_path;
    }
}

?>

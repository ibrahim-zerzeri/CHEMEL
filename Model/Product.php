<?php

class Product {
    private ?int $id;
    private ?string $product_name;
    private ?string $category;
    private ?float $price;
    private ?int $quantity;
    private ?string $description;
    private ?string $image_path;
    private ?bool $is_shown;

    // **Constructor**
    public function __construct(
        ?int $id = null, 
        ?string $product_name = null, 
        ?string $category = null, 
        ?float $price = null, 
        ?int $quantity = null, 
        ?string $description = null, 
        ?string $image_path = null, 
        ?bool $is_shown = true
    ) {
        $this->id = $id;
        $this->product_name = $product_name;
        $this->category = $category;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->image_path = $image_path;
        $this->is_shown = $is_shown;
    }

    // **Getters and Setters**
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

    public function setIsShown(?bool $is_shown): void {
        $this->is_shown = $is_shown;
    }

    public function getIsShown(): ?bool {
        return $this->is_shown;
    }  
} 

?>

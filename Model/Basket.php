<?php
class Basket {
    private ?int $id;
    private array $products; // Array of products and their quantities

    public function __construct(?int $id = null, array $products = []) {
        $this->id = $id;
        $this->products = $products;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getProducts(): array {
        return $this->products;
    }

    public function setProducts(array $products): void {
        $this->products = $products;
    }

    public function addProduct(Product $product, int $quantity): void {
        $this->products[] = ['product' => $product, 'quantity' => $quantity];
    }
}
?>

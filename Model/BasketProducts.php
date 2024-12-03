<?php
class BasketProducts {
    private ?int $basket_id;
    private ?int $product_id;
    private ?int $quantity;

    public function __construct(?int $basket_id = null, ?int $product_id = null, ?int $quantity = null) {
        $this->basket_id = $basket_id;
        $this->product_id = $product_id;
        $this->quantity = $quantity;
    }

    /**
     * @return int|null
     */
    public function getBasketId(): ?int {
        return $this->basket_id;
    }

    /**
     * @param int|null $basket_id
     */
    public function setBasketId(?int $basket_id): void {
        $this->basket_id = $basket_id;
    }

    /**
     * @return int|null
     */
    public function getProductId(): ?int {
        return $this->product_id;
    }

    /**
     * @param int|null $product_id
     */
    public function setProductId(?int $product_id): void {
        $this->product_id = $product_id;
    }

    /**
     * @return int|null
     */
    public function getQuantity(): ?int {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     */
    public function setQuantity(?int $quantity): void {
        $this->quantity = $quantity;
    }
}

?>

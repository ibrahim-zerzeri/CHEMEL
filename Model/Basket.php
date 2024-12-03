<?php
class Basket {
    private ?int $id;
   // Array of products and their quantities

    public function __construct(?int $id = null) {
        $this->id = $id;
       
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

   
}
?>

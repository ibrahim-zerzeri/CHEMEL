<?php
class Basket {
    private ?int $id;
    private ?int $user_id;
   // Array of products and their quantities

    public function __construct(?int $id = null, ?int $user_id = null) {
        $this->id = $id;
        $this->user_id = $user_id;
       
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }
    public function getUserId(): ?int {
        return $this->user_id;
    }
    public  function setUserId(?int $user_id): void {
        $this->user_id = $user_id;  
    }

   
}
?>

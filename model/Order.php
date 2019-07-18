<?php

echo "Loading Order... <br/>";

class Order 
{
    function __construct(int $user_id, string $status = "new")
    {
        echo "Order->__construct($user_id, $status) <br/>";
        $this->user_id = $user_id;
        $this->status = $status;
    }

    function set_status(string $new_status = null)
    {
        echo "Order->set_status($new_status) <br/>";
        if (!in_array($new_status, ["new", "paid", "confirmed", "shipped"]))
            throw new Exception("$new_status Is not a correct status", 1);
            
        $this->status = $new_status;
    }
}

echo "Order Loaded! <br/>";

?>
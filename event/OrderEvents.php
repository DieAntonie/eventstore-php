<?php

echo "Loading Order Events... <br/>";

class OrderCreated
{
    function __construct(int $user_id = null)
    {
        echo __METHOD__."($user_id) <br/>";
        $this->user_id = $user_id;
    }
}

class StatusChanged
{
    function __construct(string $new_status = null)
    {
        echo __METHOD__."($new_status) <br/>";
        $this->new_status = $new_status;
    }
}

echo "Order Events Loaded! <br/>";

?>
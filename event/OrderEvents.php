<?php

echo "Loading OrderEvents.php... <br/>";

require_once "model/Order.php";

class OrderCreated
{
    function __construct(int $user_id = null)
    {
        echo __METHOD__."($user_id) <br/>";
        $this->user_id = $user_id;
    }
}

define("ORDER_CREATED_CLASS", get_class(new OrderCreated()));
echo ORDER_CREATED_CLASS." Loaded! <br/>";

class StatusChanged
{
    function __construct(string $new_status = null)
    {
        echo __METHOD__."($new_status) <br/>";
        $this->new_status = $new_status;
    }
}

define("STATUS_CHANGED_CLASS", get_class(new StatusChanged()));
echo STATUS_CHANGED_CLASS." Loaded! <br/>";

?>

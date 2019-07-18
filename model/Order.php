<?php

echo "Loading Order.php... <br/>";

require_once "event/OrderEvents.php";

class Order 
{
    function __construct(array $events = [])
    {
        echo __METHOD__."(".json_encode($events).") <br/>"; // 
        foreach ($events as $index => $event) {
            $this->apply($event);
        }
        $this->changes = [];
    }

    function apply($event)
    {
        echo __METHOD__."(".json_encode($event).") <br/>";
        switch (get_class($event)) {
            case ORDER_CREATED_CLASS:
                $this->user_id = $event->user_id;
                $this->status = "new";
                break;

            case STATUS_CHANGED_CLASS:
                $this->status = $event->new_status;
                break;

            default:
                break;
        }
    }

    function set_status(string $new_status = null)
    {
        echo __METHOD__."($new_status) <br/>";
        if (!in_array($new_status, ["new", "paid", "confirmed", "shipped"]))
            throw new Exception("\"$new_status\" is not a correct status", 1);
            
        $event = new StatusChanged($new_status);
        $this->apply($event);
        array_push($this->changes, $event);
    }
}

define("ORDER_CLASS", get_class(new Order()));
echo ORDER_CLASS." Loaded! <br/>";

?>

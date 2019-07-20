<?php

echo "Loading Order.php... <br/>";

require_once "event/OrderEvents.php";

/** Stateful representation of an Order */
class Order 
{
    /**
     * `User` assoiciated with the `Order`
     * @var int
     */
    var $user_id;

    /**
     * Status of the `Order`
     * @var string
     */
    var $status;

    /**
     * Series of `Event`'s representing the changes the `Order` has undergone since re-hydration
     * @var array
     */
    var $changes = array();

    /**
     * Re-hydrate an instance of an `Order` by applying some `array` of `Event`'s 
     * @param array|null [$events] Series of `Event`s to apply
     */
    function __construct(array $events = [])
    {
        echo __METHOD__."(".json_encode($events).") <br/>";
        foreach ($events as $index => $event) {
            $this->apply($event);
        }
    }

    /**
     * Instantiates a new `Order` by some `User`
     * @param int $user_id `User::$id` creating the `Order`
     */
    static function create(int $user_id)
    {
        echo __METHOD__."($user_id) <br/>";
        $initial_event = new OrderCreated($user_id);
        $instance = new Order(array($initial_event));
        array_push($instance->changes, $initial_event);
        return $instance;
    }

    /**
     * Mutate the state of this `Order` by applying an `Event` 
     * @param OrderCreated|StatusChanged $event `Event` being applied
     */
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

    /**
     * Change the status of this `Order` 
     * @param string|null $new_status New `Order::$status` value
     */
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
/**  GLOBAL `string` represetation of the `Order` class */ 
define("ORDER_CLASS", get_class(new Order()));
echo ORDER_CLASS." Loaded! <br/>";

?>

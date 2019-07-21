<?php

echo "Loading Order.php... <br/>";

require_once "model/Aggregate.php";
require_once "event/OrderEvents.php";

/** Stateful representation of an Order */
class Order extends Aggregate
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
     * Re-hydrate an instance of an `Order` by applying some `array` of `Event`'s 
     * @param EventStore|null [$event_stream] Series of `Event`s to apply
     */
    function __construct(EventStream $event_stream = null)
    {
        echo __METHOD__."(".json_encode($event_stream).") <br/>";
        parent::__construct($event_stream);
        if ($event_stream)
            foreach ($event_stream->events as $event)
                $this->apply($event);
            
    }

    /**
     * Instantiates a new `Order` by some `User`
     * @param int $user_id `User::$id` creating the `Order`
     */
    static function create(int $user_id)
    {
        echo __METHOD__."($user_id) <br/>";
        $initial_event = new OrderCreated($user_id);
        $event_stream = new EventStream(array($initial_event));
        $instance = new Order($event_stream);
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
        if ($event instanceof OrderCreated) {
            $this->user_id = $event->user_id;
            $this->status = "new";
        }
        elseif ($event instanceof StatusChanged) {
            $this->status = $event->new_status;
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

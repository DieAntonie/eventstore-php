<?php

echo "Loading OrderEvents.php... <br/>";

/** Interface for an `OrderEvent` */
interface IOrderEvent
{
    /**
     * Capture an event
     * @param string $uuid User creating `Order`
     * @return OrderEvent
     */
    function __construct(string $uuid);
}

/** Abstract base for all `OrderEvent`s that mutate the `Order` aggregate */
abstract class OrderEvent implements IOrderEvent
{
    /**
     * Unique identifier for the 'OrderEvent'
     * @var string
     */
    var $uuid;

    /**
     * Capture an event
     * @param string $uuid Event unique identifier
     * @return OrderEvent
     */
    function __construct(string $uuid = null)
    {
        echo __METHOD__."($uuid) <br/>";
        $this->uuid = $uuid;
    }
}

/** `OrderEvent` corrosponding to some `Order` being created. */
class OrderCreated extends OrderEvent
{
    /**
     * `OrderCreated` event payload of user creating the `Order`.
     * @var int
     */
    var $user_id;

    /**
     * Capture the event of an `Order` being created with the `$user_id` of some `User`
     * @param string $uuid `OrderEvent` unique identifier
     * @param int|null $user_id User creating `Order`
     * @return OrderCreated
     */
    function __construct(string $uuid = null, int $user_id = null)
    {
        echo __METHOD__."($uuid, $user_id) <br/>";
        parent::__construct($uuid);
        $this->user_id = $user_id;
    }
}
/**  GLOBAL `string` represetation of the `OrderCreated` class */ 
define("ORDER_CREATED_CLASS", get_class(new OrderCreated()));
echo ORDER_CREATED_CLASS." Loaded! <br/>";

/** Event corrosponding to `Order::$status` being changed. */
class StatusChanged extends OrderEvent
{
    /**
     * `StatusChanged` event payload of status the `Order` is changing too.
     * @var string
     */
    var $new_status;

    /**
     * Capture the event of an `Order` changing status
     * @param string $uuid `OrderEvent` unique identifier 
     * @param string|null $new_status New status value of `Order::$status`
     * @return StatusChanged
     */
    function __construct(string $uuid = null, string $new_status = null)
    {
        echo __METHOD__."($uuid, $new_status) <br/>";
        parent::__construct($uuid);
        $this->new_status = $new_status;
    }
}
/**  GLOBAL `string` represetation of the `StatusChanged` class */ 
define("STATUS_CHANGED_CLASS", get_class(new StatusChanged()));
echo STATUS_CHANGED_CLASS." Loaded! <br/>";

?>

<?php

echo "Loading Aggreagte.php... <br/>";

Interface IAggregate
{

    /**
     * Re-hydrate an instance of an `Order` by applying some `array` of `Event`'s 
     * @param EventStore|null [$event_stream] Series of `Event`s to apply
     */
    function __construct(EventStream $event_stream = null);
    
    /**
     * Mutate the state of this `Order` by applying an `Event` 
     * @param Event $event `Event` being applied
     */
    function apply($event); 
}

abstract class Aggregate implements IAggregate
{
    /**
     * Aggregate’s current version
     * @var int
     */
    var $version;

    /**
     * Re-hydrate an instance of an `Order` by applying some `array` of `Event`'s 
     * @param EventStore|null [$event_stream] Series of `Event`s to apply
     */
    function __construct(EventStream $event_stream = null)
    {
        echo __METHOD__."(".json_encode($event_stream).") <br/>";
        if ($event_stream)
            $this->version = $event_stream->version;
    }

    /**
     * Mutate the state of this `Order` by applying an `Event` 
     * @param OrderCreated|StatusChanged $event `Event` being applied
     */
    abstract function apply($event);
}
/**  GLOBAL `string` represetation of the `Aggregate` class */ 
define("AGGREGATE_CLASS", "Aggregate");
echo AGGREGATE_CLASS." Loaded! <br/>";

?>
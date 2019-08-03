<?php

echo "Loading Aggreagte.php... <br/>";

require_once "utils/Tools.php";

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
     * @param bool $hydration `Event` being applied as re-hydration?
     */
    function apply($event, $hydration); 
}


abstract class Aggregate implements IAggregate
{
    /**
     * Aggregate’s current version
     * @var int
     */
    protected $version;

    /**
     * Unique identifier for the Aggregate
     * @var string
     */
    protected $uuid;

    /**
     * Series of `Event`'s representing the changes the `Aggregate` has undergone since re-hydration
     * @var array
     */
    protected $changes = array();

    /**
     * Re-hydrate an instance of an `Order` by applying some `array` of `Event`'s 
     * @param EventStore|null [$event_stream] Series of `Event`s to apply
     */
    function __construct(EventStream $event_stream = null)
    {
        echo __METHOD__."(".json_encode($event_stream).") <br/>";
        $this->uuid = gen_uuid();
        if ($event_stream)
            $this->version = $event_stream->version;
    }

    /**
     * Re-hydrate an instance of an `Order` by applying some `array` of `Event`'s 
     * @param EventStore|null [$event_stream] Series of `Event`s to apply
     */
    function getUuid()
    {
        echo __METHOD__."() <br/>";
        return $this->uuid;
    }

    /**
     * Re-hydrate an instance of an `Order` by applying some `array` of `Event`'s 
     * @param EventStore|null [$event_stream] Series of `Event`s to apply
     */
    function getVersion()
    {
        echo __METHOD__."() <br/>";
        return $this->version;
    }

    /**
     * Re-hydrate an instance of an `Order` by applying some `array` of `Event`'s 
     * @param EventStore|null [$event_stream] Series of `Event`s to apply
     */
    function getChanges()
    {
        echo __METHOD__."() <br/>";
        return $this->changes;
    }

    /**
     * Mutate the state of this `Order` by applying an `Event` 
     * @param OrderCreated|StatusChanged $event `Event` being applied
     * @param bool $hydration `Event` being applied as re-hydration?
     */
    abstract function apply($event, $hydration = false);
}
/**  GLOBAL `string` represetation of the `Aggregate` class */ 
define("AGGREGATE_CLASS", "Aggregate");
echo AGGREGATE_CLASS." Loaded! <br/>";


class AggregateRepository
{
    /**
     * @var EventStore
     */
    protected $event_store;

    function __construct(EventStore $event_store = null)
    {
        echo __METHOD__."(".json_encode($event_store).") <br/>";
        $this->event_store = $event_store;
    }

    function get(string $aggregate_uuid)
    {
        echo __METHOD__."($aggregate_uuid) <br/>";
        $event_stream = $this->event_store->load_stream($aggregate_uuid);
        return new Aggregate($event_stream);
    }

    function save(Aggregate $aggregate)
    {
        echo __METHOD__."(".json_encode($aggregate).") <br/>";
        $this->event_store->append_to_stream($aggregate);
    }
}
/**  GLOBAL `string` represetation of the `Aggregate` class */ 
define("AGGREGATE_REPOSITORY_CLASS", get_class(new AggregateRepository()));
echo AGGREGATE_REPOSITORY_CLASS." Loaded! <br/>";

?>
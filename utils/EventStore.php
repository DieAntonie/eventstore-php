<?php

echo "Loading EventStore.php... <br/>";

/** Robust event store for retriving and persisting aggregate event streams*/
abstract class EventStore
{
    /**
     * Return's an `EventStream` instance, a simple data structure with list of events needed for aggregate’s
     * initialization and current aggregate’s version.
     * @param string $aggregate_uuid Business object uinique identifier
     */
    abstract function load_stream(string $aggregate_uuid);

    /**
     * Accepts a business object's uuid, the expected version (the one we obtained from `EventStore::load_stream()`)
     * and a list of events our aggregate produced.
     * @param Aggregate $aggregate Business object
     */
    abstract function append_to_stream(Aggregate $aggregate);
}
/**  GLOBAL `string` represetation of the `EventStore` class */ 
define("EVENT_STORE_CLASS", "EventStore");
echo EVENT_STORE_CLASS." Loaded! <br/>";



?>

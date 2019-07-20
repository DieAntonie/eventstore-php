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
     * @param string $aggregate_uuid Business object uinique identifier
     * @param int $expected_version Protection against concurrent updates
     * @param array $events List of `Event`'s the aggregate produced
     */
    abstract function append_to_stream(string $aggregate_uuid, int $expected_version, array $events);
}

?>

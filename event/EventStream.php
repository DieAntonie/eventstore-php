<?php

echo "Loading EventStream.php...";

/**
 * A simple data structure with list of `Event`'s needed for aggregate’s initialization and current aggregate’s 
 * version
 */
class EventStream
{
    /**
     * `Event`'s needed for aggregate’s initialization
     * @var array
     */
    var $events;

    /**
     * Aggregate’s current version
     * @var int
     */
    var $version;

    /**
     * Instantiate a stream of `Event`'s corrosponding to some version of an aggregate
     * @param array $events `Event`'s needed for aggregate’s initialization
     * @param int|null $version Aggregate’s expected current version
     */
    function __construct(array $events, int $version = null)
    {
        echo __METHOD__."(".json_encode($events).",$version) <br/>";
        $this->events = $events;
        $this->version = $version;
    }
}

?>

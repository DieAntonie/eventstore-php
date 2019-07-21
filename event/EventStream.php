<?php

echo "Loading EventStream.php... <br/>";

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
    function __construct(array $events = null, int $version = null)
    {
        echo __METHOD__."(".json_encode($events).",$version) <br/>";
        $this->events = $events;
        $this->version = $version;
    }
}
/**  GLOBAL `string` represetation of the `EventStream` class */ 
define("EVENT_STREAM_CLASS", get_class(new EventStream()));
echo EVENT_STREAM_CLASS." Loaded! <br/>";

?>

<?php

echo "Loading MySQLEventStore.php... <br/>";

require_once "event/EventStream.php";
require_once "utils/EventStore.php";
require_once "utils/Query.php";
require_once "utils/Tools.php";

/** MySQL `EventStore` implementation */
class MySQLEventStore extends EventStore
{    
    /**
     * @inheritdoc
     */
    function load_stream(string $aggregate_uuid)
    { 
        echo __METHOD__."($aggregate_uuid) <br/>";
        $aggregate = $query ->table('aggregates')
                            ->where('uuid', '=', $aggregate_uuid)
                            ->execute();

        $events = $query ->table('events')
                            ->where('aggregate_uuid', '=', $aggregate_uuid)
                            ->execute();

        $events_objects = array();
        foreach ($events as $event)
            $events_objects[] = $this->_translate_to_object($event);
        $version = $aggregate[0]->version;
 
        return EventStream($events_objects, $version);
    }

    private function _translate_to_object($event_model)
    {
        echo __METHOD__."(".json_encode($event_model).") <br/>";
        $class_name = $event_model->name;
        $kwargs = $event_model->payload;
        $uuid = $event_model->uuid;
        return new $class_name($uuid, $kwargs);
    }
    
    /**
     * @inheritdoc
     */
    function append_to_stream(Aggregate $aggregate)
    {
        echo __METHOD__."(".json_encode($aggregate).") <br/>";
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "flashcards";
        $mysqli = new mysqli($servername, $username, $password, $dbname);
        $query = new Query($mysqli);

        $aggregate_version = $aggregate->getVersion();
        $aggregate_uuid = $aggregate->getUuid();
        $aggregate_changes = $aggregate->getChanges();

        if ($aggregate_version) {
            $query->table('aggregates')
                ->update(array("version"), $aggregate_version + 1)
                ->where("uuid", "=",  $aggregate_uuid)
                ->and_where("version", "=", $aggregate_version)
                ->execute();
        } else {
            $query->table('aggregates')
                ->insert(array("uuid", "version"), array($aggregate_uuid, 1))
                ->execute();
        }

        foreach ($aggregate_changes as $event) {
            $query->table('events')
                ->insert(array("uuid",
                               "aggregate_uuid",
                               "name",
                               "payload"), 
                         array(gen_uuid(),
                               $aggregate_uuid,
                               get_class($event),
                               json_encode($event)))
                ->execute();
        }
    }
}
/**  GLOBAL `string` represetation of the `MySQLEventStore` class */ 
define("MYSQL_EVENT_STORE_CLASS", get_class(new MySQLEventStore()));
echo MYSQL_EVENT_STORE_CLASS." Loaded! <br/>";

?>

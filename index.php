<?php

require_once "model/Order.php";
require_once "event/OrderEvents.php";

echo "Hello Wolrd! <br/>";

$eventArr = array(new OrderCreated(3), new StatusChanged("paid"), new StatusChanged("confirmed"));
$myOrder = new Order($eventArr);
$myOrder->set_status("shipped");
echo json_encode($myOrder);

?>

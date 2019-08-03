<?php

require_once "model/Order.php";
// =========================================
// Output:
// =========================================
// Loading Order.php... 
// Loading Aggreagte.php... 
// Aggregate Loaded! 
// Loading OrderEvents.php... 
// OrderCreated::__construct(, ) 
// OrderEvent::__construct() 
// OrderCreated Loaded! 
// StatusChanged::__construct(, ) 
// OrderEvent::__construct() 
// StatusChanged Loaded! 
// Order::__construct(null) 
// Aggregate::__construct(null) 
// Order Loaded!
 
require_once "utils/MySQLEventStore.php";
// =========================================
// Output:
// =========================================
// Loading MySQLEventStore.php... 
// Loading EventStream.php... 
// EventStream::__construct(null,) 
// EventStream Loaded! 
// Loading EventStore.php... 
// EventStore Loaded! 
// MySQLEventStore Loaded! 

$myOrder = Order::create(3);
// =========================================
// Output:
// =========================================
// Order::create(3) 
// Order::__construct(null) 
// Aggregate::__construct(null) 
// OrderCreated::__construct(, 3) 
// OrderEvent::__construct() 
// Order::apply({"user_id":3}, )

$myOrder->set_status("shipped");
// =========================================
// Output:
// =========================================
// Order::set_status(shipped) 
// StatusChanged::__construct(, shipped) 
// OrderEvent::__construct() 
// Order::apply({"new_status":"shipped"}, ) 

echo json_encode($myOrder)."<br/>";
// =========================================
// Output:
// =========================================
// {
//   "user_id" : 3,
//   "status" : "shipped",
// }

$myStore = new MySQLEventStore();

$myStore->append_to_stream($myOrder);
// =========================================
// Output:
// =========================================
// MySQLEventStore::append_to_stream({"user_id":3,"status":"shipped"}) 
// Aggregate::getVersion() 
// Aggregate::getUuid() 
// Aggregate::getChanges() 

?>

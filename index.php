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

$orderAggregate = gen_uuid();

$myStore->append_to_stream($orderAggregate, null, $myOrder->getChanges());
// =========================================
// Output:
// =========================================
// Aggregate::getChanges() 
// MySQLEventStore::append_to_stream(29b690c5-f80f-4dc5-8b39-2e67a0ea6803, , [{"user_id":3},{"new_status":"shipped"}])

?>

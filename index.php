<?php

require_once "model/Order.php";
require_once "event/OrderEvents.php";
/**
 * =========================================
 * Output:
 * =========================================
 * Loading Order.php... 
 * Loading OrderEvents.php... 
 * OrderCreated::__construct() 
 * OrderCreated Loaded! 
 * StatusChanged::__construct() 
 * StatusChanged Loaded! 
 * Order::__construct([])
 * Order Loaded! 
 */

$eventArr = array(new OrderCreated(3), new StatusChanged("paid"), new StatusChanged("confirmed"));
/**
 * =========================================
 * Output:
 * =========================================
 * OrderCreated::__construct(3) 
 * StatusChanged::__construct(paid) 
 * StatusChanged::__construct(confirmed) 
 */

$myOrder = new Order($eventArr);
/**
 * =========================================
 * Output:
 * =========================================
 * Order::__construct([{"user_id":3},{"new_status":"paid"},{"new_status":"confirmed"}])
 * Order::apply({"user_id":3}) 
 * Order::apply({"new_status":"paid"}) 
 * Order::apply({"new_status":"confirmed"}) 
 */

$myOrder->set_status("shipped");
/**
 * =========================================
 * Output:
 * =========================================
 * Order::set_status(shipped) 
 * StatusChanged::__construct(shipped) 
 * Order::apply({"new_status":"shipped"}) 
 */

echo json_encode($myOrder);
/**
 * =========================================
 * Output:
 * =========================================
 * {
 *   "user_id" : 3,
 *   "status" : "shipped",
 *   "changes" : [ {
 *     "new_status" : "shipped"
 *   } ]
 * }
 */

?>

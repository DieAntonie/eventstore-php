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

$myOrder = Order::create(3);
/**
 * =========================================
 * Output:
 * =========================================
 * Order::create(3) 
 * OrderCreated::__construct(3) 
 * Order::__construct([{"user_id":3}])
 * Order::apply({"user_id":3}) 
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
 *   "changes" : [
 *     { "user_id" : 3 },
 *     { "new_status" : "shipped" }
 *   ]
 * }
 */

?>

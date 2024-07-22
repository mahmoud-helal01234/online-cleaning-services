<?php
// Define the order statuses as constant variables in a PHP file
// app/Constants/OrderStatusConstants.php
namespace App\Http\Constants;

class OrderStatusesConstant
{

    public const statuses = [

        'in_cart',
        'in_waiting_list',
        'confirmed',
        'in_picking',
        'picked_up',
        'in_processing',
        'processing_done',
        'in_delivery_box',
        'in_delivery',
        'delivered'
    ];
    
}


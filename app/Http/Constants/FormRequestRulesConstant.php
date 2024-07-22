<?php
// Define the order statuses as constant variables in a PHP file
// app/Constants/OrderStatusConstants.php
namespace App\Http\Constants;

class FormRequestRulesConstant
{
    public const ImageValidation = 'image|mimes:png,jpg|max:10000';
}


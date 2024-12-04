<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use App\Http\Services\Products\CategoriesService;

class InvoiceController extends Controller
{
    private $categoriesService;
    public function __construct()
    {

        $this->categoriesService = new CategoriesService();
    }
    // Show the invoice creation form
    public function create()
    {

        $categories = $this->categoriesService->get();
        return view('invoice.create', ["categories" => $categories]);
    }

    // Handle the form submission and generate the PDF invoice


    
    public function generate(Request $request)
    {
        // Collect the basic order details from the request
        $order = [
            'id' => $request->id,  // Order ID
            'client_name' => $request->client_name,  // Client name
            'phone' => $request->phone,  // Client phone
            'address' => $request->address,  // Client address
            'discount' => $request->discount,  // Discount amount
            'price' => $request->price,  // Total price before discount
        ];
    
        // Collect item details from the 'items' array in the request
        $items = [];
        $itemCount = count($request->items);
    
        // Loop through each item in the 'items' array
        for ($i = 0; $i < $itemCount; $i++) {
            $itemName = $request->items[$i]['item_name'];
            $itemPrice = $request->items[$i]['item_price'];
            $itemQuantity = $request->items[$i]['item_quantity'];
    
            // Add each item to the 'items' array
            $items[] = [
                'name_en' => $itemName,  // Item name
                'price' => $itemPrice,  // Item price
                'quantity' => $itemQuantity,  // Item quantity
            ];
    
            // Add the item's subtotal to the order total
            $order['price'] += $itemPrice * $itemQuantity;
        }
    
        // Handle discount (if applicable)
        $discountValue = 0;
        if ($order['discount'] > 0) {
            $discountValue = ($order['price'] * $order['discount']) / 100;
        }
    
        // Adjust the total price after applying the discount
        $order['price'] -= $discountValue;
    
        // Generate HTML content for the invoice using a Blade view
        $html = view('invoice.pdf', compact('order', 'items', 'discountValue'))->render();
    
        // Initialize Dompdf with options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $dompdf = new Dompdf($options);
    
        // Load the HTML content into Dompdf
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        // Define the file directory for saving the PDF
        $fileDir = public_path('invoices');
        if (!file_exists($fileDir)) {
            mkdir($fileDir, 0755, true);
        }
    
        // Define the file path to save the generated PDF
        $filePath = $fileDir . '/order_invoice_' . $order['id'] . '.pdf';
    
        // Save the generated PDF to the file system
        file_put_contents($filePath, $dompdf->output());
    
        // Return the URL of the generated PDF for the front-end to handle
        return response()->json(['pdf_url' => asset('invoices/order_invoice_' . $order['id'] . '.pdf')]);
    
    }
    
}

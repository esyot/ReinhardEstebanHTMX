<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) {
        $products = Product::orderBy('id');

        if($request->filter) {
            $products->where('name','like',"%$request->filter%")
                        ->orWhere('description','like',"%$request->filter%");
        }

         $html = "";

         foreach($products->get() as $prod) {
            $html .= "
        <div class='p-4 rounded bg-blue-200 flex items-center'>
        
            <div class='w-6/4 pl-4'>
                <h2 class='text-xl font-bold'>Name: {$prod->name}</h2>
                <p>Description: {$prod->description}</p>
                <p class='text-green-500 font-semibold'>Price: ₱{$prod->price}</p>
                <p class='text-green-500 font-semibold'>Quantity: {$prod->quantity}</p>
            </div>
        </div>
    ";
         }
         return $html;
    }

    public function store(Request $request)
    {
     
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);
    
    
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        $products = Product::orderBy('id');

      

         $html = "";

         foreach($products->get() as $prod) {
            $html .= "
        <div class='p-4 rounded bg-blue-200 flex items-center'>
        
            <div class='w-3/45 pl-4'>
                <h2 class='text-xl font-bold'>Name: {$prod->name}</h2>
                <p>Description: {$prod->description}</p>
                <p class='text-green-500 font-semibold'>Price: ₱{$prod->price}</p>
                <p class='text-green-500 font-semibold'>Quantity: {$prod->quantity}</p>
            </div>
        </div>

        <div hx-swap-oob='true' id='success' class='bg-green-200 text-center m-2 rounded'>
        Product Successfully Added!
   
        </div>
       
     
    ";
         }

         if($product){

            return $html . " <div hx-get='/message' hx-target='#message' hx-trigger='load'></div>";

         }else{

            return $html . " <div hx-get='/error' hx-target='#message' hx-trigger='load'></div>";

         }
        
    }

    public function open() {
        $html = '';
    
        $html .= '<div class="modal-header flex justify-between items-center border-b pb-2">
            <h4 class="text-lg">Create Product</h4>
        </div>
        <div class="modal-body my-4">
            <form id="modalForm" hx-post="api/create-product" hx-target="#products-list" hx-swap="innerHTML">
       
            <div class="form-group mb-4">
                    <label for="name" class="block mb-2">Name:</label>
                    <input type="text" id="name" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product name" name="name" required> 
                </div>
                <div class="form-group mb-4">
                    <label for="description" class="block mb-2">Description:</label>
                    <input type="text" id="description" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product description" name="description" required>
                </div>
                <div class="form-group mb-4">
                    <label for="price" class="block mb-2">Price:</label>
                    <input type="number" id="price" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product price" name="price" required>
                </div>
                <div class="form-group mb-4">
                    <label for="quantity" class="block mb-2">Quantity:</label>
                    <input type="number" id="quantity" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product quantity" name="quantity" required>
                </div>

                <div id="success" class="bg-green-200">

                </div>

                <div class="flex justify-between items-center">

                    <button type="submit" id="modalSubmitButton" class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">Submit</button>
              
                </form>

                </div>
                
                <div class="float-right my-0">

                <button id="modalSubmitButton" onclick="closeModal()" class="btn bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300">Close</button>
               </div>
        </div>';
    
        return $html;
    }
    
    

public function close() {
    $html = '';

    $html .= '<button type="button" id="modalSubmitButton" onclick="closeModal()" class="btn bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 transition duration-300">Close</button>';

    return $html;
}

public function message(){

    $html = '';

    $html .= '
     <div hx-swap-oob="true" id="success" class="bg-green-200 text-center m-2 rounded">
     Product Successfully Added!

     </div>
    ';
    return $html;
}

public function error(){

    $html = '';

    $html .= '
     <div id="error" class="bg-red-200 text-center m-2 rounded">
     Product Error!

     </div>
    ';
    return $html;
    }
    
}

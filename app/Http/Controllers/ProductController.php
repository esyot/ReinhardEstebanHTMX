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
                <div class='m-2'>
                
                <button onclick='updateModal()' class='btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300'>Update</button>
                
                <button onclick='confirmDeleteModal()' class='bg-red-500 text-white font-bold py-2 px-4 rounded'>
        Delete Item
    </button>
    </div>
            </div>
            </div>


        </a>

        <div id='confirmationModal' class='hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center'>
        <div class='bg-white p-6 rounded-lg shadow-lg text-center relative'>
            <p class='mb-4'>Are you sure you want to delete this item?</p>
            <div class='flex justify-center'>
            <button 
            hx-delete='api/delete/". $prod->id."'
            hx-swap='innerHTML'
            hx-target='#products-list'
            hx-trigger='click'
            class='btn bg-green-500 text-white mr-2 px-4 py-2 rounded hover:bg-green-700 transition duration-300'>Yes</button>
                
            <button onclick='cancelDelete()' class='bg-red-500 text-white font-bold py-2 px-4 hover:bg-red-700 rounded'>Cancel</button>
            </div>
        </div>
    </div>

    <div id='updateModal' class='hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center'>
        <div class='bg-white p-6 rounded-lg shadow-lg text-center relative'>
        <h1 class='text-xl' >Update Product</h1>
        <div class='form-group'>
            <label for='name' class='block mt-2 float-left'>Name:</label>
            <input type='text' value='".$prod->name."' id='name' class='w-full p-2 border border-gray-300 rounded' placeholder='Enter product name' name='name'>
        </div>

        <div class='form-group'>
            <label for='description' class='block mt-2 float-left'>Description:</label>
            <input type='text' value='".$prod->description."' id='description' class='w-full p-2 border border-gray-300 rounded' placeholder='Enter product description' name='description'>
        </div>

        <div class='form-group'>
            <label for='price' class='block mt-2 float-left'>Price:</label>
            <input type='text' value='".$prod->price."' id='price' class='w-full p-2 border border-gray-300 rounded' placeholder='Enter product price' name='price'>
        </div>

        <div class='form-group'>
            <label for='quantity' class='block mt-2 float-left'>Quantity:</label>
            <input type='text' value='".$prod->quantity."' id='quantity' class='w-full p-2 border border-gray-300 rounded' placeholder='Enter product quantity' name='quantity'>
        </div>

        <div class='m-2'>
                    
        <button class='btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300'>Update</button>
        
        <button onclick='closeUpdateModal()' class='bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-700 transition duration-300'>Cancel</button>
            </div>
        </div>
    </div>

       
    
    
    
    ";
    
         }
         return $html;
    }

    public function store(Request $request)
    {
        try {
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

            foreach ($products->get() as $prod) {
                $html .= "
                
                <div class='p-4 rounded bg-blue-200 flex items-center'>

                <div class='w-6/4 pl-4'>
                    <h2 class='text-xl font-bold'>Name: {$prod->name}</h2>
                    <p>Description: {$prod->description}</p>
                    <p class='text-green-500 font-semibold'>Price: ₱{$prod->price}</p>
                    <p class='text-green-500 font-semibold'>Quantity: {$prod->quantity}</p>
                    <div class='m-2'>
                    
                    <button class='btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300'>Update</button>
                    
                    <button onclick='confirmDeleteModal()' class='bg-red-500 text-white font-bold py-2 px-4 rounded'>
            Delete Item
        </button>
        </div>
                </div>
                </div>
    
    
            </a>
    
            <div id='confirmationModal' class='hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center'>
            <div class='bg-white p-6 rounded-lg shadow-lg text-center relative'>
                <p class='mb-4'>Are you sure you want to delete this item?</p>
                <div class='flex justify-center'>
                <button 
                hx-delete='api/delete/". $prod->id."'
                hx-swap='innerHTML'
                hx-target='#products-list'
                hx-trigger='click'
                class='btn bg-green-500 text-white mr-2 px-4 py-2 rounded hover:bg-green-700 transition duration-300'>Yes</button>
                    
                <button onclick='cancelDelete()' class='bg-red-500 text-white font-bold py-2 px-4 hover:bg-red-700 rounded'>Cancel</button>
                </div>
            </div>
        </div>
                    <div hx-swap-oob='true' id='name_message'></div>
                <div hx-swap-oob='true' id='description_message'></div>
                <div hx-swap-oob='true' id='price_message'></div>
                <div hx-swap-oob='true' id='quantity_message'></div>
                <div hx-swap-oob='true' id='message' class='bg-green-200 text-center m-2 rounded'>Product Successfully Added! </div>";
               
                
            }
                 if ($product) {
                return $html;
            }
            


        } catch (\Exception $e) {
            $products = Product::orderBy('id');

            $html = "";

            foreach ($products->get() as $prod) {
                $html .= "
                <div class='p-4 rounded bg-blue-200 flex items-center'>

                <div class='w-6/4 pl-4'>
                    <h2 class='text-xl font-bold'>Name: {$prod->name}</h2>
                    <p>Description: {$prod->description}</p>
                    <p class='text-green-500 font-semibold'>Price: ₱{$prod->price}</p>
                    <p class='text-green-500 font-semibold'>Quantity: {$prod->quantity}</p>
                    <div class='m-2'>
                    
                    <button class='btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300'>Update</button>
                    
                    <button onclick='confirmDeleteModal()' class='bg-red-500 text-white font-bold py-2 px-4 rounded'>
            Delete Item
        </button>
        </div>
                </div>
                </div>
    
    
            </a>
    
            <div id='confirmationModal' class='hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center'>
            <div class='bg-white p-6 rounded-lg shadow-lg text-center relative'>
                <p class='mb-4'>Are you sure you want to delete this item?</p>
                <div class='flex justify-center'>
                <button 
                hx-delete='api/delete/". $prod->id."'
                hx-swap='innerHTML'
                hx-target='#products-list'
                hx-trigger='click'
                class='btn bg-green-500 text-white mr-2 px-4 py-2 rounded hover:bg-green-700 transition duration-300'>Yes</button>
                    
                <button onclick='cancelDelete()' class='bg-red-500 text-white font-bold py-2 px-4 hover:bg-red-700 rounded'>Cancel</button>
                </div>
            </div>
        </div>
                ";
            }

            $errorMessages = [
                'name' => '',
                'description' => '',
                'price' => '',
                'quantity' => '',
            ];

            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $errors = $e->validator->errors();

                if ($errors->has('name')) {
                    $errorMessages['name'] = '<div hx-swap-oob="true" id="name_message" class="italic text-left text-red-500 text-sm">' . $errors->first('name') . '</div>';
                }else{

                    $errorMessages['name'] = '<div hx-swap-oob="true" id="name_message"></div>';

                }

                if ($errors->has('description')) {
                    $errorMessages['description'] = '<div hx-swap-oob="true" id="description_message" class="italic text-left text-red-500 text-sm">' . $errors->first('description') . '</div>';
                }else{

                    $errorMessages['description'] = '<div hx-swap-oob="true" id="description_message" ></div>';

                }

                if ($errors->has('price')) {
                    $errorMessages['price'] = '<div hx-swap-oob="true" id="price_message" class="italic text-left text-red-500 text-sm">' . $errors->first('price') . '</div>';
                }else{

                    $errorMessages['price'] = '<div hx-swap-oob="true" id="price_message"></div>';

                }

                if ($errors->has('quantity')) {
                    $errorMessages['quantity'] = '<div hx-swap-oob="true" id="quantity_message" class="italic text-left text-red-500 text-sm">' . $errors->first('quantity') . '</div>';
                }else{

                    $errorMessages['quantity'] = '<div hx-swap-oob="true" id="quantity_message"></div>';

                }


            }



            elseif ($e instanceof \Exception) {
                return "
                <div hx-swap-oob='true' id='general-error-message' class='bg-red-200 text-center m-2 rounded'>" . $e->getMessage() . "</div>";
            }


            $errorMessageHTML = '';
            foreach ($errorMessages as $errorMessage) {
                $errorMessageHTML .= $errorMessage;
            }

            return $html . $errorMessageHTML;
        }
    }


    public function open() {
        $html = '';

        $html .= '<div class="modal-header flex justify-between items-center border-b pb-2">
            <h4 class="text-xl">Create Product</h4>
        </div>
        <div class="modal-body my-4">
            <form id="modalForm" hx-post="api/create-product" hx-target="#products-list" hx-swap="innerHTML">

            <div class="form-group">
                    <label for="name" class="block mt-2">Name:</label>
                    <input type="text" id="name" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product name" name="name">
                </div>

                <div id="name_message">
                </div>

                <div class="form-group">
                    <label for="description" class="block mt-2">Description:</label>
                    <input type="text" id="description" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product description" name="description">
                </div>

                <div id="description_message">
                </div>

                <div class="form-group">
                    <label for="price" class="block mt-2">Price:</label>
                    <input type="text" id="price" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product price" name="price">
                </div>

                <div id="price_message">
                </div>

                <div class="form-group">
                    <label for="quantity" class="block mt-2">Quantity:</label>
                    <input type="text" id="quantity" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product quantity" name="quantity">
                </div>

                <div id="quantity_message">
                </div>
                <div id="message">
                </div>



                <div class="flex justify-between items-center">

                    <button type="submit" id="modalSubmitButton" class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300 mt-3">Save Product</button>
                    <div class="float-right my-0">

                    <button type="button" id="modalSubmitButton" onclick="closeModal()" class="btn bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300 mt-3">Close</button>
                   </div>
                </form>

                </div>

               
        </div>';

        return $html;
    }



public function close() {
    $html = '';

    $html .= '<button type="button" id="modalSubmitButton" onclick="closeModal()" class="btn bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 transition duration-300">Close</button>';

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


    public function delete($id)
    {
        $product = Product::find($id);
        
        if ($product) {
            $product->delete();
    
            
            $products = Product::all(); 

            $html = '';
    
            foreach ($products as $prod) {
                $html .= "
                <div class='p-4 rounded bg-blue-200 flex items-center'>

                <div class='w-6/4 pl-4'>
                    <h2 class='text-xl font-bold'>Name: {$prod->name}</h2>
                    <p>Description: {$prod->description}</p>
                    <p class='text-green-500 font-semibold'>Price: ₱{$prod->price}</p>
                    <p class='text-green-500 font-semibold'>Quantity: {$prod->quantity}</p>
                    <div class='m-2'>
                    
                    <button class='btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300'>Update</button>
                    
                    <button onclick='confirmDeleteModal()' class='bg-red-500 text-white font-bold py-2 px-4 rounded'>
            Delete Item
        </button>
        </div>
                </div>
                </div>
    
    
            </a>
    
            <div id='confirmationModal' class='hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center'>
            <div class='bg-white p-6 rounded-lg shadow-lg text-center relative'>
                <p class='mb-4'>Are you sure you want to delete this item?</p>
                <div class='flex justify-center'>
                <button 
                hx-delete='api/delete/". $prod->id."'
                hx-swap='innerHTML'
                hx-target='#products-list'
                hx-trigger='click'
                class='btn bg-green-500 text-white mr-2 px-4 py-2 rounded hover:bg-green-700 transition duration-300'>Yes</button>
                    
                <button onclick='cancelDelete()' class='bg-red-500 text-white font-bold py-2 px-4 hover:bg-red-700 rounded'>Cancel</button>
                </div>
            </div>
        </div>
                    
                    ";
            }
    
            return $html;
        } else {
            return response('Product not found.', 404);
        }
    }


    
}
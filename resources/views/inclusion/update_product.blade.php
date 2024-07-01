
<div id="updateModal" class="modal fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
<div class="modal-content bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
<h1 class="text-xl">Update Product</h1>

<form class="mt-6" hx-put="/api/update/{{$product->id}}"
                hx-trigger="submit"
                hx-target="#products-list"
                hx-swap="innerHTML"
                
                method="PUT">
                @csrf
                @method('PUT') <div class="form-group">
            <input type="hidden" value="{{$product->id}}" id="id" name="id" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product name">
        </div>
        <div id="result-message">
            
        </div>
       
        <div class="form-group">
            <label for="name" class="block mt-2 float-left">Name:</label>
            <input type="text" value="{{$product->name}}" id="name" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product name" name="name">
        </div>
        <div id="name_message">
        </div>

        <div class="form-group">
            <label for="description" class="block mt-2 float-left">Description:</label>
            <input type="text" value="{{$product->description}}" id="description" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product description" name="description">
        </div>

        <div id="description_message">
                </div>

        <div class="form-group">
            <label for="price" class="block mt-2 float-left">Price:</label>
            <input type="text" value="{{$product->price}}" id="price" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product price" name="price">
        </div>
        
        <div id="price_message">
        </div>

        <div class="form-group">
            <label for="quantity" class="block mt-2 float-left">Quantity:</label>
            <input type="text" value="{{$product->quantity}}" id="quantity" class="w-full p-2 border border-gray-300 rounded" placeholder="Enter product quantity" name="quantity">
        </div>

        <div id="quantity_message">
                </div>
                <div id="update_message">
                </div>

        <div class="m-2">
            <button class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">Update</button>
            <button type="button" onclick="closeUpdateModal()" class="bg-red-500 float-right text-white font-bold py-2 px-4 rounded hover:bg-red-700 transition duration-300">Close</button>
        </div>
        </form>
    </div>
</div>



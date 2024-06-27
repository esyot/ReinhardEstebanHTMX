@foreach ($products as $prod)
    <div class='p-4 rounded bg-blue-200 flex items-center'>
        <div class='w-3/45 pl-4'>
            <h2 class='text-xl font-bold'>Name: {{ $prod->name }}</h2>
            <p>Description: {{ $prod->description }}</p>
            <p class='text-green-500 font-semibold'>Price: ₱{{ $prod->price }}</p>
            <p class='text-green-500 font-semibold'>Quantity: {{ $prod->quantity }}</p>
        </div>
    </div>
    <div hx-swap-oob='true' id='name_message'></div>
    <div hx-swap-oob='true' id='description_message'></div>
    <div hx-swap-oob='true' id='price_message'></div>
    <div hx-swap-oob='true' id='quantity_message'></div>
    <div hx-swap-oob='true' id='message' class='bg-green-200 text-center m-2 rounded'>Product Successfully Added!</div>
@endforeach

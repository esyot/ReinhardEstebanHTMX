@extends('templates.base')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Contact Us</h1>
        <p class="mb-4">If you have any questions or feedback, please feel free to reach out to us using the form below.</p>
        
        <form>
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" name="name" class="mt-1 block w-full px-4 py-2 border rounded-lg" required>
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" class="mt-1 block w-full px-4 py-2 border rounded-lg" required>
            </div>
            
            <div class="mb-4">
                <label for="message" class="block text-gray-700">Message</label>
                <textarea id="message" name="message" class="mt-1 block w-full px-4 py-2 border rounded-lg" rows="4" required></textarea>
            </div>
            
            <div>
                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg">Send Message</button>
            </div>
        </form>
    </div>
</div>
@endsection

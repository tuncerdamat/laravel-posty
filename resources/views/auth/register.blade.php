@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-4/12 bg-white p-6 rounded-lg">
            <form action="{{ route('register') }}" method="post">
                <div class="mb-4">
                    <label for="name" class="sr-only">Name</label>
                    <input type="text" name="name" id="name" placeholder="Your name" 
                           class="bg-gray-100 border-2 w-full p-4 rounded-lg" value=""
                    >
                </div>
            </form>
        </div>
    </div>
@endsection

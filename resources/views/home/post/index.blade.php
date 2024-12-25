<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span class='text-sm'>My Posts</span>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col items-center">
                <div class='flex flex-col space-y-2 my-2'>
                    <div class="py-4 text-gray-900">
                          <a href="{{ route('posts.create') }}" class='p-2 bg-blue-500 text-white font-bold rounded cursor-pointer'>Hi {{ explode(' ', Auth::user()->name)[0] }}! Share something</a>
                    </div>
                    @foreach ($posts as $post)
                        <x-post-card :post='$post' :comments='$post->comments'/>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

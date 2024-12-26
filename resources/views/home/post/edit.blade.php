<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <span class='text-sm'>Hi, {{ Auth::user()->name }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form action='{{ route('posts.update', $post->id) }}' method='POST' enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="p-6 text-gray-900 flex flex-col space-y-2">
                        <x-input-label>Update your post</x-input-label>
                        {{-- Content --}}
                        <textarea name='content' class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>{{ $post->content}}</textarea>
                        <x-input-error :messages="$errors->get('content')"/>


                        {{-- Image --}}
                        <x-text-input name='image' type='file' accept="jpeg,png,gif,jpg"/>
                        <x-input-error :messages="$errors->get('image')"/>

                        <button class='bg-gray-800 p-2 w-fit px-4 rounded text-white'><i class="fas fa-paper-plane"></i> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

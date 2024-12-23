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
                        <a href="{{ route('posts.create') }}" class='p-2 bg-blue-400 text-white rounded cursor-pointer'>Share your thoughts?</a>
                    </div>
                    @foreach ($posts as $post)
                    <div class='border border-gray-400 p-2'>
                        <div class='flex flex-row space-x-2 items-center'>
                            <img src="https://placehold.co/50x50" class='rounded-full'>
                            <span class='block mb-2'>{{ $post->user->name }}</span>
                        </div>
                        <div class='flex flex-col '>
                            <span class='text-sm text-gray-600'> {{ $post->created_at->diffInMinutes() < 1 ? 'Just now': $post->created_at->diffForHumans() }}</span>
                            <span>{{ $post->content }}</span>
                        </div>
                        <img class='p-2 w-[300px] h-[350px] object-contain bg-gray-50' src="{{ asset(Storage::url($post->image)) }}">

                        <div class="flex flex-row justify-between space-x-2 p-2">
                            {{--  Like  --}}
                            <form action='{{ route('like') }}' method='POST'>
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">

                                @if ($post->usersWhoLiked->contains(Auth::user()->id))
                                <button><i class="fas fa-heart"></i> {{ $post->usersWhoLiked()->count()  }}</button>
                                @else
                                <button><i class="far fa-heart"></i></button>
                                @endif

                            </form>
                            <span class='cursor-pointer'><a href="{{ route('posts.show', $post->id) }}"><i class="far fa-comment"></i></a></span>
                            <span>Share</span>
                        </div>

                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

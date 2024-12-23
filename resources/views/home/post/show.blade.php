<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('posts.index') }}" class='text-sm'>My Posts</a>
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col items-center">
                <div class='flex flex-col space-y-2 my-2'>
                 <div class='border border-gray-400 p-2'>
                    <div class='flex flex-row space-x-2 items-center'>
                        <img src="https://placehold.co/50x50" class='rounded-full'>
                        <span class='block mb-2'>{{ $post->user->name }}</span>
                    </div>
                    <div class='flex flex-col '>
                        <span class='text-[14px] text-gray-500'>{{ $post->created_at->diffForHumans() }}</span>
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
                        <span class='cursor-pointer'><a><i class="far fa-comment"></i></a></span>
                        <span>Share</span>
                    </div>

                    {{-- Comment Section --}}
                    <div>
                        <form action='{{ route('comments.store') }}' method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <label for='comment'>Write a comment</label>
                            <div class='flex flex-row items-center space-x-2'>
                                <textarea id='comment' name='content' class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full'></textarea>
                                <button type='submit' class='bg-blue-400 p-2 w-fit px-4 rounded text-white'><i class="fas fa-paper-plane"></i> </button>
                            </div>

                            <span class='text-gray-500 text-sm'>Total comments: {{ $comments->count() }}</span>

                        </form>

                        {{-- {{ dd($comments) }} --}}
                        @foreach ($comments as $comment)
                            <div class='flex flex-col border p-2 mt-4'>
                                <div class='flex flex-row space-x-2 items-center'>
                                    <span class='text-sm text-gray-800'>{{ $comment->user->name }}</span>
                                    <span class='text-sm text-gray-600'> {{ $comment->created_at->diffInMinutes() < 1 ? 'Just now': $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <hr>
                                <p class='text-gray-800'>{{ $comment->content }}</p>
                            </div>

                        @endforeach

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
</x-app-layout>

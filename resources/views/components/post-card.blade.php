@props([
    'post' => null
])
@if ($post)
<div class='shadow-sm  p-2'>
    <div class='flex flex-row space-x-4'>
        <img src="{{ Storage::url($post->user->image) }}" class='rounded-full w-[50px] object-cover'>
        <div class='flex flex-col'>
        <span class='block'>{{ $post->user->name }}</span>
        <span class='text-sm text-gray-500'> {{ $post->created_at->diffInMinutes() < 1 ? 'Just now': $post->created_at->diffForHumans() }}</span>
            
        </div>
    </div>
    <div class='flex flex-col my-2 '>
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
            <button><i class="far fa-heart"></i> {{ $post->usersWhoLiked()->count()  }}</button>
            @endif

        </form>
        <span class='cursor-pointer'><a href="{{ route('posts.show', $post->id) }}"><i class="far fa-comment"></i></a></span>
        <span>Share</span>
    </div>

</div>
@endif
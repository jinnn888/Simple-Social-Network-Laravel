<div class="flex flex-row justify-between md:justify-start space-x-4 p-2">
    {{-- Like --}}
    <form action='{{ route('like') }}' method='POST'>
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        @if ($post->usersWhoLiked->contains(Auth::user()->id))
        <button><i class="fas fa-heart"></i> {{ $post->usersWhoLiked()->count() }}</button>
        @else
        <button><i class="far fa-heart"></i> {{ $post->usersWhoLiked()->count() }}</button>
        @endif
    </form>
    {{-- Comment button --}}
    <span class='cursor-pointer comment_toggler' data-post-id='{{ $post->id }}'>
        <i class="far fa-comment"></i>
        <span>{{ $comments->count() }}</span>
    </span>
    {{-- Share button --}}
    <span>Share</span>
</div>
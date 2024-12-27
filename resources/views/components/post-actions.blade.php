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
        {{-- <span class='comment-count'>{{ $comments->count() }}</span> --}}
        <span class='comment-count-{{ $post->id }}'></span>
    </span>
    {{-- Share button --}}
    <span>Share</span>
</div>

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            url: '{{ route('comments.fetch', $post->id) }}',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('.comment-count-{{ $post->id }}').html(`${response.length}`);
            },
        })
    })

</script>

@endpush
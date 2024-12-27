@props([
'post' => null,
'comments' => null,
])
{{-- {{ dd(auth()->user()->followers); }} --}}
@if ($post)
<div class='shadow-sm w-full p-2'>
    <div class='flex flex-row space-x-4'>
        <img src="{{ Storage::url($post->user->image) }}" class='rounded-full overflow-hidden w-[50px] h-[50px] object-cover'>
        <div class='flex flex-col'>
            <span class='block flex flex-row gap-2 items-center'>
                <a href="{{ route('users.profile', $post->user->id) }}" class='hover:underline'>
                    {{ $post->user->name }}
                </a>
                @if (auth()->user()->followings->contains($post->user->id))
                    <span class='text-gray-500 text-sm'>following</span>
                @endif
                @cannot('update', $post)
                    @if (!auth()->user()->followings->contains($post->user->id))
                        <form action='{{ route('follow', $post->user->id) }}' method='POST'>
                            @csrf
                            <button class='ml-2 text-gray-600 text-sm'>Follow</button>
                        </form>
                    @endif
                @endcannot
                @can('update', $post)
                    <a href='{{ route('posts.edit', $post->id) }}' class='text-gray-400 text-sm'>
                        <i class="fas fa-pencil"></i>
                    </a>
                    <form onsubmit='return confirm("Are you sure you want to delete?")' action='{{ route('posts.destroy', $post->id) }}' method='POST'>
                        @csrf
                        @method('DELETE')
                        <button type='submit' class='text-red-400 text-sm'>
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                @endcan
            </span>
            <span class='text-sm text-gray-500'> {{ $post->created_at->diffInMinutes() < 1 ? 'Just now' : $post->created_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class='flex flex-col my-2'>
        <span>{{ $post->content }}</span>
    </div>
    
    @if ($post->image)
        <img class='w-[500px] h-[350px] object-contain bg-gray-100' src="{{ asset(Storage::url($post->image)) }}">
    @endif

    {{-- Like, Comment, Share --}}
    <x-post-actions :post="$post" :comments="$comments" toggler_class='toggle-comment' data-post-id="{{ $post->id }}"/>

    {{-- Comment Box Component --}}
    <x-comment-box :post="$post" :comments="$comments" />
</div>
@endif

@push('scripts')

<script type="text/javascript">
$(document).ready(function() {
    $('.toggle-comment').on('click', function() {
        console.log('Hello, world')

        const postId = $(this).data('post-id');
        const commentBox = $(`#comment-modal-${postId}`);

        $(`#comment-modal-${postId}`).fadeIn();

        $(`#close-modal-${postId}`).on('click', function() {
            $(`#comment-modal-${postId}`).fadeOut();
        })

    })

})

</script>
@endpush

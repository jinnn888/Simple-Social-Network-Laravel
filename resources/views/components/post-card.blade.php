@props([
    'post' => null,
    'comments' => null,
    ])
    {{-- {{ dd(auth()->user()->followers); }} --}}
    @if ($post)
    <div class='shadow-sm  w-full p-2'>
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
                    @cannot('update',   $post)
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
                        <span class='text-red-400 text-sm'>
                            <i class="fas fa-trash"></i>
                        </span>
                    @endcan
                </span>
                <span class='text-sm text-gray-500'> {{ $post->created_at->diffInMinutes() < 1 ? 'Just now': $post->created_at->diffForHumans() }}</span>

            </div>
        </div>
        <div class='flex flex-col my-2 '>
            <span>{{ $post->content }}</span>
        </div>
        @if ($post->image)
            <img class=' w-[500px] h-[350px] object-contain bg-gray-100' src="{{ asset(Storage::url($post->image)) }}">
        @endif

        <div class="flex flex-row justify-between md:justify-start space-x-4 p-2">
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
            {{-- href="{{ route('posts.show', $post->id) }}" --}}
            <span class='cursor-pointer toggle-comment' data-post-id='{{ $post->id }}'>
                <i  class="far  fa-comment" ></i>
                <span>{{ $comments->count() }}</span>

            </span>

            {{-- Share button --}}
            <span>Share</span>
        </div>
        {{-- Comment Modal --}}
        <div id="comment-modal-{{ $post->id }}" style='display: none' class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" >
          <div class="relative w-10/12   bg-white rounded-lg shadow-lg">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-4 py-2 border-b">
              <h2 class="text-lg font-semibold text-gray-800">Comment Section</h2>
              <button id="close-modal-{{$post->id}}" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
          </button>
      </div>

      <!-- Modal Content -->
      <div class="px-4 py-4 max-h-80 overflow-y-auto" >
        {{-- Comment Box --}}
        <div >
            <form action='{{ route('comments.store') }}' method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <label for='comment'>Write a comment</label>
                <div class='flex flex-row items-center space-x-2'>
                    <textarea id='comment' name='content' class='border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full'></textarea>
                    <button type='submit' class='bg-gray-900 p-2 w-fit px-4 rounded text-white'><i class="fas fa-paper-plane"></i> </button>
                </div>

                <span class='text-gray-500 text-sm'>Total comments: {{ $comments->count() }}</span>

            </form>

            {{-- {{ dd($comments) }} --}}
            @foreach ($comments as $comment)
            <div class='flex flex-col border p-2 mt-4'>
                <div class='flex flex-row space-x-2 items-center'>
                    <span class='text-gray-800 flex flex-row items-center gap-2 mb-2'>
                        <a href='{{ route('users.profile', $comment->user->id) }}'>
                        <img class='w-[50px] object-cover bg-gray-100' src="{{ asset(Storage::url($comment->user->image)) }}"> 
                        </a>
                        {{ $comment->user->name }}
                    </span>
                    <span class='text-sm text-gray-600'> {{ $comment->created_at->diffInMinutes() < 1 ? 'Just now': $comment->created_at->diffForHumans() }}</span>
                </div>
                {{-- <hr> --}}
                <p class='text-gray-800'>{{ $comment->content }}</p>
            </div>

            @endforeach

        </div>
    </div>

{{-- <!-- Modal Footer -->
<div class="flex justify-end px-4 py-2 border-t">
  <button id="close-modal-footer" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
    Close
</button>
</div> --}}
</div>
</div>

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
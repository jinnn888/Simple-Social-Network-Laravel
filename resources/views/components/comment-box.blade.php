{{-- Comment Modal --}}
<div id="comment-modal-{{ $post->id }}" style="display: none" {{ $attributes->merge(['class' => 'fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50']) }}>
    <div class="relative w-10/12 bg-white rounded-lg shadow-lg">
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
        <div class="px-4 py-4 max-h-80 overflow-y-auto">
            {{-- Comment Box --}}
            <form id='comment-form-{{ $post->id }}' data-post-id='{{ $post->id }}'>
                {{-- @csrf --}}
                <input type="hidden" id="post_id" value="{{ $post->id }}">
                <label for="comment" class="block text-sm font-medium text-gray-700">Write a comment</label>
                <div class="flex flex-row items-center space-x-2 mt-2">
                    <textarea id="content-{{ $post->id }}"  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" rows="3"></textarea>
                    <button type="submit" class="bg-gray-900 p-2 w-fit px-4 rounded text-white">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>

                <span class="text-gray-500 text-sm mt-2">Total comments: {{ $comments->count() }}</span>
            </form>

            {{-- Comments List --}}
            <div class='comment-box-{{ $post->id }}'>
                
            </div>
            {{-- @foreach ($comments as $comment)
                <div class="flex flex-col border p-2 mt-4">
                    <div class="flex flex-row space-x-2 items-center">
                        <a href="{{ route('users.profile', $comment->user->id) }}">
                            <img class="w-[50px] object-cover bg-gray-100 " src="{{ asset(Storage::url($comment->user->image)) }}">
                        </a>
                        <span class="text-gray-800 flex flex-row items-center gap-2 mb-2">
                            {{ $comment->user->name }}
                            <span class="text-sm text-gray-600">{{ $comment->created_at->diffInMinutes() < 1 ? 'Just now' : $comment->created_at->diffForHumans() }}</span>
                        </span>
                    </div>
                    <p class="text-gray-800">{{ $comment->content }}</p>
                </div>
            @endforeach --}}
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}"}
            })

            const target = $('#comment-modal-{{ $post->id }}')[0];
            let isModalVisible = false;
            if (target) {
                const observer = new MutationObserver((mutations) => {
                    mutations.forEach((mutation) => {
                        const isCurrentlyVisible = getComputedStyle(target).display !== 'none';
                        if (isCurrentlyVisible && !isModalVisible) {
                            isModalVisible = true; // Update state
                            fetchComments('{{ $post->id }}'); // Fetch comments when modal becomes visible
                        } else if (!isCurrentlyVisible) {
                            isModalVisible = false; // Reset state when modal is hidden
                        }
                    });
                });

                observer.observe(target, { attributes: true, attributeFilter: ['style'] });
            } else {
                console.error('Target element not found.');
            }

            function fetchComments(postId) {
                $.ajax({
                    url: '{{ route('comments.fetch', ':id' ) }}'.replace(':id', postId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(response){
                        $(`.comment-box-{{ $post->id }}`).empty();
                        console.log(response)
                        $.each(response, function(key, comment) {
                            console.log(key, comment)
                            $(`.comment-box-{{ $post->id }}`).append(`
                                <div class="flex flex-col border p-2 mt-4">
                    <div class="flex flex-row space-x-2 items-center">
                        <a href="/user/profile/${comment.user.id}">
                            <img class="w-[50px] object-cover bg-gray-100 " src="/storage/${comment.user.image}">
                        </a>
                        <span class="text-gray-800 flex flex-row items-center gap-2 mb-2">
                            ${comment.user.name}
                           
                        </div>
                        <p class="text-gray-800">${comment.content}</p>
                    </div>

                            `)
                        })
                    },
                    error: function(xhr, status, error){
                        console.log(xhr.responseJSON, status, error)
                        console.log('something went wrong.')
                    }   
                })
            }

            $('#comment-form-{{ $post->id }}').on('submit', function(e) {
                e.preventDefault()
                console.log($(this).data('post-id'))
                const postId = $('#comment-form-{{ $post->id }}').data('post-id')
                // const content = $(`#content-${postId}`);

                const content = $(`#content-${postId}`).val();
                console.log(postId, content)
                $.ajax({
                    url: '{{ route('comments.store') }}',
                    type: 'POST',
                    data: {
                        post_id: postId,
                        content: content
                    },
                    success: function(response) {
                        fetchComments(postId);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseJSON)
                        console.log(status)
                    }
                })

            })


        })
    </script>

@endpush
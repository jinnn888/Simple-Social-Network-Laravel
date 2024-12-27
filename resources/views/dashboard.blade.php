<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col items-center">
                <div class="flex flex-col space-y-2 my-2 w-full p-4">
                    <!-- Post Creation Button -->
                    <div class="p-2 cursor-pointer border rounded-lg toggle-post w-full">
                        <span class="text-gray-500 text-sm font-bold">何を考えていますか？</span>
                    </div>
                    <!-- Posts Container -->
                    <div class="post-container">
                        @foreach ($posts as $post)
                        <x-post-card :post="$post" :comments="$post->comments" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal for creating post --}}
        <div id="post-modal" style="display: none" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="relative w-10/12 bg-white rounded-lg shadow-lg">
                <!-- Modal Header -->
                <div class="flex items-center justify-between px-4 py-2 border-b">
                    <x-input-label>何を投稿しますか？</x-input-label>
                    <button id="close-modal" class="text-gray-500 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Modal Content -->
                <div class="px-4 py-2 max-h-80 overflow-y-auto">
                    {{-- Post Form --}}
                    <form id='create-post-form' action='{{ route("posts.store") }}' enctype="multipart/form-data" method='POST'>
                        @csrf 
                        <div class="p-6 text-gray-900 flex flex-col space-y-2">

                            <!-- Content -->
                            <textarea name="content" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                            <div class="content-error"></div>

                            <!-- Image -->
                            <x-text-input name="image" type="file" accept="jpeg,png,gif,jpg" />
                             <div class="image-error"></div>

                            <button id='submit-btn'class="bg-gray-800 p-2 w-fit px-4 rounded text-white">
                                <i class="fas fa-paper-plane block"></i>
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')

    <script type="text/javascript">
    $(document).ready(function() {
        // $.ajaxSetup({
        //     headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        // })

        $('.toggle-post').on('click', function() {
            const postModal = $(`#post-modal`);

            postModal.fadeIn();

            $(`#close-modal`).on('click', function() {
                postModal.fadeOut();
            })

        })
    })
    

    </script>
    @endpush
</x-app-layout>

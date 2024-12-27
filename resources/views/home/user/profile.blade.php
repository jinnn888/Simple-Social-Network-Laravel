<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col items-center">
                <div class='p-12 flex  items-center w-full flex-col gap-2'>
                    <img src="{{ asset(Storage::url($user->image)) }}" class='w-[250px]'>

                    <span class='font-bold text-2xl'>{{ $user->name }}</span>
                    <span class='text-md'>{{ $user->email }}</span>

                    {{-- Followers/Following/Post Count --}}
                    <div class='flex flex-row gap-2 text-xl'>
                        <span>Followers {{ $user->followers()->count() }} |</span>
                        <span>Following {{ $user->followings()->count() }} |</span>
                        <span>Posts {{ $user->posts()->count() }}</span>
                    </div>

                    <div class='w-full shadow-sm'>
                        @foreach ($posts as $post)
                        <x-post-card :post='$post' :comments='$post->comments' />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

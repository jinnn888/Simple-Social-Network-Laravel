<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col items-center">
                <h2 class='mt-2 font-bold text-2xl'>People</h2>
                <hr class='bg-gray-900 my-2'>
                <div class='flex flex-wrap space-x-2'>
                    @if ($users->count() > 0)
                    @foreach ($users as $user)
                    <div class='flex flex-col space-y-2 rounded border'>
                        <img src="{{ Storage::url($user->image) }}" class='w-[220px]  object-cover'>
                        <span class='text-lg font-semibold p-2'>{{ $user->name }}</span>
                        <div class='w-full flex flex-col items-center mt-4'>
                            @if (auth()->user()->following->contains($user->id))
                            <form action='{{ route('unfollow', $user->id) }}' method='POST'>
                                @csrf
                                <button type='submit' class='p-2 border border-gray-800 text-gray-800 font-semibold rounded w-full my-2'>Unfollow</button>
                            </form>
                            @else
                            <form action='{{ route('follow', $user->id) }}' method='POST'>
                                @csrf
                                <button type='submit' class='p-2 bg-gray-800 text-white font-semibold rounded w-full my-2'>Follow</button>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @else
                    <span class='text-gray-600'>No people  to display.</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

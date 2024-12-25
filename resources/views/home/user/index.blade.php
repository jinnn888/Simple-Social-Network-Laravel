<x-app-layout>
   <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col items-center">
                <h2 class='mt-2 font-bold text-2xl'>People</h2>
                <hr class='bg-gray-900 my-2'>
                <div class='my-4'>
                    @foreach ($users as $user)
                        <div class='flex flex-col space-y-2 rounded border p-2'>
                            <img src="{{ Storage::url($user->image) }}" class='w-[250px] h-[250px] object-cover'>
                            <span class='text-lg font-semibold'>{{ $user->name }}</span>

                            <div class='w-full flex flex-col items-center mt-4'>
                                <button class='p-2 bg-gray-800 text-white font-semibold rounded w-full'>Follow</button>
                            </div>

                        </div>


                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

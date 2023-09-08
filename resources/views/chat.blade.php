<x-app-layout>
    <div class="bg-gray-100 flex flex-col">
        <h2 class="text-center font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}: {{ $user->name }} @if ($user->id == auth()->id())
                <b class="text-green-500">({{ __('You') }})</b>
            @endif
        </h2>

        <!-- Chat Messages -->
        <div class="h-[70vh] md:h-[80vh] p-4 overflow-y-auto">
            <div class="flex flex-col space-y-2">
                @foreach (auth()->user()->chat($user) as $msg)
                    <div class="flex justify-start @if ($msg->user_id == auth()->id()) flex-row-reverse @endif space-x-2">
                        <img src="{{ $msg->sender->profile_photo_url }}" alt="User Avatar" class="w-8 h-8 rounded-full">
                        <div class="grid bg-white rounded-lg p-2">
                            @if ($msg->attachment)
                                @if ($msg->attachment_type === 'image')
                                    <!-- Display image -->
                                    <img src="{{ asset('storage/' . $msg->attachment) }}" alt="Attachment" class="max-w-xs max-h-24 md:max-h-48 lg:max-h-60 rounded-lg">
                                @elseif ($msg->attachment_type === 'video')
                                    <!-- Display video -->
                                    <video controls class="max-w-xs max-h-24 md:max-h-48 lg:max-h-60 rounded-lg">
                                        <source src="{{ asset('storage/' . $msg->attachment) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif ($msg->attachment_type === 'document')
                                    <!-- Display document link -->
                                    <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank"
                                        class="text-blue-500 hover:underline">{{ __('View Document') }}</a>
                                @else
                                    <!-- Display other attachment (default) -->
                                    <a href="{{ asset('storage/' . $msg->attachment) }}" target="_blank"
                                        class="text-blue-500 hover:underline">{{ __('View Attachment') }}</a>
                                @endif
                            @endif
                            <p class="text-sm">{{ $msg->message }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>


        <!-- User Input -->
        <div class="bg-white p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('chat.store', $user->id) }}" method="post" class="flex items-center space-x-4"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="recipient_id" value="{{ $user->id }}">
                <input type="text" placeholder="Type your message" name="message"
                    class="w-full rounded-full border-gray-300 px-4 py-2 focus:outline-none focus:ring focus:border-blue-500">
                <input type="file" name="file" accept="image/*,video/*,application/pdf"
                    class="rounded-full border-gray-300 px-4 py-2 focus:outline-none focus:ring focus:border-blue-500">
                <button class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600">Send</button>
            </form>
        </div>
    </div>
</x-app-layout>

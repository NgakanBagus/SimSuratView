<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    {{-- Button to create a new message --}}
    <a href="/create-message" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">New</a>

    {{-- List of messages --}}
    <ul role="list" class="divide-y divide-gray-100 mx-auto max-w-7xl py-6 sm:px-6 lg:px-8"
        x-data="{ deleteMenu: false, messageId: '', messageTitle: '' }">
        @foreach ($sender_name as $message)
            <div class="border-b border-gray-200">
                <li class="flex gap-x-6 py-5">
                    {{-- Message details --}}
                    <div class="flex min-w-0 gap-x-4 mr-auto">
                        <a href="/message/{{ $message->id }}" class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{{ $message->title }}</p>
                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ Str::limit($message->sender_name, 50) }}</p>
                        </a>
                    </div>

                    {{-- Updated and created dates --}}
                    <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                        <p class="text-sm leading-6 text-gray-900">{{ $message->created_at->format('j F Y') }}</p>
                        <p class="mt-1 text-xs leading-5 text-gray-500">Updated {{ $message->updated_at->diffForHumans() }}</p>
                    </div>

                    {{-- Action buttons --}}
                    <div class="flex items-center text-sm leading-6">
                        {{-- Edit message button --}}
                        <a href="/edit-message/{{ $message->id }}"
                            class="rounded-md font-semibold px-3 py-2 mr-2 bg-indigo-600 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Edit</a>

                        {{-- Disposisi surat button --}}
                        <a href="/pdf/{{ $message->id }}/disposisi/create"
                            class="rounded-md font-semibold px-3 py-2 mr-2 bg-green-600 text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">Disposisi
                            Surat</a>

                        {{-- Status of the message --}}
                        <span class="px-3 py-1 inline-flex items-center rounded-full text-xs leading-4 font-semibold {{ $message->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($message->status === 'processed' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                            {{ ucfirst($message->status) }}
                        </span>

                        {{-- Delete button --}}
                        <button @click.prevent="deleteMenu = true; messageId = {{ $message->id }}; messageTitle = '{{ $message->title }}'; configureDeleteForm(messageId, messageTitle);"
                            class="rounded-md font-semibold px-3 py-2 ml-2 text-gray-900 hover:bg-gray-100">Delete</button>
                    </div>
                </li>
            </div>
        @endforeach

        {{-- Delete confirmation modal --}}
        <div x-cloak x-show="deleteMenu" class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-xl font-semibold leading-6 text-gray-900" id="delete-message-title">Delete
                                    message?</h3>
                            </div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('message.delete') }}"
                        class="hidden bg-gray-50 px-4 py-3 my-5 sm:flex sm:flex-row-reverse sm:px-6">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" id="delete-message-id">
                        <button type="submit"
                            @click="deleteMenu = false; messageId = ''; messageTitle = ''"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Delete</button>
                        <button @click.prevent="deleteMenu = false; messageId = ''; messageTitle = ''"
                            class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </ul>

    <script>
        function configureDeleteForm(messageId, messageTitle) {
            const deleteMessageId = document.getElementById('delete-message-id');
            const deleteMessageTitle = document.getElementById('delete-message-title');

            deleteMessageId.setAttribute('value', messageId);
            deleteMessageTitle.innerHTML = 'Delete \'' + messageTitle + '\' ?';
        }
    </script>
</x-layout>

<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>

  <message class="py-8 max-w-screen-md">
    <div class="text-base text-gray-500">
      <h3 class="font-bold text-xl text-gray-900">{{ $message->title }}</h3>
      {{ $message->created_at->format('j F Y') }}
    </div>
    <p class="my-4 font-light">
      {{ $message->body }}
    </p>
    <a href="/" class="text-medium text-blue-500 hover:underline">Go Back &laquo;</a>
  </message>
</x-layout>
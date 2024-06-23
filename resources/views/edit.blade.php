<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>
  <form method="POST" action="{{ route('message.update', $sender_name->id) }}" id="updateForm" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="space-y-12">
      <div class="border-b border-gray-900/10 pb-12">
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-4">
            <label for="title" class="block text-sm font-medium leading-6 text-gray-900">Title</label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input type="text" name="title" id="title" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="{{ $sender_name->title }}" required>
              </div>
            </div>
          </div>
        
          <div class="sm:col-span-4">
            <label for="sender_name" class="block text-sm font-medium leading-6 text-gray-900">Sender Name</label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input type="text" name="sender_name" id="sender_name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" value="{{ $sender_name->sender_name }}" required>
              </div>
            </div>
          </div>

          <div class="col-span-full">
            <label for="pdf" class="block text-sm font-medium leading-6 text-gray-900">Upload Surat</label>
            <div class="mt-2">
              <input type="file" name="pdf" id="pdf" class="block w-full text-gray-900" accept="application/pdf">
              @if ($sender_name->pdf_path && Storage::disk('public')->exists($sender_name->pdf_path))
                <a href="{{ Storage::url($sender_name->pdf_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 mt-2 block">View Surat</a>
              @else
                <span class="text-red-500">PDF not found</span>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
      <a href="/" class="rounded-md font-semibold px-3 py-2 mr-2 text-gray-900 hover:bg-gray-100 leading-6">Cancel</a>
      <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" id="Save">Save</button>
    </div>
  </form>

  <!-- Load jQuery and SweetAlert2 from CDN -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <script type="text/javascript">
    $(document).ready(function(){
      $('#Save').on('click', function(e) {
        e.preventDefault();
        var form = $('#updateForm');
        Swal.fire({
          title: "Are you sure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Save"
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  </script>
</x-layout>

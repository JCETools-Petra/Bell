<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
            Edit Halaman "Apa Itu Affiliate"
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.affiliate_page.update') }}" method="POST">
                @csrf
                @method('PUT')

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 text-green-700 border border-green-200 rounded-xl flex items-center gap-3 shadow-sm">
                        <i class="fas fa-check-circle text-xl"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="p-6 bg-white border-b border-gray-100">
                        <textarea name="affiliate_page_content" id="affiliate_page_editor">{{ old('affiliate_page_content', $content) }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-lg shadow-brand-primary/30 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5 gap-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    {{-- Ganti skrip TinyMCE dengan skrip CKEditor 5 --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            ClassicEditor
                .create( document.querySelector( '#affiliate_page_editor' ), {
                    // Konfigurasi toolbar bisa ditambahkan di sini jika perlu
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'imageUpload', 'blockQuote', 'insertTable', 'mediaEmbed', 'undo', 'redo'
                    ]
                } )
                .catch( error => {
                    console.error( error );
                } );
        });
    </script>
    @endpush
</x-app-layout>
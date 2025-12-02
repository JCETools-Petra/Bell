<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
                {{ __('Edit MICE Kit Item') }}
            </h2>
            <a href="{{ route('admin.mice-kits.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    
                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl shadow-sm">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fas fa-exclamation-circle text-xl"></i>
                                <p class="font-bold">Oops! There were some problems with your input.</p>
                            </div>
                            <ul class="list-disc list-inside ml-8 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.mice-kits.update', $miceKit) }}" method="POST" enctype="multipart/form-data" x-data="{ type: '{{ old('type', $miceKit->type) }}' }" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" id="title" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ old('title', $miceKit->title) }}" required>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" required>{{ old('description', $miceKit->description) }}</textarea>
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-bold text-gray-700 mb-2">Item Type</label>
                            <select name="type" id="type" x-model="type" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">
                                <option value="file">File (PDF, PPT, etc.)</option>
                                <option value="video">Video File (MP4, MOV, etc.)</option>
                            </select>
                        </div>

                        <div x-show="type === 'file'" class="p-6 border border-gray-100 rounded-2xl bg-gray-50">
                            <label for="file" class="block text-sm font-bold text-gray-700 mb-2">Upload New File (Leave blank to keep current)</label>
                            <input type="file" name="file" id="file" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20 transition-all" :disabled="type !== 'file'">
                            <p class="mt-2 text-xs text-gray-500">Max file size: 10MB.</p>
                            @if($miceKit->type === 'file' && $miceKit->original_filename)
                                <div class="mt-4 flex items-center gap-2 text-sm text-gray-600 bg-white p-3 rounded-lg border border-gray-200">
                                    <i class="fas fa-file-alt text-gray-400"></i>
                                    <span>Current file: <strong>{{ $miceKit->original_filename }}</strong></span>
                                </div>
                            @endif
                        </div>

                        <div x-show="type === 'video'" class="p-6 border border-gray-100 rounded-2xl bg-gray-50" style="display: none;">
                            <label for="video_file" class="block text-sm font-bold text-gray-700 mb-2">Upload New Video (Leave blank to keep current)</label>
                            <input type="file" name="video_file" id="video_file" accept="video/mp4,video/mov,video/ogg,video/qt" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20 transition-all" :disabled="type !== 'video'">
                            <p class="mt-2 text-xs text-gray-500">Supported formats: MP4, MOV, OGG. Max: 50MB.</p>
                            @if($miceKit->type === 'video' && $miceKit->original_filename)
                                <div class="mt-4 flex items-center gap-2 text-sm text-gray-600 bg-white p-3 rounded-lg border border-gray-200">
                                    <i class="fas fa-video text-gray-400"></i>
                                    <span>Current video: <strong>{{ $miceKit->original_filename }}</strong></span>
                                </div>
                            @endif
                        </div>

                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.mice-kits.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-lg shadow-brand-primary/30 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i> Update Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

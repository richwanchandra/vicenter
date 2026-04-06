@extends('layouts.app')

@section('page_title', 'Edit Content')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        .note-editor {
            border-radius: 0.5rem !important;
            border-color: #d1d5db !important;
        }
        .note-toolbar {
            border-top-left-radius: 0.5rem !important;
            border-top-right-radius: 0.5rem !important;
            background-color: #f9fafb !important;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-4xl">
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
            <form method="POST" action="{{ route('admin.modules.contents.update', [$module, $content]) }}" class="space-y-4">
                @csrf @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Title</label>
                    <input type="text" name="title" value="{{ old('title', $content->title) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
                    @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Content</label>
                    <textarea name="content" id="content" rows="12" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror">{{ old('content', $content->content) }}</textarea>
                    @error('content') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                        <option value="draft" {{ old('status', $content->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="publish" {{ old('status', $content->status) === 'publish' ? 'selected' : '' }}>Publish</option>
                    </select>
                    @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="bg-gray-50 p-4 rounded border border-gray-200 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <div>
                            <strong>Created by:</strong> {{ $content->creator->name }}<br>
                            <strong>Created on:</strong> {{ $content->created_at?->format('d M Y H:i') }}
                        </div>
                        @if($content->updater)
                            <div class="text-right">
                                <strong>Last updated by:</strong> {{ $content->updater->name }}<br>
                                <strong>Last updated:</strong> {{ $content->updated_at?->format('d M Y H:i') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                        Update Content
                    </button>
                    <a href="{{ route('admin.modules.contents.index', $module) }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            const $content = $('#content');
            $content.summernote({
                placeholder: 'Write your content here...',
                tabsize: 2,
                height: 520,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'italic', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                        $content.val(contents);
                    }
                }
            });

            // Ensure content is synced on form submit
            $('form').on('submit', function() {
                if ($content.summernote('isEmpty')) {
                    $content.val('');
                } else {
                    $content.val($content.summernote('code'));
                }
            });
        });
    </script>
@endpush

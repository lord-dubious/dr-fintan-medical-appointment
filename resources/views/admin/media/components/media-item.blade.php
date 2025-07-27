<tr id="media-row-{{ $media->id }}">
    <td class="px-6 py-4">
        <input type="checkbox" class="select-media" value="{{ $media->id }}">
    </td>
    <td class="px-6 py-4">
        @if($media->isImage())
            <img src="{{ $media->url }}" alt="{{ $media->alt_text }}" class="w-16 h-16 object-cover rounded">
        @else
            <a href="{{ $media->url }}" target="_blank" class="text-gray-500">
                <i class="fas fa-file-alt fa-2x"></i>
            </a>
        @endif
    </td>
    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
        {{ $media->original_name }}
    </td>
    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
        {{ $media->file_size_human }}
    </td>
    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
        {{ $media->mime_type }}
    </td>
    <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
        {{ $media->alt_text ?: '-' }}
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
        <button class="edit-alt-btn px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded"
            data-url="{{ route('admin.media.update', $media->id) }}"
            data-alt-text="{{ $media->alt_text }}">
            Edit Alt
        </button>
        <button class="delete-btn px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded"
            data-url="{{ route('admin.media.destroy', $media->id) }}">
            Delete
        </button>
    </td>
</tr>

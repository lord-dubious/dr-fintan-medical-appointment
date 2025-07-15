@php
    use Illuminate\Support\Facades\Storage;
    $disk = config('filesystems.default');
@endphp
@php
    use Illuminate\Support\Facades\Storage;
    $disk = config('filesystems.default');
@endphp
<div class="mb-6">
    <label for="setting_{{ $setting->key }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ $setting->label ?? ucwords(str_replace('_', ' ', $setting->key)) }}
    </label>
    @if($setting->type === 'text')
        <input type="text" name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}"
            value="{{ old('settings.' . $setting->key, $setting->value) }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
    @elseif($setting->type === 'textarea')
        <textarea name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}" rows="4"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
    @elseif($setting->type === 'rich_text')
        <textarea name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
    @elseif($setting->type === 'json')
        <textarea name="settings[{{ $setting->key }}]" id="setting_{{ $setting->key }}" rows="6"
            class="font-mono mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('settings.' . $setting->key, json_encode(json_decode($setting->value), JSON_PRETTY_PRINT)) }}</textarea>
    @elseif($setting->type === 'image')
        <div class="flex items-center space-x-4">
            @if($setting->value)
                <img id="preview_{{ $setting->key }}" src="{{ $setting->value ? Storage::disk($disk)->url($setting->value) : '' }}" alt="{{ $setting->key }}"
                    class="w-32 h-32 object-cover rounded">
            @else
                <div id="preview_{{ $setting->key }}" class="w-32 h-32 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center text-gray-500">
                    No Image
                </div>
            @endif
            <input type="file" id="image_input_{{ $setting->key }}" data-key="{{ $setting->key }}"
                class="mt-1 block">
        </div>
    @endif
    <p id="error_{{ $setting->key }}" class="mt-2 text-sm text-red-600"></p>
</div>
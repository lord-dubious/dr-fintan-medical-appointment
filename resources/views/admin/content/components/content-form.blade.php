<div class="mb-6">
    <label for="content_{{ $section }}_{{ $key }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ ucwords(str_replace('_', ' ', $key)) }}
    </label>
    <textarea id="content_{{ $section }}_{{ $key }}" name="content[{{ $section }}.{{ $key }}]" rows="6"
        class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('content.' . $section . '.' . $key, $value) }}</textarea>
    <input type="hidden" name="content_type[{{ $section }}.{{ $key }}]" value="rich_text">
    <p id="error_{{ $section }}_{{ $key }}" class="mt-2 text-sm text-red-600">{{ $errors->first('content.' . $section . '.' . $key) }}</p>
</div>
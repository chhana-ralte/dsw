<div class="mt-4 p-2 bg-info text-white rounded">
    @isset($heading)
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ $heading }}
        </h3>
    @endisset
    {{ $slot }}
</div>
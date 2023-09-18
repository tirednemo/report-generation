<x-app-layout>
    <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">

        <div class="flow-root">
            <a href="{{ route('sheets.create') }}">
                <x-primary-button class="mt-3 float-right">{{ __('Upload file') }}</x-primary-button>
            </a>
        </div>

        <div class="mt-5 bg-white shadow-sm rounded-lg divide-y">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">SL</th>
                        <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Sheet Name</th>
                        <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Uploaded At</th>
                        <th class="px-6 py-3 bg-gray-100 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($sheets as $sheet)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap">
                            <div class="text-sm leading-5 text-gray-900">{{ $sheet->id }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap">
                            <div class="text-sm leading-5 text-gray-900">{{ explode('_', $sheet->file_name)[1] }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap">
                            <div class="text-sm leading-5 text-gray-900">{{ $sheet->created_at->format('j M Y, g:i a') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap">
                            <button class="bg-gray-100 py-2 px-2 rounded">
                                <a href="{{ route('sheets.show', ['sheet' => $sheet->id]) }}">{{ __('Download') }}</a>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
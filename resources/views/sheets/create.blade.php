<x-app-layout>
    <style>
        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .file-preview-item {
            display: flex;
            align-items: center;
            padding: 8px;
            background-color: #F7FAFC;
            border: 1px solid #EDF2F7;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            border-radius: 4px;
            margin-top: 8px;
        }

        .file-preview-thumbnail {
            width: 40px;
            height: 40px;
            margin-right: 8px;
        }

        .file-preview-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .file-preview-details {
            flex: 1;
        }

        .file-preview-name {
            font-weight: bold;
        }

        .file-preview-info {
            color: #718096;
            font-size: 0.875rem;
        }

        .file-preview-remove {
            cursor: pointer;
            color: #718096;
        }
    </style>


    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                <form method="POST" action="{{ route('sheets.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col">
                        <div class="relative">
                            <label for="file-upload" class="cursor-pointer bg-slate-500 text-white text-sm py-2 px-4 rounded-lg">
                                Choose a file
                            </label>
                            <input id="file-upload" type="file" name="sheet" class="hidden" accept=".xlsx, .xls" onchange="displayFilePreview(event)">
                            <div id="file-preview" class="mt-2"></div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <x-primary-button class="py-2 px-4">
                                Upload
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @if(session('success'))
    <script>
        Toastify({
            text: "{{ session('success') }}",
            duration: 3000,
            close: true,
            gravity: 'top',
            position: 'right',
            style: {
                background: 'black',
                borderRadius: '10px'
            },
            stopOnFocus: true
        }).showToast();
    </script>
    @endif

    @if(session('errors'))
    <script>
        Toastify({
            text: "{{ session('errors')->first('sheet') }}",
            duration: 3000,
            close: true,
            gravity: 'top',
            position: 'right',
            style: {
                background: 'red',
                borderRadius: '10px'
            },
            stopOnFocus: true
        }).showToast();
    </script>
    @endif

    <script>
        function displayFilePreview(event) {
            const fileInput = event.target;
            const file = fileInput.files[0];
            const filePreview = document.getElementById('file-preview');

            if (file) {
                const fileName = file.name;
                const fileType = file.type;
                const fileSize = Math.round(file.size / 1024);

                const previewTemplate = `
                    <div class="file-preview-item">
                        <div class="file-preview-thumbnail">
                            <img src="/icons/file-icon.png" alt="File Preview">
                        </div>
                        <div class="file-preview-details">
                            <div class="file-preview-name">${fileName}</div>
                            <div class="file-preview-info">${fileSize} KB</div>
                        </div>
                        <div class="file-preview-remove" onclick="removeFilePreview(event)">
                            <i class="fa-sharp fa-solid fa-xmark"></i>
                        </div>
                    </div>
                `;

                filePreview.innerHTML = previewTemplate;
            } else {
                filePreview.innerHTML = '';
            }
        }

        function removeFilePreview(event) {
            const filePreviewItem = event.currentTarget.parentNode;
            const fileInput = document.getElementById('file-upload');
            fileInput.value = '';
            filePreviewItem.parentNode.removeChild(filePreviewItem);
        }
    </script>
</x-app-layout>
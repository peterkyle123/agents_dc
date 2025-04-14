<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Doctor</title>
    @vite('resources/css/app.css')
    <link href="https://unpkg.com/tailwindcss@^3.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-10">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-5 bg-gray-100 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-700">Add New Doctor</h2>
            </div>

            <div class="p-6">
                <form action="{{ route('doctors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                            Name:
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="shadow appearance-none border rounded w-full md:w-3/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        @error('name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="specialty" class="block text-gray-700 text-sm font-bold mb-2">
                            Specialty:
                        </label>
                        <input type="text" id="specialty" name="specialty" value="{{ old('specialty') }}" class="shadow appearance-none border rounded w-full md:w-3/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('specialty')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-gray-700 text-sm font-bold mb-2">
                            Address:
                        </label>
                        <textarea id="address" name="address" class="shadow appearance-none border rounded w-full md:w-3/4 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="signature" class="block text-gray-700 text-sm font-bold mb-2">
                            Signature (Image):
                        </label>
                        <div class="relative w-48 h-24 border rounded shadow-md overflow-hidden">
                            <img id="signature-preview" src="https://via.placeholder.com/192x96" alt="Signature Preview" class="w-full h-full object-contain bg-gray-100">
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300">
                                <label for="signature" class="text-white text-sm font-semibold cursor-pointer">
                                    Upload
                                    <input type="file" id="signature" name="signature" class="hidden" accept="image/*" onchange="previewImage('signature', 'signature-preview')">
                                </label>
                            </div>
                        </div>
                        @error('signature')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Add Doctor
                        </button>
                        <a href="{{ route('agents.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800 ml-4">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(inputId, previewId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = `https://via.placeholder.com/${preview.offsetWidth}x${preview.offsetHeight}`;
            }
        }
    </script>
</body>
</html>

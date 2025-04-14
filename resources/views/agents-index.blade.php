<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agents</title>
    @vite('resources/css/app.css')
    <link href="https://unpkg.com/tailwindcss@^3.0.0/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 10; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            border-radius: 0.5rem;
            position: relative;
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-10">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-5 bg-gray-100 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-700">Agents</h2>
                <a href="{{ route('agents.create') }}" class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Add New Agent
                </a>
            </div>

            <div class="p-6">
                @if (session('success'))
                    <div class="bg-green-200 border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($agents->isEmpty())
                    <p class="text-gray-500">No agents found.</p>
                @else
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Phone</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agents as $agent)
                                <tr class="hover:bg-gray-50">
                                    <td class="border px-4 py-2">{{ $agent->name }}</td>
                                    <td class="border px-4 py-2">{{ $agent->email }}</td>
                                    <td class="border px-4 py-2">{{ $agent->phone_number ?? '-' }}</td>
                                    <td class="border px-4 py-2 flex items-center space-x-2">
                                        <button data-modal-id="editModal{{ $agent->id }}" class="open-modal text-blue-500 hover:underline focus:outline-none">Edit</button>
                                        <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this agent?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline focus:outline-none">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <div id="editModal{{ $agent->id }}" class="modal">
                                    <div class="modal-content">
                                        <span class="close-button">&times;</span>
                                        <h2 class="text-xl font-semibold text-gray-700 mb-4">Edit Agent</h2>
                                        <form action="{{ route('agents.update', $agent->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                            @csrf
                                            @method('PUT')

                                            <div class="flex flex-col items-center mb-4">
                                                <label for="profile_picture_modal_{{ $agent->id }}" class="block text-gray-700 text-sm font-bold mb-2">
                                                    Profile Picture:
                                                </label>
                                                <div class="relative w-24 h-24 rounded-full shadow-md overflow-hidden">
                                                    <img id="profile-preview-modal_{{ $agent->id }}" src="{{ $agent->profile_picture ? asset('storage/' . $agent->profile_picture) : 'https://via.placeholder.com/96' }}" alt="Profile Preview" class="w-full h-full object-cover">
                                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-300">
                                                        <label for="profile_picture_modal_{{ $agent->id }}" class="text-white text-sm font-semibold cursor-pointer">
                                                            Upload
                                                            <input type="file" id="profile_picture_modal_{{ $agent->id }}" name="profile_picture" class="hidden" accept="image/*" onchange="previewImageModal(this, 'profile-preview-modal_{{ $agent->id }}')">
                                                        </label>
                                                    </div>
                                                </div>
                                                @error('profile_picture')
                                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="name_modal_{{ $agent->id }}" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                                                <input type="text" id="name_modal_{{ $agent->id }}" name="name" value="{{ old('name', $agent->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                                @error('name')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                                            </div>
                                            <div>
                                                <label for="email_modal_{{ $agent->id }}" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                                                <input type="email" id="email_modal_{{ $agent->id }}" name="email" value="{{ old('email', $agent->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                                @error('email')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                                            </div>
                                            <div>
                                                <label for="password_modal_{{ $agent->id }}" class="block text-gray-700 text-sm font-bold mb-2">Password (leave blank to keep current):</label>
                                                <input type="password" id="password_modal_{{ $agent->id }}" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                @error('password')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                                            </div>
                                            <div>
                                                <label for="password_confirmation_modal_{{ $agent->id }}" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password:</label>
                                                <input type="password" id="password_confirmation_modal_{{ $agent->id }}" name="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                @error('password_confirmation')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                                            </div>
                                            <div>
                                                <label for="phone_number_modal_{{ $agent->id }}" class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
                                                <input type="text" id="phone_number_modal_{{ $agent->id }}" name="phone_number" value="{{ old('phone_number', $agent->phone_number) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                                @error('phone_number')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                                            </div>
                                            <div>
                                                <label for="address_modal_{{ $agent->id }}" class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
                                                <textarea id="address_modal_{{ $agent->id }}" name="address" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('address', $agent->address) }}</textarea>
                                                @error('address')<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>@enderror
                                            </div>

                                            <div class="flex items-center justify-end space-x-2">
                                                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline close-button-js">Cancel</button>
                                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Agent</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <script>
        const openModalButtons = document.querySelectorAll('.open-modal');
        const closeButtons = document.querySelectorAll('.close-button');
        const closeButtonsJs = document.querySelectorAll('.close-button-js');
        const modals = document.querySelectorAll('.modal');

        openModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.dataset.modalId;
                const modal = document.getElementById(modalId);
                modal.style.display = "block";
            });
        });

        closeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modal = this.closest('.modal');
                modal.style.display = "none";
            });
        });

        closeButtonsJs.forEach(button => {
            button.addEventListener('click', function() {
                const modal = this.closest('.modal');
                modal.style.display = "none";
            });
        });

        window.addEventListener('click', function(event) {
            modals.forEach(modal => {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            });
        });

        function previewImageModal(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(previewId).src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                const defaultImageUrl = document.getElementById(previewId).dataset.defaultImage || 'https://via.placeholder.com/96';
                document.getElementById(previewId).src = defaultImageUrl;
            }
        }
    </script>
</body>
</html>

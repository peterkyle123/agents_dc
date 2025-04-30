<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor List</title>
    @vite('resources/css/app.css')
    <link href="https://unpkg.com/tailwindcss@^3.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-10">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-5 bg-gray-100 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-700">List of Doctors</h2>
            </div>

            <div class="p-6 overflow-x-auto">
                @if($doctors->count() > 0)
                    <table class="min-w-full table-auto border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="text-left px-4 py-2 border">Name</th>
                                <th class="text-left px-4 py-2 border">Specialty</th>
                                <th class="text-left px-4 py-2 border">Address</th>
                                <th class="text-left px-4 py-2 border">Signature</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($doctors as $doctor)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">{{ $doctor->name }}</td>
                                    <td class="px-4 py-2 border">{{ $doctor->specialty }}</td>
                                    <td class="px-4 py-2 border">{{ $doctor->address }}</td>
                                    <td class="px-4 py-2 border">
                                        @if($doctor->signature)
                                            <img src="{{ asset('storage/' . $doctor->signature) }}" alt="Signature" class="h-12 object-contain">
                                        @else
                                            <span class="text-gray-500 italic">No signature</span>
                                        @endif
                                        <td class="px-4 py-2 border text-center">
                                            <a href="{{ route('doctors.edit', $doctor->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded text-sm mr-2">
                                                Edit
                                            </a>

                                            <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this doctor?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-semibold py-1 px-3 rounded text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-600">No doctors found.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>

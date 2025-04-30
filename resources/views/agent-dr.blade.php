<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Coverage</title>
    @vite('resources/css/app.css')
    <style>
        .transition-opacity {
            transition: opacity 0.2s ease-in-out;
        }

        #camera-preview {
            width: 100%;
            max-height: 200px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }

          /* Style for the background overlay when the modal is visible */
    #inputModal.modal-open {
        backdrop-filter: blur(5px); /* Adjust the blur radius as needed */
        -webkit-backdrop-filter: blur(5px); /* For Safari */
        background-color: rgba(0, 0, 0, 0.3); /* Optional: add a slight dark overlay for better contrast */
    }

    /* Hide scrollbar for WebKit browsers (Chrome, Safari) */
    #modalContent::-webkit-scrollbar {
        width: 0px;
        background: transparent;
    }

    /* Hide scrollbar for Firefox */
    #modalContent {
        scrollbar-width: none;
        max-h-[60vh] !important; /* Use !important to override inline styles if any */
        overflow-y: auto !important;
    }

    /* Optional: Adjust max height for smaller screens if needed */
    @media (max-height: 640px) {
        #modalContent {
            max-h-[40vh] !important;
        }
    }
    #inputModal.modal-open {
        backdrop-filter: blur(5px); /* Adjust the blur radius as needed */
        -webkit-backdrop-filter: blur(5px); /* For Safari */
        background-color: rgba(0, 0, 0, 0.3); /* Optional: add a slight dark overlay for better contrast */
    }

    /* Hide scrollbar for WebKit browsers (Chrome, Safari) */
    #modalContent::-webkit-scrollbar {
        width: 0px;
        background: transparent;
    }

    /* Hide scrollbar for Firefox */
    #modalContent {
        scrollbar-width: none;
        max-h-[60vh] !important; /* Use !important to override inline styles if any */
        overflow-y: auto !important;
    }

    /* Optional: Adjust max height for smaller screens if needed */
    @media (max-height: 640px) {
        #modalContent {
            max-h-[40vh] !important;
        }
    }

    /* Full screen modal for mobile view (screens with a maximum width of 767px - typical mobile breakpoint) */
    @media (max-width: 767px) {
        #inputModal .bg-white {
            width: 100vw; /* Take full viewport width */
            height: 100vh; /* Take full viewport height */
            max-width: none; /* Override any maximum width */
            max-height: none; /* Override any maximum height */
            border-radius: 0; /* Remove rounded corners for full screen */
            padding: 1rem; /* Adjust padding as needed */
            display: flex;
            flex-direction: column;
            justify-content: flex-start; /* Align content to the top */
            align-items: stretch; /* Make content stretch within the modal */
        }

        #inputModal .bg-white #modalContent {
            max-h: calc(100vh - 80px); /* Adjust max height for header and buttons (example value) */
        }

        #inputModal .bg-white .mt-6.flex.justify-end.space-x-4 {
            margin-top: auto; /* Push buttons to the bottom */
            padding-bottom: 1rem; /* Add some padding at the bottom */
        }
    }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
          integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen p-4 sm:p-6">

<div class="max-w-6xl mx-auto bg-white dark:bg-gray-800 shadow-2xl rounded-2xl p-4 sm:p-8 space-y-4 sm:space-y-8">

    {{-- Header with Date and Title --}}
    <div class="flex items-center justify-between">
        <h2 class="text-3xl font-bold text-gray-800">Daily Coverage</h2>
        <div class="flex items-center space-x-4">
            <button id="darkModeToggle" class="mt-2 sm:mt-0 p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i id="moonIcon" class="fas fa-moon text-gray-600 dark:text-gray-400"></i>
                <i id="sunIcon" class="fas fa-sun hidden text-yellow-500"></i>
            </button>
        </div>
        <p class="text-gray-600 text-sm">
            {{ \Carbon\Carbon::now()->format('l, F j, Y') }}
        </p>
    </div>

    {{-- Doctors Table --}}
    <div>
        <h3 class="text-xl font-semibold text-orange-500 mb-4">Doctors Visited</h3>
        <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
            <table class="min-w-full text-sm text-left text-gray-800">
                <thead class="bg-blue-100 text-gray-700 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3">Doctor's Name</th>
                    <th class="px-6 py-3">Specialty</th>
                    <th class="px-6 py-3">Address</th>
                    <th class="px-6 py-3">Signature</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @for($i = 0; $i < 3; $i++)
                    <tr class="hover:bg-gray-50 transition cursor-pointer" onclick="openModal('doctor', this.id)" id="row-doctor-{{ $i }}">
                        <td class="px-6 py-4">Click to enter data</td>
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4" id="signature-cell-doctor-{{ $i }}"></td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>

    {{-- Incidental Call Table --}}
    <div>
        <h3 class="text-xl font-semibold text-orange-500 mb-4">Incidental Call</h3>
        <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
            <table class="min-w-full text-sm text-left text-gray-800">
                <thead class="bg-blue-100 text-gray-700 uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3">Doctor's Name</th>
                    <th class="px-6 py-3">Specialty</th>
                    <th class="px-6 py-3">Address</th>
                    <th class="px-6 py-3">Signature</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @for($i = 0; $i < 3; $i++)
                    <tr class="hover:bg-gray-50 transition cursor-pointer" onclick="openModal('incidental', this.id)" id="row-incidental-{{ $i }}">
                        <td class="px-6 py-4">Click to enter data</td>
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4"></td>
                        <td class="px-6 py-4" id="signature-cell-incidental-{{ $i }}"></td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>

    {{-- Drugstores Table --}}
    <div>
        <h3 class="text-xl font-semibold text-orange-500 mb-4">Drugstores Visited</h3>
        <div class="overflow-x-auto border border-gray-200 rounded-lg shadow-sm">
            <table class="min-w-full text-sm text-left text-gray-800">
                <thead class="bg-blue-100 dark:bg-blue-900 text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-2 sm:px-6 sm:py-3">Drugstore</th>
                    <th class="px-4 py-2 sm:px-6 sm:py-3">Owner/Manager</th>
                    <th class="px-4 py-2 sm:px-6 sm:py-3">Address</th>
                    <th class="px-4 py-2 sm:px-6 sm:py-3">Signature</th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @for($i = 0; $i < 3; $i++)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition cursor-pointer" onclick="openModal('drugstore', this.id)" id="row-drugstore-{{ $i }}">
                        <td class="px-4 py-2 sm:px-6 sm:py-4">Click to enter data</td>
                        <td class="px-4 py-2 sm:px-6 sm:py-4"></td>
                        <td class="px-4 py-2 sm:px-6 sm:py-4"></td>
                        <td class="px-4 py-2 sm:px-6 sm:py-4" id="signature-cell-drugstore-{{ $i }}"></td>
                    </tr>
                @endfor
                </tbody>
            </table>
        </div>
    </div>

    {{-- Agent Name Input Field --}}
    <div class="flex items-center gap-2 border-t border-gray-200 pt-6">
        <label for="agentName" class="text-orange-500 font-medium">Agent Name:</label>
        <input type="text" id="agentName" name="agentName" placeholder="Enter your name"
               class="w-full sm:w-1/2 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

</div>

{{-- Modal for Input --}}
<div id="inputModal" class="fixed inset-0 hidden flex items-center justify-center bg-gray-/100 bg-opacity-30 z-50 transition-opacity overflow-auto">
    <div class="bg-white p-6 rounded shadow-xl w-full max-w-md md:max-w-lg lg:max-w-xl">
        <h3 id="modalTitle" class="text-xl font-semibold mb-4"></h3>
        <div id="modalContent" class="max-h-[60vh] overflow-y-auto">
        </div>
        <div class="mt-6 flex justify-end space-x-4">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
            <button onclick="saveData()" class="px-4 py-2 bg-blue-500 text-white rounded">Save</button>
        </div>
    </div>
</div>
<script>
    let currentSignatureCellId = null;
    let videoStream = null;

    function openModal(type, rowId) {

        const modal = document.getElementById('inputModal');
        const title = document.getElementById('modalTitle');
        const content = document.getElementById('modalContent');
        let modalContentHtml = '';
        const rowIndex = rowId.split('-').pop();

        if (type === 'doctor') {
            title.innerText = "Doctors Visited Input";
            currentSignatureCellId = `signature-cell-doctor-${rowIndex}`;
            modalContentHtml = `
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Doctor's Name</label>
                    <input type="text" id="doctorName" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Doctor's Name">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Specialty</label>
                    <input type="text" id="specialty" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Specialty">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Address</label>
                    <input type="text" id="address" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Address">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Signature Option</label>
                    <div class="flex space-x-4">
                        <button type="button" onclick="showDrawingCanvas()">Draw Signature</button>
                        <button type="button" onclick="showCameraInput()">Take Picture</button>
                    </div>
                </div>
                <div id="signatureCanvasContainer" class="hidden mb-4">
                    <canvas id="signatureCanvas" width="300" height="150" style="border: 1px solid #ccc;"></canvas>
                    <button type="button" onclick="clearSignatureCanvas()" class="mt-2 px-4 py-2 bg-gray-300 rounded">Clear</button>
                </div>
                <div id="cameraInputContainer" class="hidden mb-4">
                    <video id="camera-preview" autoplay></video>
                    <button type="button" onclick="takePicture()">Take Picture</button>
                    <canvas id="capturedCanvas" style="display:none; width:100%; max-height:200px; border:1px solid #ccc;"></canvas>
                </div>
            `;
        } else if (type === 'incidental') {
            title.innerText = "Incidental Call Input";
            currentSignatureCellId = `signature-cell-incidental-${rowIndex}`;
            modalContentHtml = `
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Doctor's Name</label>
                    <input type="text" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Doctor's Name">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Specialty</label>
                    <input type="text" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Specialty">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Address</label>
                    <input type="text" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Address">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Signature Option</label>
                    <div class="flex space-x-4">
                        <button type="button" onclick="showDrawingCanvas()">Draw Signature</button>
                        <button type="button" onclick="showCameraInput()">Take Picture</button>
                    </div>
                </div>
                <div id="signatureCanvasContainer" class="hidden mb-4">
                    <canvas id="signatureCanvas" width="300" height="150" style="border: 1px solid #ccc;"></canvas>
                    <button type="button" onclick="clearSignatureCanvas()" class="mt-2 px-4 py-2 bg-gray-300 rounded">Clear</button>
                </div>
                <div id="cameraInputContainer" class="hidden mb-4">
                    <video id="camera-preview" autoplay></video>
                    <button type="button" onclick="takePicture()">Take Picture</button>
                    <canvas id="capturedCanvas" style="display:none; width:100%; max-height:200px; border:1px solid #ccc;"></canvas>
                </div>
            `;
        } else if (type === 'drugstore') {
            title.innerText = "Drugstore Visited Input";
            currentSignatureCellId = `signature-cell-drugstore-${rowIndex}`;
            modalContentHtml = `
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Drugstore</label>
                    <input type="text" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Drugstore">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Owner/Manager</label>
                    <input type="text" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Owner/Manager">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Address</label>
                    <input type="text" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter Address">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 mb-1">Signature Option</label>
                    <div class="flex space-x-4">
                        <button type="button" onclick="showDrawingCanvas()">Draw Signature</button>
                        <button type="button" onclick="showCameraInput()">Take Picture</button>
                    </div>
                </div>
                <div id="signatureCanvasContainer" class="hidden mb-4">
                    <canvas id="signatureCanvas" width="300" height="150" style="border: 1px solid #ccc;"></canvas>
                    <button type="button" onclick="clearSignatureCanvas()" class="mt-2 px-4 py-2 bg-gray-300 rounded">Clear</button>
                </div>
                <div id="cameraInputContainer" class="hidden mb-4">
                    <video id="camera-preview" autoplay></video>
                    <button type="button" onclick="takePicture()">Take Picture</button>
                    <canvas id="capturedCanvas" style="display:none; width:100%; max-height:200px; border:1px solid #ccc;"></canvas>
                </div>
            `;
        }

        content.innerHTML = modalContentHtml;
        modal.classList.remove("hidden");
     modal.classList.add("modal-open");
        // Initially show the drawing canvas
        showDrawingCanvas();
    }

    function closeModal() {
        const modal = document.getElementById('inputModal');
        modal.classList.add("hidden");
        modal.classList.remove("modal-open"); // This line removes the class
        stopCameraStream();
    }

    function showDrawingCanvas() {
        document.getElementById('signatureCanvasContainer').classList.remove('hidden');
        document.getElementById('cameraInputContainer').classList.add('hidden');
        initializeDrawing();
        stopCameraStream();
    }
    function startCameraStream() {
     console.log("startCameraStream() called");
     if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
         navigator.mediaDevices.getUserMedia({ video: true })
             .then(function (stream) {
                 const video = document.getElementById('camera-preview');
                 video.srcObject = stream;
                 videoStream = stream;
                 console.log("Camera stream started successfully");
             })
             .catch(function (error) {
                 console.error("Could not access camera", error);
                 alert("Could not access camera. Please ensure your camera is enabled and accessible.");
             });
     } else {
         alert("Your browser does not support the getUserMedia API.");
     }
 }

    function showCameraInput() {
        document.getElementById('signatureCanvasContainer').classList.add('hidden');
        document.getElementById('cameraInputContainer').classList.remove('hidden');
        startCameraStream();
    }

    let isDrawing = false;
    let lastX = 0;
    let lastY = 0;
    let signatureCanvasElement = null;
    let signatureContext = null;

    function initializeDrawing() {
        signatureCanvasElement = document.getElementById('signatureCanvas');
        signatureContext = signatureCanvasElement.getContext('2d');
        signatureContext.lineWidth = 2;
        signatureContext.lineJoin = 'round';
        signatureContext.lineCap = 'round';
        signatureContext.strokeStyle = '#000';

        signatureCanvasElement.addEventListener('mousedown', (e) => {
            isDrawing = true;
            [lastX, lastY] = [e.offsetX, e.offsetY];
        });

        signatureCanvasElement.addEventListener('mousemove', draw);
        signatureCanvasElement.addEventListener('mouseup', () => isDrawing = false);
        signatureCanvasElement.addEventListener('mouseout', () => isDrawing = false);

        // Touch events for mobile
        signatureCanvasElement.addEventListener('touchstart', (e) => {
            isDrawing = true;
            [lastX, lastY] = [e.touches[0].clientX - signatureCanvasElement.offsetLeft, e.touches[0].clientY - signatureCanvasElement.offsetTop];
            e.preventDefault();
        }, { passive: false });

        signatureCanvasElement.addEventListener('touchmove', (e) => {
            draw(e);
            e.preventDefault();
        }, { passive: false });

        signatureCanvasElement.addEventListener('touchend', () => isDrawing = false);
        signatureCanvasElement.addEventListener('touchcancel', () => isDrawing = false);
    }

    function draw(e) {
        if (!isDrawing) return;
        signatureContext.beginPath();
        signatureContext.moveTo(lastX, lastY);

        if (e.type.startsWith('mouse')) {
            [lastX, lastY] = [e.offsetX, e.offsetY];
        } else if (e.type.startsWith('touch')) {
            [lastX, lastY] = [e.touches[0].clientX - signatureCanvasElement.offsetLeft, e.touches[0].clientY - signatureCanvasElement.offsetTop];
        }

        signatureContext.lineTo(lastX, lastY);
        signatureContext.stroke();
    }

    function clearSignatureCanvas() {
        signatureContext.clearRect(0, 0, signatureCanvasElement.width, signatureCanvasElement.height);
    }

    function saveData() {
        const signatureCanvasElement = document.getElementById('signatureCanvas');
        const capturedCanvas = document.getElementById('capturedCanvas');
        let signatureData = null;

        if (!document.getElementById('signatureCanvasContainer').classList.contains('hidden')) {
            signatureData = signatureCanvasElement.toDataURL('image/png');
        } else if (!document.getElementById('cameraInputContainer').classList.contains('hidden')) {
            if (capturedCanvas && capturedCanvas.getContext('2d').getImageData(0, 0, capturedCanvas.width, capturedCanvas.height).data.some(channel => channel !== 0)) {
                signatureData = capturedCanvas.toDataURL('image/png');
            }
        }

        if (currentSignatureCellId && signatureData) {
            const cell = document.getElementById(currentSignatureCellId);
            cell.innerHTML = '<img src="' + signatureData + '" alt="Signature" style="max-width: 100px; max-height: 50px;">';
        }

        closeModal();
        currentSignatureCellId = null;
        stopCameraStream();
    }

    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.querySelector('body');
    const moonIcon = document.getElementById('moonIcon');
    const sunIcon = document.getElementById('sunIcon');

    function toggleDarkMode() {
        body.classList.toggle('dark-mode');
        moonIcon.classList.toggle('hidden');
        sunIcon.classList.toggle('hidden');
        localStorage.setItem('darkMode', body.classList.contains('dark-mode'));
    }

    if (localStorage.getItem('darkMode') === 'true') {
        body.classList.add('dark-mode');
        moonIcon.classList.add('hidden');
        sunIcon.classList.remove('hidden');
    }

    darkModeToggle.addEventListener('click', toggleDarkMode);

    document.querySelectorAll('tbody tr').forEach(row => {
        row.addEventListener('click', function() {
            const type = this.closest('div').querySelector('h3').innerText.split(' ')[0].toLowerCase();
            openModal(type, this.id);
        });
        row.id = `row-${row.closest('div').querySelector('h3').innerText.split(' ')[0].toLowerCase()}-${Array.from(row.parentNode.children).indexOf(row)}`;
    });
</script>

</body>
</html>

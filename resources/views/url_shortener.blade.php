<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="Free URL Shortener - Shorten your URLs and track their clicks.">
    <meta name="keywords" content="URL shortener, shorten URL, link shortener">
    <meta name="author" content="Blue Cat">
    <style>
        .spinner {
            border: 4px solid rgba(0, 0, 0, 0.1);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border-left-color: #4a90e2;
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

        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .bg-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #2c3e50, #4a90e2);
            background-size: 400% 400%;
            animation: gradient 10s ease infinite;
            z-index: -1;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .cube-container {
            position: absolute;
            top: 10%;
            left: 50%;
            transform: translateX(-50%);
            perspective: 1000px;
        }

        .cube {
            width: 100px;
            height: 100px;
            position: relative;
            transform-style: preserve-3d;
            animation: rotateCube 20s infinite linear;
        }

        .cube__face {
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid #4a90e2;
        }

        .cube__face--front {
            transform: rotateY(0deg) translateZ(50px);
        }

        .cube__face--back {
            transform: rotateY(180deg) translateZ(50px);
        }

        .cube__face--right {
            transform: rotateY(90deg) translateZ(50px);
        }

        .cube__face--left {
            transform: rotateY(-90deg) translateZ(50px);
        }

        .cube__face--top {
            transform: rotateX(90deg) translateZ(50px);
        }

        .cube__face--bottom {
            transform: rotateX(-90deg) translateZ(50px);
        }

        @keyframes rotateCube {
            0% {
                transform: rotateX(0deg) rotateY(0deg);
            }
            100% {
                transform: rotateX(360deg) rotateY(360deg);
            }
        }
    </style>
</head>

<body class="bg-gray-900 relative overflow-hidden">
    <div class="bg-animation"></div>
    <div class="cube-container">
        <div class="cube">
            <div class="cube__face cube__face--front"></div>
            <div class="cube__face cube__face--back"></div>
            <div class="cube__face cube__face--right"></div>
            <div class="cube__face cube__face--left"></div>
            <div class="cube__face cube__face--top"></div>
            <div class="cube__face cube__face--bottom"></div>
        </div>
    </div>
    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        <div class="bg-gray-800 bg-opacity-90 p-8 rounded-lg shadow-lg max-w-lg w-full fade-in backdrop-filter backdrop-blur-lg">
            <h1 class="text-4xl font-extrabold text-white mb-6 text-center">URL Shortener</h1>
            <p class="mb-4 text-gray-300 text-center">Shorten your URLs easily and track their clicks. Enjoy the benefits of a cleaner, more manageable URL with improved user experience.</p>
            <ul class="list-disc list-inside mb-6 text-gray-300 space-y-2">
                <li>Easy to share and remember URLs.</li>
                <li>Track the number of clicks and user engagement.</li>
                <li>Make your links look cleaner and more professional.</li>
                <li>Ideal for social media, emails, and marketing campaigns.</li>
            </ul>
            <form id="shortenForm" class="space-y-4">
                @csrf
                <div>
                    <label for="url" class="block text-lg font-medium text-gray-200">Enter URL:</label>
                    <input type="text" name="url" id="url" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-700 text-gray-300">
                </div>
                <button type="button" id="shortenBtn"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center">
                    <span id="shortenBtnText">Shorten URL</span>
                    <div id="spinner" class="spinner hidden ml-2"></div>
                </button>
            </form>
            <div id="result" class="mt-6 text-center text-lg font-semibold text-blue-500"></div>
            <button value="copy" class="w-full mt-3 bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded hidden" id="copyBtn" onclick="copyToClipboard('result')">Copy!</button>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- CSRF Token Setup -->
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <!-- AJAX Request -->
    <script>
        $(document).ready(function () {
            $('#shortenBtn').click(function () {
                var url = $('#url').val();
                var APP_URL = {!! json_encode(url('/')) !!};
                $('#shortenBtnText').addClass('hidden');
                $('#spinner').removeClass('hidden');
                $.ajax({
                    type: "POST",
                    url: "{{ secure_url(route('url.short')) }}",
                    data: {
                        url: url
                    },
                    success: function (response) {
                        var fullUrl = APP_URL + '/' + response;
                        $('#result').html('<a href="' + fullUrl + '" class="text-blue-500">' + fullUrl + '</a>').addClass('fade-in');
                        $('#copyBtn').removeClass('hidden').addClass('fade-in');
                        $('#shortenBtnText').removeClass('hidden');
                        $('#spinner').addClass('hidden');
                    },
                    error: function (xhr, status, error) {
                        $('#result').html('<p class="text-red-500">Error: ' + xhr.responseText + '</p>').addClass('fade-in');
                        $('#shortenBtnText').removeClass('hidden');
                        $('#spinner').addClass('hidden');
                    }
                });
            });
        });
    </script>
    <!-- Copy to Clipboard -->
    <script>
        function copyToClipboard(id) {
            var textToCopy = document.getElementById(id).innerText || document.getElementById(id).textContent;
            var tempInput = document.createElement("textarea");
            tempInput.value = textToCopy;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            alert("Copied to clipboard!");
        }
    </script>
</body>

</html>

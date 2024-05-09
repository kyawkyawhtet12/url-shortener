<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Url Shortener</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">URL Shortener</h1>

        <form id="shortenForm" action="{{ route('url.short') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="url" class="form-label">Enter URL:</label>
                <input type="text" class="form-control" name="url" id="url" required>
            </div>
            <button type="button" id="shortenBtn" class="btn btn-primary">Shorten URL</button>
        </form>

        <div id="result" class="mt-3"></div>
        <button value="copy" class="btn btn-primary" onclick="copyToClipboard('result')">Copy!</button>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "accept": "application/json",
                "Access-Control-Allow-Headers": "x-requested-with",
                'Access-Control-Allow-Credentials': ' true',
                'Access-Control-Allow-Origin': '*'

            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#shortenBtn').click(function() {
                var url = $('#url').val();
                var APP_URL = {!! json_encode(url('/')) !!}
                $.ajax({
                    type: "POST",
                    url: "{{ route('url.short') }}",
                    data: {
                        url: url
                    },
                    success: function(response) {
                        console.log(response)
                        $('#result').html('<p><a href="' + APP_URL + response +
                            '">' +
                            APP_URL + response + '</a></p>');
                    },
                    error: function(xhr, status, error) {
                        $('#result').html('<p>Error: ' + xhr.responseText + '</p>');
                    }
                });
            });
        });
    </script>

    <script>
        function copyToClipboard(id) {
            var textToCopy = document.getElementById(id).innerText || document.getElementById(id).textContent;

            var tempInput = document.createElement("textarea");
            tempInput.value = textToCopy;
            document.body.appendChild(tempInput);

            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
        }
    </script>
</body>

</html>

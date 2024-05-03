<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Url Shortener</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">URL Shortener</h1>

        <form action="{{ route('url.short') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="url" class="form-label">Enter URL:</label>
                <input type="text" class="form-control" name="url" id="url" required>
            </div>
            <div id="url">

            </div>
            <button type="submit" class="btn btn-primary" id="shortenBtn">Shorten URL</button>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#shortenBtn').click(function() {
                var url = $('#url').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('url.short') }}",
                    data: {
                        url: url
                    },
                    success: function(response) {
                        $('#response').html('<p>Shortened URL: <a href="' + response
                            .shortened_url + '">' + response.shortened_url + '</a></p>');
                    },
                    error: function(xhr, status, error) {
                        $('#response').html('<p>Error: ' + xhr.responseText + '</p>');
                    }
                });
            });
        });
    </script>

</body>

</html>

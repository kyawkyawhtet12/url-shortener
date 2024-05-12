<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://richinfo.co/richpartners/in-page/js/richads-ob.js?pubid=924639&siteid=346319" async></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page will Redirect after 10 seconds</title>
</head>
<body>
    <div id="countdown"></div>
    <div>
        <!-- Content of your page goes here -->
    </div>
    <script>
        // Countdown function
        function countdown() {
            var seconds = 10;
            var countdownElement = document.getElementById('countdown');
            countdownElement.innerText = 'Redirecting in ' + seconds + ' seconds...';

            var countdownInterval = setInterval(function() {
                seconds--;
                countdownElement.innerText = 'Redirecting in ' + seconds + ' seconds...';
                if (seconds <= 0) {
                    clearInterval(countdownInterval);
                    window.location.href = "<?php echo $redirect_url; ?>";
                }
            }, 1000);
        }

        // Call the countdown function when the page loads
        window.onload = function() {
            countdown();
        };
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4Y80B08R3W"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-4Y80B08R3W');
    </script>
</body>
</html>

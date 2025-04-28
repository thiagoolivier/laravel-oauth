<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OAuth Callback</title>
</head>
<body>
    <script>
        if (window.opener) {
            window.opener.postMessage({ success: true }, window.location.origin);

            window.close();
        } else {
            console.error('No opener window found.');
        }
    </script>

    <p>Successfully logged in. You can close this window.</p>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OAuth Callback</title>
</head>
<body>
    <script>
        if (window.opener) {
            // Manda mensagem para a página principal
            window.opener.postMessage({ success: true }, window.location.origin);

            // Fecha o pop-up
            window.close();
        } else {
            console.error('No opener window found.');
        }
    </script>

    <p>Login realizado com sucesso. Você pode fechar esta janela.</p>
</body>
</html>

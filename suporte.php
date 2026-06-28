<?php

session_start();

$success = false;
$errors = [];
$name = $email = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $message = $_POST["message"] ?? "";

    if (empty(trim($name))) {
        $errors[] = "O nome é obrigatório.";
    }

    if (empty(trim($email))) {
        $errors[] = "O email é obrigatório.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Formato de email inválido.";
    }

    if (empty(trim($message))) {
        $errors[] = "A mensagem é obrigatória.";
    }

    if (empty($errors)) {

        $to = "suportetec200y@gmail.com";
        $subject = "Formulário de Suporte - $name";
        $body = "Nome: $name\nEmail: $email\nMensagem:\n$message";
        $headers = "From: $email";

        mail($to, $subject, $body, $headers);

        $_SESSION["feedback"] = "Mensagem enviada com sucesso! Entraremos em contato em breve.";
        header("Location: " . $_SERVER["PHP_SELF"]);
        exit;
    }

} elseif (isset($_SESSION["feedback"])) {
    $success = true;
    $feedback = $_SESSION["feedback"];
    unset($_SESSION["feedback"]);
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: fadeIn .6s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(37, 99, 235, .4); }
            50%      { box-shadow: 0 0 0 12px rgba(37, 99, 235, 0); }
        }

        @keyframes shimmer {
            0%   { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .container {
            background: rgba(255, 255, 255, .06);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, .1);
            padding: 2.5rem;
            border-radius: 20px;
            width: 100%;
            max-width: 480px;
            animation: fadeIn .6s ease;
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo h1 {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .logo p {
            color: rgba(255, 255, 255, .5);
            font-size: .85rem;
            margin-top: .25rem;
        }

        h2 {
            color: #fff;
            font-size: 1.15rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }

        .field {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            margin-bottom: .4rem;
            font-size: .85rem;
            font-weight: 600;
            color: rgba(255, 255, 255, .8);
        }

        input, textarea {
            width: 100%;
            padding: .75rem 1rem;
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 12px;
            font-size: .95rem;
            color: #fff;
            transition: all .25s ease;
        }

        input::placeholder, textarea::placeholder {
            color: rgba(255, 255, 255, .3);
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(255, 255, 255, .08);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, .2);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        button {
            margin-top: .5rem;
            width: 100%;
            padding: .8rem;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .25s ease;
            position: relative;
            overflow: hidden;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 99, 235, .35);
        }

        button:active {
            transform: translateY(0);
        }

        .error {
            background: rgba(239, 68, 68, .15);
            border: 1px solid rgba(239, 68, 68, .3);
            color: #fca5a5;
            padding: .75rem 1rem;
            border-radius: 12px;
            margin-bottom: 1.25rem;
            font-size: .85rem;
            animation: slideDown .3s ease;
        }

        .error ul { list-style: none; }
        .error li::before { content: "• "; color: #f87171; }

        .success {
            background: rgba(34, 197, 94, .15);
            border: 1px solid rgba(34, 197, 94, .3);
            color: #86efac;
            padding: .75rem 1rem;
            border-radius: 12px;
            margin-bottom: 1.25rem;
            font-size: .85rem;
            animation: slideDown .3s ease;
        }

        .whatsapp {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, .08);
            text-align: center;
        }

        .whatsapp p {
            color: rgba(255, 255, 255, .5);
            font-size: .85rem;
        }

        .whatsapp .badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            margin-top: .75rem;
            padding: .5rem 1.25rem;
            background: rgba(34, 197, 94, .12);
            border: 1px solid rgba(34, 197, 94, .25);
            border-radius: 50px;
            color: #86efac;
            font-size: .85rem;
            font-weight: 500;
            animation: pulse 2s infinite;
        }

        .whatsapp .badge svg {
            width: 18px;
            height: 18px;
            fill: #86efac;
        }

        .whatsapp .badge:hover {
            background: rgba(34, 197, 94, .2);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <h1>Suporte Técnico</h1>
            <p>Estamos aqui para ajudar</p>
        </div>

        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($feedback) ?></div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="">
            <h2>Envie sua mensagem</h2>

            <div class="field">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" placeholder="Seu nome" value="<?= htmlspecialchars($name) ?>" required>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="seu@email.com" value="<?= htmlspecialchars($email) ?>" required>
            </div>

            <div class="field">
                <label for="message">Mensagem</label>
                <textarea id="message" name="message" placeholder="Descreva o seu problema..."><?= htmlspecialchars($message) ?></textarea>
            </div>

            <button type="submit">Enviar Mensagem</button>
        </form>

        <div class="whatsapp">
            <p>Prefere falar pelo WhatsApp?</p>
            <div class="badge">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                WhatsApp — Em breve
            </div>
        </div>
    </div>
</body>
</html>

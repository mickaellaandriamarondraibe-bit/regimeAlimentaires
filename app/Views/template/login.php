<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            width: 100%;
            max-width: 360px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            padding: 24px;
        }
        h1 {
            margin: 0 0 16px 0;
            font-size: 22px;
            color: #222;
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 6px;
            font-size: 14px;
            color: #333;
        }
        input {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #ccd3dc;
            border-radius: 6px;
            font-size: 14px;
        }
        button {
            width: 100%;
            margin-top: 16px;
            border: 0;
            background: #0d6efd;
            color: #fff;
            padding: 10px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }
        .error {
            background: #fdecec;
            color: #b42318;
            border: 1px solid #f3b7b7;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 12px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Connexion</h1>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="error"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('/validationLogin') ?>">
            <?= csrf_field() ?>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required>

            <label for="pwd">Mot de passe</label>
            <input id="pwd" type="password" name="pwd" required>

            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>

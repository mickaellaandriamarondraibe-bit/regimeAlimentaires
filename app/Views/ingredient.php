<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Liste des ingrédients</h1>
    <ul>
        <?php foreach ($ingredients as $item): ?>
            <li><?= esc($item['name']) ?></li>
        <?php endforeach; ?>
    </ul>   
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des regimes</title>
</head>
<body>
    <h1>Liste des régimes</h1>
    <ul>
    <?php foreach ($regimes as $regime):?>
        <li><?= $regime['name'] ?></li>
    <?php endforeach;?>
    </ul>
    <a href="/regime/create">Add new regime</a>
</body>
</html>
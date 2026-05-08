<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .d-none{
            display: none;
        }
    </style>
</head>
<body>
    <h1>Liste des ingrédients</h1>
    <ul>
        <?php foreach ($ingredients as $item): ?>
            <li><?= esc($item['name']) ?></li>
        <?php endforeach; ?>
    </ul>

    <button id="showFormBtn">Ajouter un ingrédient</button>
    <div class="d-none">
        <form action="/ingredient/create" method="post">
            <label for="name">Nom de l'ingrédient</label>
            <input type="text" name="name" id="name" placeholder="Nom de l'ingrédient" required><br>
            <button type="submit">Enregistrer l'ingrédient</button>
        </form>
    </div>
    <script src="/js/ingredient.js"></script>
</body>
</html>
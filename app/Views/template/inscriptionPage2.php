<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Étape 2</title>
</head>
<body>

    <fieldset>
        <legend>Inscription - Étape 2</legend>

        <?php if (session()->getFlashdata('error')): ?>
            <p style="color:red;">
                <?= esc(session()->getFlashdata('error')) ?>
            </p>
        <?php endif; ?>

        <form id="formStep2" action="/register" method="post">
            <?= csrf_field() ?>

            <div>
                <label for="phone">Téléphone</label>
                <input
                    type="text"
                    name="phone"
                    id="phone"
                    value="<?= esc(session('phone') ?? '') ?>"
                >
                <span id="erreur_phone" style="color:red; display:none;">
                    Téléphone requis
                </span>
            </div>

            <div>
                <label for="genre">Genre</label>
                <select name="genre" id="genre">
                    <option value="">Sélectionnez votre genre</option>
                    <option value="H" <?= session('genre') === 'H' ? 'selected' : '' ?>>Homme</option>
                    <option value="F" <?= session('genre') === 'F' ? 'selected' : '' ?>>Femme</option>
                </select>
                <span id="erreur_genre" style="color:red; display:none;">
                    Genre requis
                </span>
            </div>

            <div>
                <label for="taille">Taille en cm</label>
                <input
                    type="number"
                    name="taille"
                    id="taille"
                    min="50"
                    max="250"
                    step="0.01"
                    value="<?= esc(session('taille') ?? '') ?>"
                >
                <span id="erreur_taille" style="color:red; display:none;">
                    Taille requise et valide
                </span>
            </div>

            <div>
                <label for="poids">Poids en kg</label>
                <input
                    type="number"
                    name="poids"
                    id="poids"
                    min="10"
                    max="300"
                    step="0.01"
                    value="<?= esc(session('poids') ?? '') ?>"
                >
                <span id="erreur_poids" style="color:red; display:none;">
                    Poids requis et valide
                </span>
            </div>

            <button type="submit">Enregistrer les informations</button>
            <button type="button" onclick="retour()">Retour</button>
        </form>
    </fieldset>

<script>
    function showError(id, show) {
        document.getElementById(id).style.display = show ? "block" : "none";
    }

    document.getElementById("formStep2").addEventListener("submit", function (event) {
        event.preventDefault();

        const phone = document.getElementById("phone").value.trim();
        const genre = document.getElementById("genre").value.trim();
        const taille = document.getElementById("taille").value.trim();
        const poids = document.getElementById("poids").value.trim();

        let isValid = true;

        if (phone === "") {
            showError("erreur_phone", true);
            isValid = false;
        } else {
            showError("erreur_phone", false);
        }

        if (genre === "") {
            showError("erreur_genre", true);
            isValid = false;
        } else {
            showError("erreur_genre", false);
        }

        if (taille === "" || Number(taille) <= 0) {
            showError("erreur_taille", true);
            isValid = false;
        } else {
            showError("erreur_taille", false);
        }

        if (poids === "" || Number(poids) <= 0) {
            showError("erreur_poids", true);
            isValid = false;
        } else {
            showError("erreur_poids", false);
        }

        if (isValid) {
            this.submit();
        }
    });

    function retour() {
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "/savePage2";

        const csrfName = "<?= csrf_token() ?>";
        const csrfHash = "<?= csrf_hash() ?>";

        const csrfInput = document.createElement("input");
        csrfInput.type = "hidden";
        csrfInput.name = csrfName;
        csrfInput.value = csrfHash;
        form.appendChild(csrfInput);

        const fields = ["phone", "genre", "taille", "poids"];

        fields.forEach(function (fieldName) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = fieldName;
            input.value = document.getElementById(fieldName).value;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }
</script>

</body>
</html>
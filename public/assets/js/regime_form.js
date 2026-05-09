const prixFieldSet = document.getElementById('prix-fieldset');
const addWeekButton = document.getElementById('add-week');

addWeekButton.addEventListener('click', () => {
    const newField = document.createElement('div');
    newField.classList.add('prix-week');

    newField.innerHTML = `
        <div class="row">
            <div class="col-lg-5">
                <div class="form-group">
                    <label>Numéro de la semaine</label>
                    <input type="number" name="semaine[]" id="semaine" value="" class="form-control">
                </div>
            </div>
            <div class="col-lg-5">
                <div class="form-group">
                    <label>Prix (Ar)</label>
                    <input type="number" name="prix[]" id="prix" step="any" value="" class="form-control">                </div>
            </div>
            <div class="col-lg-2 d-flex align-items-center">
                <button type="button" class="remove-week btn btn-danger" style="margin-top: 10%; width: 100%;"><i class="fas fa-trash mr-6"></i> Effacer</button>
            </div>
        </div>
    `;

    // Insérer le nouveau champ à la fin du fieldset
    prixFieldSet.appendChild(newField);
});

prixFieldSet.addEventListener('click', (e) => {
    if (e.target.classList.contains('remove-week')) {
        const weekRows = prixFieldSet.querySelectorAll('.prix-week');
        if (weekRows.length > 1) {
            e.target.closest('.prix-week').remove();
        } else {
            alert('Vous devez garder au moins une semaine.');
        }
    }
});

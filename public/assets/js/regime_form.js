const prixFieldSet = document.getElementById('prix-fieldset');
const addWeekButton = document.getElementById('add-week');

addWeekButton.addEventListener('click', () => {
    const newField = document.createElement('div');
    newField.classList.add('prix-week');
    
    newField.innerHTML = `
        <label>Numéro de la semaine</label>
        <input type="number" name="semaine[]" value="">
        <label>Prix (Ar)</label>
        <input type="number" name="prix[]" step="any" value="">
        <button type="button" class="remove-week">Effacer</button>
    `;
    
    // Insérer le nouveau champ juste avant le bouton "Ajouter"
    prixFieldSet.insertBefore(newField, addWeekButton);
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

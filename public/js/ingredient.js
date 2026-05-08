const showFormBtn = document.getElementById('showFormBtn');

showFormBtn.addEventListener('click', function() {
    // On cible le conteneur du formulaire
    const formContainer = this.nextElementSibling;
    
    // Toggle ajoute 'd-none' si absent, l'enlève si présent
    formContainer.classList.toggle('d-none');

    // Bonus : Changer le texte du bouton dynamiquement
    if (formContainer.classList.contains('d-none')) {
        this.textContent = "Ajouter un ingrédient";
    } else {
        this.textContent = "Fermer le formulaire";
    }
});
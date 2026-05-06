Table client:
    id
    name
    email
    phone
    genre
    password
    taille
    poids
    is_gold
    wallet

table objectif
    id
    name

table régime
    id
    name
    type_variation | ENUM ("gain", "perte")
    composition
        % volaille
        % viande
        % poisson
        % légumes
    variation_poids/jour
    prix/jour

table sport
    id
    name
    variation_poids/jour

table programme
    id
    objectif_id
    objectif_kg
    duree
    transaction_id
    client_id nullable false
    regime_id nullable false

table programme_sport
    id
    programme_id
    sport_id

table code
    id
    code
    montant
    date_used nullable true
    client_id nullable true

table transactions
    id
    date
    type | ENUM("D", "C")
    client_id
    montant
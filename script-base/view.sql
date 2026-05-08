CREATE OR REPLACE VIEW v_composition_regimes AS
SELECT 
    r.id AS regime_id,
    r.name AS regime_name,
    r.type_variation AS type_variation,
    r.variation_poids_jour AS variation_poids_jour,
    r.prix_jour AS prix_jour,

    i.id AS ingredient_id,
    i.name AS ingredient_name,
    
    COALESCE(cr.pourcentage, 0) AS pourcentage
FROM regimes r
CROSS JOIN ingredients i
LEFT JOIN composition_regimes cr 
    ON r.id = cr.regime_id 
    AND i.id = cr.ingredient_id
ORDER BY r.name, i.name;

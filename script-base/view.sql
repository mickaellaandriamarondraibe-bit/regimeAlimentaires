DROP VIEW IF EXISTS v_regime_objectifs;

CREATE OR REPLACE VIEW v_composition_regimes AS
SELECT 
    r.id AS regime_id,
    r.name AS regime_name,
    r.description AS regime_description,
    r.variation_poids_semaine AS variation_poids_semaine,
    r.objectif_id AS objectif_id,

    i.id AS ingredient_id,
    i.name AS ingredient_name,
    
    COALESCE(cr.pourcentage, 0) AS pourcentage
FROM regimes r
CROSS JOIN ingredients i
LEFT JOIN composition_regimes cr 
    ON r.id = cr.regime_id 
    AND i.id = cr.ingredient_id
ORDER BY r.name, i.name;

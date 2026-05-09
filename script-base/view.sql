CREATE OR REPLACE VIEW v_regime_objectifs AS
SELECT 
    r.id AS regime_id,
    r.name AS regime_name,
    r.description AS regime_description,
    r.variation_poids_jour AS variation_poids_jour,
    
    o.id AS objectif_id,
    o.name AS objectif_name
FROM regimes r
JOIN objectif o ON r.objectif_id = o.id;

CREATE OR REPLACE VIEW v_composition_regimes AS
SELECT 
    r.regime_id AS regime_id,
    r.regime_name AS regime_name,
    r.regime_description AS regime_description,
    r.variation_poids_jour AS variation_poids_jour,
    r.objectif_id AS objectif_id,
    r.objectif_name AS objectif_name,

    i.id AS ingredient_id,
    i.name AS ingredient_name,
    
    COALESCE(cr.pourcentage, 0) AS pourcentage
FROM v_regime_objectifs r
CROSS JOIN ingredients i
LEFT JOIN composition_regimes cr 
    ON r.regime_id = cr.regime_id 
    AND i.id = cr.ingredient_id
ORDER BY r.regime_name, i.name;

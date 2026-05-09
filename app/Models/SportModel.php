<?php
namespace App\Models;
use CodeIgniter\Model;

class SportModel extends Model
{
    protected $table='sport';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'name',
        'description',
        'variation_poids_semaine'
    ];

    protected $validationRules = [
        'name' => 'required|max_length[150]',
        'variation_poids_semaine' => 'required|numeric'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Le nom du sport est obligatoire.',
            'max_length' => 'Le nom du sport ne doit pas être trop long.'
        ],
        'variation_poids_semaine' => [
            'required' => 'Le sport doit avoir une incidence sur la variation du poids.',
            'numeric' => 'La variation de poids doit être un nombre valide.'
        ]
    ];

    public function getSportById($id){
        return $this->find($id);
    }

    public function getAllSports(){
        return $this->findAll();
    }

    public function getSportsByVariation($variation){
        return $this->where('variation_poids_semaine <=', $variation)
                    ->findAll();
    }
}
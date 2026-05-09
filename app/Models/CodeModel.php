<?php 
namespace App\Models;
use CodeIgniter\Model;

class CodeModel extends Model
{
    protected $table = 'code';
    protected $primaryKey = 'id';
    protected $allowedFields = ['code','motant'];

    protected $validationRules = [
        'code' => 'required|max_length[100]',
    ];

    function verifCode(string $code): ?array
    {
        return $this->where('code', $code)->first();
    }
    function getCodeById(int $id): ?array
    {
        return $this->find($id);
    }
    function updateCode(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }
    function createCode(array $data): int
    {
        $this->insert($data);
        return $this->getInsertID();
    }
    function deleteCode($id){
        return $this->delete($id);
    }
}
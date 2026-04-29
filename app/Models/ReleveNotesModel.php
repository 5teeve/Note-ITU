<?php
namespace App\Models;

use CodeIgniter\Model;

class ReleveNotesModel extends Model
{
    protected $table = 'v_releve_notes';
    // On définit une clé primaire fictive (composite logique)
    protected $primaryKey = 'id_etudiant';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_etudiant',
        'semestre_id',
        'ue_id',
        'code',
        'libelle',
        'credits',
        'note',
    ];
    public $useTimestamps = false;
}

<?php
namespace App\Models;

use CodeIgniter\Model;

class ParcoursModel extends Model
{
    protected $table = 'parcours';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['nom'];
}

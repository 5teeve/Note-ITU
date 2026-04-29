<?php
define('ENVIRONMENT', 'development');
require 'system/bootstrap.php';
require 'system/CodeIgniter.php';
$app = \CodeIgniter\Config\Services::codeigniter(null, false);
$app->initialize();

$model = new \App\Models\EtudiantModel();
$db = \Config\Database::connect();
$builder = $db->table('etudiant');
$builder->select('etudiant.*, parcours.nom as parcours_nom')
        ->join('parcours', 'parcours.id = etudiant.parcours_id', 'left');
echo $builder->getCompiledSelect();
echo "\n";

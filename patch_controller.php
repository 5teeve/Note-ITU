<?php
$file = 'app/Controllers/EtudiantController.php';
$content = file_get_contents($file);

$method = '
    public function upsertNote()
    {
        $noteModel = new NotesModel();
        
        $id_etudiant = $this->request->getPost(\'id_etudiant\');
        $ue_id = $this->request->getPost(\'ue_id\');
        $semestre_id = $this->request->getPost(\'semestre_id\');
        $nouvelle_note = $this->request->getPost(\'note\');
        
        if ($nouvelle_note !== null && $id_etudiant && $ue_id && $semestre_id) {
            // Check if note exists
            $existing_note = $noteModel->where(\'id_etudiant\', $id_etudiant)
                                       ->where(\'ue_id\', $ue_id)
                                       ->where(\'semestre_id\', $semestre_id)
                                       ->first();
            
            if ($existing_note) {
                // Update
                $noteModel->update($existing_note[\'id\'], [\'note\' => $nouvelle_note]);
            } else {
                // Insert
                $noteModel->insert([
                    \'id_etudiant\' => $id_etudiant,
                    \'ue_id\' => $ue_id,
                    \'semestre_id\' => $semestre_id,
                    \'note\' => $nouvelle_note
                ]);
            }
        }
        
        return redirect()->back();
    }
';

$content = str_replace("}\n", "\n" . $method . "}\n", $content);
file_put_contents($file, $content);

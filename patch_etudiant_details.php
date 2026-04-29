<?php
$file = 'app/Views/etudiant_details.php';
$content = file_get_contents($file);
$content = preg_replace('/<div style="display: flex; gap: 5px;">(.*?)<\/div>/s', '
                <div style="display: flex; gap: 5px;">
                  <!-- Formulaire d\'ajout/modification -->
                  <form action="/notes/upsert" method="post" style="display:inline; display: flex; gap: 5px;">
                    <input type="hidden" name="id_etudiant" value="<?= esc($etudiant[\'id\']) ?>">
                    <input type="hidden" name="ue_id" value="<?= esc($n[\'ue_id\']) ?>">
                    <input type="hidden" name="semestre_id" value="<?= esc($current_semestre) ?>">
                    <input type="number" step="0.01" min="0" max="20" name="note" value="<?= esc($n[\'max_note\']) ?>" style="width: 70px; padding: 4px; border: 1px solid #ccc; border-radius: 4px;">
                    <button type="submit" class="btn btn-primary btn-sm" style="padding: 4px 8px;"><?= $n[\'note_id\'] ? \'Modifier\' : \'Ajouter\' ?></button>
                  </form>
                  <?php if ($n[\'note_id\']): ?>
                    <a href="/notes/delete/<?= esc($n[\'note_id\']) ?>" class="btn btn-secondary btn-sm" style="padding: 4px 8px; background: #ffebee; color: #c62828; border: 1px solid #ffcdd2;" onclick="return confirm(\'Voulez-vous vraiment supprimer cette note ?\');">Supprimer</a>
                  <?php endif; ?>
                </div>
', $content);
file_put_contents($file, $content);

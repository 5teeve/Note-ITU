<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Notes de l'étudiant</title>
  <link rel="stylesheet" href="/style.css" />
  <style>
    .note-input { width: 80px; padding: 4px; border: 1px solid var(--border-color); border-radius: 4px; }
  </style>
</head>
<body>

<div class="app">
  <div class="main" style="margin-left: 0; max-width: 900px; margin: 0 auto; min-height: 100vh;">
    
    <div class="content">

      <div class="page-header" style="margin-top: 40px;">
        <div>
          <h2>Notes de <?= esc($etudiant['prenom']) ?> <?= esc($etudiant['nom']) ?> (<?= esc($etudiant['numero_etu']) ?>)</h2>
          <div class="breadcrumb">
            <a href="/etudiants">Étudiants</a> / <span>Notes</span>
          </div>
        </div>
      </div>

      <!-- Toolbar filtres -->
      <div class="toolbar">
        <div class="toolbar-left">
          <form method="get" action="/notes/etudiant/<?= esc($etudiant['id']) ?>" style="display:flex; gap:10px;">
            <select name="semestre" class="filter-select" onchange="this.form.submit()">
              <option value="1" <?= $current_semestre == 1 ? 'selected' : '' ?>>Semestre 3</option>
              <option value="2" <?= $current_semestre == 2 ? 'selected' : '' ?>>Semestre 4</option>
            </select>
          </form>
        </div>
      </div>

      <!-- Tableau -->
      <div class="table-card">
        <table>
          <thead>
            <tr>
              <th>Code UE</th>
              <th>Matière</th>
              <th>Crédits</th>
              <th>Type</th>
              <th>Note</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($notes as $note): ?>
            <tr>
              <td style="font-family:monospace;font-weight:600"><?= esc($note['code']) ?></td>
              <td style="font-weight:600"><?= esc($note['libelle']) ?></td>
              <td><?= esc($note['credits']) ?></td>
              <td>
                <?php if (isset($note['is_optional']) && $note['is_optional']): ?>
                  <span class="nav-badge" style="background:#f59e0b;color:#fff;">Optionnelle (Meilleure)</span>
                <?php else: ?>
                  <span class="nav-badge">Obligatoire</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($note['note_id']): ?>
                  <form method="post" action="/notes/edit/<?= esc($note['note_id']) ?>" style="display:inline-flex; gap:5px;">
                    <input type="number" step="0.01" min="0" max="20" name="note" class="note-input" value="<?= esc($note['max_note']) ?>">
                    <button type="submit" class="btn btn-primary btn-sm" style="padding:4px 8px;font-size:12px;">✔</button>
                  </form>
                <?php else: ?>
                  <span style="color:#ef4444;font-weight:bold;">0.00 (Sans note)</span>
                <?php endif; ?>
              </td>
              <td>
                <div class="td-actions">
                  <?php if ($note['note_id']): ?>
                    <a href="/notes/delete/<?= esc($note['note_id']) ?>" class="btn btn-secondary btn-sm" style="padding:4px 8px;font-size:12px;color:#ef4444;" onclick="return confirm('Supprimer cette note ?')">Supprimer</a>
                  <?php else: ?>
                    <span style="color:#aaa;font-size:12px;">N/A</span>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div><!-- /table-card -->

    </div><!-- /content -->
  </div><!-- /main -->
</div><!-- /app -->

</body>
</html>

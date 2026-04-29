<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Notes de l'Étudiant</title>
  <link rel="stylesheet" href="/style.css" />
  <style>
    .header-details {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    .info-card {
      background: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="app">

  <!-- ── Sidebar ──────────────────────────────────────────────────────────── -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="logo-icon">
        <svg viewBox="0 0 24 24" width="18" height="18"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      </div>
      <div>
        <div class="brand-name">SysInfo</div>
        <div class="brand-sub">v2.4.0</div>
      </div>
    </div>

    <div class="sidebar-section">Navigation</div>

    <a href="/dashboard" class="nav-item">
      <svg viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
      Tableau de bord
    </a>
    <a href="/etudiants" class="nav-item active">
      <svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
      Etudiants
    </a>

  </aside>

  <!-- ── Main ─────────────────────────────────────────────────────────────── -->
  <div class="main">

    <div class="topbar">
      <div class="topbar-title">Notes de l'étudiant</div>
    </div>

    <div class="content">

      <div class="page-header">
        <div>
          <h2><?= esc($etudiant['nom']) ?> <?= esc($etudiant['prenom']) ?></h2>
          <div class="breadcrumb">Accueil / <a href="/etudiants">Étudiants</a> / <span><?= esc($etudiant['numero_etu']) ?></span></div>
        </div>
      </div>

      <div class="info-card">
        <strong>Numéro Étudiant :</strong> <?= esc($etudiant['numero_etu']) ?><br>
        <strong>Nom :</strong> <?= esc($etudiant['nom']) ?><br>
        <strong>Prénom :</strong> <?= esc($etudiant['prenom']) ?>
      </div>

      <!-- Toolbar filtres par semestre -->
      <div class="toolbar">
        <form action="/notes/etudiant/<?= esc($etudiant['id']) ?>" method="get" class="toolbar-left" style="gap: 10px; display: flex; align-items: center;">
          <label for="semestre">Filtrer par Semestre :</label>
          <select name="semestre" id="semestre" class="filter-select" onchange="this.form.submit()">
            <option value="1" <?= $current_semestre == 1 ? 'selected' : '' ?>>Semestre 3</option>
            <option value="2" <?= $current_semestre == 2 ? 'selected' : '' ?>>Semestre 4</option>
          </select>
        </form>
      </div>

      <!-- Tableau -->
      <div class="table-card">
        <table>
          <thead>
            <tr>
              <th>Code UE</th>
              <th>Matière</th>
              <th>Crédits</th>
              <th>Note</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($notes)): ?>
            <tr>
              <td colspan="5" style="text-align: center;">Aucune UE trouvée pour ce semestre.</td>
            </tr>
            <?php else: ?>
            <?php foreach ($notes as $n): ?>
            <tr>
              <td><?= esc($n['code']) ?></td>
              <td>
                <?= esc($n['libelle']) ?>
                <?php if (isset($n['groupe_libelle']) && $n['groupe_libelle']): ?>
                  <br><small style="color: #666;"><?= esc($n['groupe_libelle']) ?></small>
                <?php endif; ?>
              </td>
              <td><?= esc($n['credits']) ?></td>
              <td>
                <span style="font-weight: bold; <?= $n['max_note'] >= 10 ? 'color: green;' : ($n['max_note'] > 0 ? 'color: red;' : 'color: grey;') ?>">
                  <?= $n['max_note'] > 0 ? number_format($n['max_note'], 2) : '0.00' ?>
                </span>
              </td>
              <td>
                
                <div style="display: flex; gap: 8px; align-items: center;">
                  <?php if ($n['note_id']): ?>
                    <button type="button" class="btn btn-primary btn-sm modify-btn" data-id="<?= esc($n['note_id']) ?>" style="padding: 6px 10px;">Modifier</button>
                    <a href="/notes/delete/<?= esc($n['note_id']) ?>" class="btn btn-secondary btn-sm" style="padding: 6px 10px; background: #ffebee; color: #c62828; border: 1px solid #ffcdd2;" onclick="return confirm('Voulez-vous vraiment supprimer cette note ?');">Supprimer</a>
                  <?php else: ?>
                    <a href="/form" class="btn btn-primary btn-sm" style="padding: 6px 10px;">Ajouter</a>
                  <?php endif; ?>
                </div>

              </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div><!-- /table-card -->

    </div><!-- /content -->
  </div><!-- /main -->
</div><!-- /app -->

</body>
</html>

<script>
document.addEventListener('click', function(e) {
  const btn = e.target.closest('.modify-btn');
  if (!btn) return;
  const noteId = btn.getAttribute('data-id');
  const current = btn.closest('tr').querySelector('td:nth-child(4) span');
  let defaultVal = '';
  if (current) {
    defaultVal = current.textContent.trim();
    if (defaultVal === '0.00') defaultVal = '';
  }

  const val = prompt('Saisissez la nouvelle note (0 - 20):', defaultVal);
  if (val === null) return; // cancelled
  const num = parseFloat(val.replace(',', '.'));
  if (isNaN(num) || num < 0 || num > 20) {
    alert('Valeur invalide. Entrez un nombre entre 0 et 20.');
    return;
  }

  // send POST to edit endpoint
  fetch('/notes/edit/' + encodeURIComponent(noteId), {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
    },
    body: 'note=' + encodeURIComponent(num)
  }).then(function(resp) {
    if (resp.ok) location.reload();
    else resp.text().then(t => alert('Erreur: ' + t));
  }).catch(function(err) { alert('Erreur réseau'); });
});
</script>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SysInfo — Formulaire utilisateur</title>
  <link rel="stylesheet" href="/style.css" />
</head>

<?php helper('form'); ?>

<body>

  <div class="app">

    <!-- ── Sidebar ──────────────────────────────────────────────────────────── -->
    <aside class="sidebar">
      <div class="sidebar-brand">
        <div class="logo-icon">
          <svg viewBox="0 0 24 24" width="18" height="18">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
          </svg>
        </div>
        <div>
          <div class="brand-name">SysInfo</div>
          <div class="brand-sub">v2.4.0</div>
        </div>
        <?php // Vue CodeIgniter 4 pour le formulaire d'ajout de note 
        ?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
          <meta charset="UTF-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <title>SysInfo — Formulaire utilisateur</title>
          <link rel="stylesheet" href="<?= base_url('public/style.css') ?>" />
        </head>

        <body>
          <div class="app">
            <!-- Sidebar -->
            <aside class="sidebar">
              <div class="sidebar-brand">
                <div class="logo-icon">
                  <svg viewBox="0 0 24 24" width="18" height="18">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                  </svg>
                </div>
                <div>
                  <div class="brand-name">SysInfo</div>
                  <div class="brand-sub">v2.4.0</div>
                </div>
              </div>
              <div class="sidebar-section">Navigation</div>
              <a href="<?= base_url('dashboard') ?>" class="nav-item">
                <svg viewBox="0 0 24 24">
                  <rect width="7" height="9" x="3" y="3" rx="1" />
                  <rect width="7" height="5" x="14" y="3" rx="1" />
                  <rect width="7" height="9" x="14" y="12" rx="1" />
                  <rect width="7" height="5" x="3" y="16" rx="1" />
                </svg>
                Tableau de bord
              </a>
              <a href="<?= base_url('users') ?>" class="nav-item">
                <svg viewBox="0 0 24 24">
                  <line x1="8" y1="6" x2="21" y2="6" />
                  <line x1="8" y1="12" x2="21" y2="12" />
                  <line x1="8" y1="18" x2="21" y2="18" />
                  <line x1="3" y1="6" x2="3.01" y2="6" />
                  <line x1="3" y1="12" x2="3.01" y2="12" />
                  <line x1="3" y1="18" x2="3.01" y2="18" />
                </svg>
                Utilisateurs
              </a>
              <a href="<?= base_url('notes/new') ?>" class="nav-item active">
                <svg viewBox="0 0 24 24">
                  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
                Formulaire
              </a>
              <div class="sidebar-section">Modules</div>
              <a href="#" class="nav-item">
                <svg viewBox="0 0 24 24">
                  <path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z" />
                </svg>
                Catalogue
              </a>
              <a href="#" class="nav-item">
                <svg viewBox="0 0 24 24">
                  <line x1="12" y1="1" x2="12" y2="23" />
                  <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
                Comptabilité
              </a>
              <a href="#" class="nav-item">
                <svg viewBox="0 0 24 24">
                  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                  <circle cx="9" cy="7" r="4" />
                  <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                  <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                RH
              </a>
              <a href="#" class="nav-item">
                <svg viewBox="0 0 24 24">
                  <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg>
                Rapports
              </a>
              <div class="sidebar-section">Système</div>
              <a href="#" class="nav-item">
                <svg viewBox="0 0 24 24">
                  <circle cx="12" cy="12" r="3" />
                  <path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14" />
                </svg>
                Paramètres
              </a>
              <div class="sidebar-bottom">
                <a href="<?= base_url('logout') ?>" class="user-row">
                  <div class="avatar">AD</div>
                  <div class="user-info">
                    <div class="name">Admin Sys</div>
                    <div class="role">Super administrateur</div>
                  </div>
                </a>
              </div>
            </aside>
            <!-- Main -->
            <div class="main">
              <div class="topbar">
                <div class="topbar-title">Ajout de note étudiant</div>
                <div class="topbar-search">
                  <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                  </svg>
                  <input type="text" placeholder="Rechercher…" />
                </div>
                <div class="topbar-actions">
                  <button class="icon-btn">
                    <svg viewBox="0 0 24 24">
                      <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                      <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                    </svg>
                  </button>
                  <button class="icon-btn">
                    <svg viewBox="0 0 24 24">
                      <circle cx="12" cy="8" r="4" />
                      <path d="M20 21a8 8 0 1 0-16 0" />
                    </svg>
                  </button>
                </div>
              </div>
              <div class="content">
                <div class="page-header">
                  <div>
                    <h2>Ajout Note</h2>
                    <div class="breadcrumb">Accueil / Note / <span>Cree</span></div>
                  </div>
                  <a href="<?= base_url('users') ?>" class="btn btn-secondary btn-sm">
                    <svg viewBox="0 0 24 24">
                      <polyline points="15 18 9 12 15 6" />
                    </svg>
                    Retour à la liste
                  </a>
                </div>
                <div class="alert alert-info">
                  <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                  </svg>
                  <span>Les champs marqués d'un <strong>*</strong> sont obligatoires. Ce formulaire illustre tous les types de champs disponibles dans le SI.</span>
                </div>
                <?php if (session()->getFlashdata('error')): ?>
                  <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                  </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')): ?>
                  <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                  </div>
                <?php endif; ?>
                <?= form_open('notes/create') ?>
                <div class="form-card section-gap">
                  <div class="form-grid">
                    <div>
                      <label class="field-label">ETU <span class="required">*</span></label>
                      <input type="text" name="etu" value="<?= set_value('etu') ?>" placeholder="Ex : ETU004819" required />
                    </div>
                    <div>
                      <label class="field-label">Semestre <span class="required">*</span></label>
                      <select name="semestre" id="semestreSelect" onchange="updateUEList()" required>
                        <option value="">— Sélectionner —</option>
                        <option value="S3" <?= set_select('semestre', 'S3') ?>>S3</option>
                        <option value="S4" <?= set_select('semestre', 'S4') ?>>S4</option>
                      </select>
                    </div>
                    <div>
                      <label class="field-label">UE <span class="required">*</span></label>
                      <select name="ue" id="ueSelect" required>
                        <option value="">— Sélectionner d'abord un semestre —</option>
                      </select>
                    </div>
                    <div>
                      <label class="field-label">Note </label>
                      <input type="number" name="note" min="0" max="20" value="<?= set_value('note') ?>" />
                    </div>
                  </div>
                </div>

                <div class="form-footer">
                  <a href="<?= base_url('users') ?>" class="btn btn-secondary">Annuler</a>
                  <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24">
                      <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Enregistrer note
                  </button>
                </div>
                <?= form_close() ?>
              </div>
            </div>
          </div>
          <script>
            // Données des UE par semestre
            const uesBySemestre = {
              'S3': <?= $uesBySemestre['S3'] ?>,
              'S4': <?= $uesBySemestre['S4'] ?>
            };

            function updateUEList() {
              const semestreSelect = document.getElementById('semestreSelect');
              const ueSelect = document.getElementById('ueSelect');
              const selectedSemestre = semestreSelect.value;

              // Vider le select des UE
              ueSelect.innerHTML = '';

              if (!selectedSemestre) {
                ueSelect.innerHTML = '<option value="">— Sélectionner d\'abord un semestre —</option>';
                return;
              }

              // Ajouter l'option de sélection
              const defaultOption = document.createElement('option');
              defaultOption.value = '';
              defaultOption.textContent = '— Sélectionner —';
              ueSelect.appendChild(defaultOption);

              // Récupérer les UE du semestre sélectionné
              const uesForSemestre = uesBySemestre[selectedSemestre] || [];

              if (uesForSemestre.length === 0) {
                const noOption = document.createElement('option');
                noOption.disabled = true;
                noOption.textContent = 'Aucune UE disponible';
                ueSelect.appendChild(noOption);
                return;
              }

              // Ajouter les options
              uesForSemestre.forEach(ue => {
                const option = document.createElement('option');
                option.value = ue.libelle;
                option.textContent = ue.code + ' - ' + ue.libelle;
                ueSelect.appendChild(option);
              });
            }

            // Initialiser à l'ouverture de la page si un semestre est sélectionné
            window.addEventListener('DOMContentLoaded', function() {
              const semestreValue = document.getElementById('semestreSelect').value;
              if (semestreValue) {
                updateUEList();
              }
            });
          </script>
          <script src="<?= base_url('public/script.js') ?>"></script>
        </body>

        </html>

      </div>
  </div>
  <div>
    <label class="field-label">Permissions modules</label>
    <div class="checkbox-group">
      <label class="checkbox-option"><input type="checkbox" checked /> Gestion des utilisateurs</label>
      <label class="checkbox-option"><input type="checkbox" checked /> Module Finance</label>
      <label class="checkbox-option"><input type="checkbox" /> Module Stock</label>
      <label class="checkbox-option"><input type="checkbox" /> Module CRM</label>
      <label class="checkbox-option"><input type="checkbox" checked /> Rapports &amp; Analytics</label>
    </div>
  </div>
  </div>
  </div>

  <!-- ── 5. Options & personnalisation ─────────────────────────── -->
  <div class="form-card section-gap">
    <div class="form-section-title">5. Options &amp; personnalisation</div>
    <div class="form-grid">
      <div style="display:flex;flex-direction:column;gap:14px">
        <div class="toggle-wrap">
          <label class="toggle"><input type="checkbox" checked /><span class="toggle-slider"></span></label>
          <span>Compte actif</span>
        </div>
        <div class="toggle-wrap">
          <label class="toggle"><input type="checkbox" checked /><span class="toggle-slider"></span></label>
          <span>Notifications e-mail activées</span>
        </div>
        <div class="toggle-wrap">
          <label class="toggle"><input type="checkbox" /><span class="toggle-slider"></span></label>
          <span>Authentification à deux facteurs (2FA)</span>
        </div>
        <div class="toggle-wrap">
          <label class="toggle"><input type="checkbox" /><span class="toggle-slider"></span></label>
          <span>Accès API externe autorisé</span>
        </div>
        <div class="toggle-wrap">
          <label class="toggle"><input type="checkbox" checked /><span class="toggle-slider"></span></label>
          <span>Journal d'audit activé</span>
        </div>
      </div>
      <div>
        <div style="margin-bottom:20px">
          <label class="field-label">Couleur de profil</label>
          <div class="color-wrap">
            <input type="color" value="#2563eb" />
            <span style="font-size:13px;color:var(--c-muted)">Couleur de l'avatar</span>
          </div>
        </div>
        <div>
          <label class="field-label">Évaluation initiale</label>
          <div class="star-rating" id="stars">
            <span onclick="setStars(1)">★</span>
            <span onclick="setStars(2)">★</span>
            <span onclick="setStars(3)" class="on">★</span>
            <span onclick="setStars(4)">★</span>
            <span onclick="setStars(5)">★</span>
          </div>
          <div class="field-hint">Compétence initiale (1–5)</div>
        </div>
      </div>
    </div>
  </div>

  <!-- ── 6. Texte long & pièces jointes ────────────────────────── -->
  <div class="form-card section-gap">
    <div class="form-section-title">6. Informations complémentaires &amp; pièces jointes</div>
    <div class="form-grid cols-1">
      <div>
        <label class="field-label">Biographie / Remarques</label>
        <textarea placeholder="Décrivez le profil de l'utilisateur, ses compétences, ses remarques particulières…"></textarea>
      </div>
    </div>
    <div class="form-grid">
      <div>
        <label class="field-label">Photo de profil</label>
        <label for="file-photo" class="file-drop">
          <svg viewBox="0 0 24 24">
            <rect width="18" height="18" x="3" y="3" rx="2" />
            <circle cx="8.5" cy="8.5" r="1.5" />
            <polyline points="21 15 16 10 5 21" />
          </svg>
          <p>Déposez une image ici<br /><strong>ou cliquez pour parcourir</strong></p>
          <p style="margin-top:6px;font-size:11px">PNG, JPG — max 5 Mo</p>
          <input id="file-photo" type="file" accept="image/*" />
        </label>
      </div>
      <div>
        <label class="field-label">Documents (contrat, CV…)</label>
        <label for="file-docs" class="file-drop">
          <svg viewBox="0 0 24 24">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
            <polyline points="14 2 14 8 20 8" />
            <line x1="12" y1="18" x2="12" y2="12" />
            <line x1="9" y1="15" x2="15" y2="15" />
          </svg>
          <p>Déposez vos fichiers ici<br /><strong>ou cliquez pour parcourir</strong></p>
          <p style="margin-top:6px;font-size:11px">PDF, DOCX — max 10 Mo</p>
          <input id="file-docs" type="file" accept=".pdf,.doc,.docx" multiple />
        </label>
      </div>
    </div>
  </div>

  <!-- ── Footer boutons ─────────────────────────────────────────── -->
  <div class="form-footer">
    <a href="/list" class="btn btn-secondary">Annuler</a>
    <button type="button" class="btn btn-ghost">Enregistrer comme brouillon</button>
    <button type="submit" class="btn btn-primary">
      <svg viewBox="0 0 24 24">
        <polyline points="20 6 9 17 4 12" />
      </svg>
      Enregistrer l'utilisateur
    </button>
  </div>

  </form>

  </div><!-- /content -->
  </div><!-- /main -->
  </div><!-- /app -->

  <script src="/script.js"></script>
</body>

</html>
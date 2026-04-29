<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Relevé de Notes</title>
    <link rel="stylesheet" href="<?= base_url('public/style.css') ?>">
</head>
<body>
    <div class="container" style="max-width:900px;margin:40px auto;background:#fff;padding:32px 32px 24px 32px;border-radius:12px;box-shadow:0 2px 16px #0001;">
        <h2 style="text-align:center;margin-bottom:32px;">RELEVÉ DE NOTES</h2>
        <div class="header" style="margin-bottom:24px;">
            <div class="student-info" style="font-size:1.1em;">
                <strong>ETU :</strong> <?= isset($etudiant['numero_etu']) ? esc($etudiant['numero_etu']) : '' ?><br>
                <strong>Nom :</strong> <?= isset($etudiant['nom']) ? esc($etudiant['nom']) : '' ?><br>
                <strong>Prénom :</strong> <?= isset($etudiant['prenom']) ? esc($etudiant['prenom']) : '' ?>
            </div>
        </div>

        <form method="get" style="display:flex;gap:24px;align-items:center;margin-bottom:32px;">
            <div>
                <label for="parcours_id"><strong>Parcours :</strong></label>
                <select name="parcours_id" id="parcours_id" class="form-control">
                    <option value="">Tous</option>
                    <?php foreach ($parcoursList as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= (isset($parcours_id) && $parcours_id == $p['id']) ? 'selected' : '' ?>><?= esc($p['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="semestre_id"><strong>Semestre :</strong></label>
                <select name="semestre_id" id="semestre_id" class="form-control">
                    <option value="">Tous</option>
                    <?php foreach ($semestresList as $s): ?>
                        <option value="<?= $s['id'] ?>" <?= (isset($semestre_id) && $semestre_id == $s['id']) ? 'selected' : '' ?>><?= esc($s['numero']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filtrer</button>
        </form>

        <?php
        // Regrouper les notes par semestre (après filtre)
        $parSemestre = [];
        if (!empty($releves)) {
            foreach ($releves as $ligne) {
                $parSemestre[$ligne['semestre_id']][] = $ligne;
            }
        }
        ?>

        <?php if (empty($releves)): ?>
            <div class="alert alert-warning">Aucun relevé trouvé pour ce filtre.</div>
        <?php endif; ?>

        <?php foreach ($parSemestre as $semestre => $ues): ?>
        <div class="section" style="margin-bottom:40px;">
            <table class="table">
                <thead>
                <tr>
                    <th>UE</th>
                    <th>Intitulé</th>
                    <th>Crédits</th>
                    <th>Note /20</th>
                    <th>Résultat</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $somme = 0;
                $total = 0;
                foreach ($ues as $ligne):
                    $note = floatval($ligne['note']);
                    $somme += $note;
                    $total++;
                    $resultat = ($note >= 10) ? 'P' : 'E';
                ?>
                <tr>
                    <td><?= esc($ligne['code']) ?></td>
                    <td><?= esc($ligne['libelle']) ?></td>
                    <td><?= esc($ligne['credits']) ?></td>
                    <td><?= esc($ligne['note']) ?></td>
                    <td><?= $resultat ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="footer" style="margin-top:12px;">
                <p><strong>Semestre :</strong> <?= esc($semestre) ?></p>
            </div>
            <div class="result" style="margin-top:10px;font-weight:bold;">
                <?php
                $moyenne = $total ? round($somme / $total, 2) : 0;
                $mention = ($moyenne >= 10) ? 'Passable' : 'Ajourné';
                ?>
                Résultat : Moyenne générale = <?= $moyenne ?> → <?= $mention ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
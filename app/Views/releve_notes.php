<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Relevé de notes</title>
    <link rel="stylesheet" href="<?= base_url('public/style.css') ?>">
</head>
<body>
    <div class="container">
        <h2>Relevé de notes de l'étudiant n°<?= esc($id_etudiant) ?></h2>
        <?php if (empty($releves)): ?>
            <div class="alert alert-warning">Aucune note trouvée pour cet étudiant.</div>
        <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Semestre</th>
                    <th>Code UE</th>
                    <th>Libellé UE</th>
                    <th>Crédits</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($releves as $ligne): ?>
                <tr>
                    <td><?= esc($ligne['semestre_id']) ?></td>
                    <td><?= esc($ligne['code']) ?></td>
                    <td><?= esc($ligne['libelle']) ?></td>
                    <td><?= esc($ligne['credits']) ?></td>
                    <td><?= esc($ligne['note']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
        <a href="<?= base_url('form') ?>" class="btn btn-secondary">Retour au formulaire</a>
    </div>
</body>
</html>

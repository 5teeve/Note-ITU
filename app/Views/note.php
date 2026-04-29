<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Relevé de Notes</title>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 40px;
        background: #f5f5f5;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .section {
        margin-bottom: 40px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        background: white;
    }

    th, td {
        border: 1px solid #000;
        padding: 6px;
        text-align: center;
    }

    th {
        background: #ddd;
    }

    .result {
        margin-top: 10px;
        font-weight: bold;
    }
</style>

</head>
<body>

<h2>RELEVÉ DE NOTES</h2>
<div class="header">
    <div class="student-info">
        ETU : RAKOTO<br>
        Prénom : Jean
    </div>
</div>

<div class="form-container">
    <div class="form-group">
        <label>Semestre</label>
        <select>
            <option>S1</option>
            <option>S2</option>
            <option>S3</option>
            <option>S4</option>
        </select>
    </div>

    <div class="form-group">
        <label>Option</label>
        <select>
            <option>Informatique</option>
            <option>Réseaux</option>
            <option>Génie Logiciel</option>
        </select>
    </div>
</div>
<div class="section">
    <table>
        <tr>
            <th>UE</th>
            <th>Intitulé</th>
            <th>Crédits</th>
            <th>Note /20</th>
            <th>Résultat</th>
        </tr>

        <tr>
            <td>INF101</td>
            <td>Programmation orientée objet</td>
            <td>6</td>
            <td>14</td>
            <td>P</td>
        </tr>

        <tr>
            <td>INF102</td>
            <td>Base de données</td>
            <td>6</td>
            <td>14.5</td>
            <td>P</td>
        </tr>

        <tr>
            <td>INF103</td>
            <td>Programmation système</td>
            <td>4</td>
            <td>11</td>
            <td>P</td>
        </tr>

        <tr>
            <td>INF104</td>
            <td>Réseaux informatiques</td>
            <td>4</td>
            <td>10</td>
            <td>P</td>
        </tr>

        <tr>
            <td>INF105</td>
            <td>Méthodes numériques</td>
            <td>4</td>
            <td>8</td>
            <td>E</td>
        </tr>
    </table>
<div class="footer">
    <p><strong>Semestre :</strong> S1</p>
    <p><strong>Option :</strong> Informatique</p>
</div>
    <div class="result">
        Résultat : Moyenne générale = 11.24 → Passable
    </div>
</div>


<div class="section">
    <table>
        <tr>
            <th>UE</th>
            <th>Intitulé</th>
            <th>Crédits</th>
            <th>Note /20</th>
            <th>Résultat</th>
        </tr>

        <tr>
            <td>INF201</td>
            <td>Génie logiciel</td>
            <td>6</td>
            <td>12.3</td>
            <td>P</td>
        </tr>

        <tr>
            <td>INF202</td>
            <td>Analyse numérique</td>
            <td>5</td>
            <td>11.2</td>
            <td>P</td>
        </tr>

        <tr>
            <td>INF203</td>
            <td>Maths</td>
            <td>4</td>
            <td>13.1</td>
            <td>P</td>
        </tr>
    </table>
<div class="footer">
    <p><strong>Semestre :</strong> S1</p>
    <p><strong>Option :</strong> Informatique</p>
</div>
    <div class="result">
        Résultat : Moyenne générale = 11.53 → Passable
    </div>
</div>

</body>
</html>
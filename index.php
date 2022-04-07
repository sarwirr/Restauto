<?php 

if(!isset($_POST['nom']) || !isset($_POST['prenom']) || !isset($_POST['nb']) || !isset($_POST['adresse']) || !isset($_POST['type']) || !isset($_FILES['cin'])) {
    header('location:./resa.html');
    return;
}

$nom = htmlentities($_POST['nom']);
$prenom = htmlentities($_POST['prenom']);
$nb = htmlentities($_POST['nb']);
$adresse  = htmlentities($_POST['adresse']);
$type = htmlentities($_POST['type']);
function ingredient_exist($ing) {
    return isset($_POST[$ing]);
}
$ingredients = array_filter(["harissa", "salade", "mayo"], "ingredient_exist");

$filetype = strtolower(pathinfo(basename($_FILES['cin']['name']),PATHINFO_EXTENSION));
$unique_id = uniqid();
$file_name = "uploads/$unique_id.$filetype";
$success = move_uploaded_file($_FILES['cin']['tmp_name'], $file_name);
if (!$success) {
    header('location:./resa.html');
    return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recap Commande</title>
    <style>
        * {
            text-align: start;
        }
        th, td {
            padding-right: 20px;
        }
    </style>
</head>
<body>
    <div>Nom: <?= $nom ?></div>
    <div>Prenom: <?= $prenom ?></div>
    <div>Adresse: <?= $adresse ?></div>
    <table>
        <tr>
            <th colspan="1">Nom</th>
            <th colspan="1">Quantitée</th>
            <th colspan="1">Prix</th>
        </tr>
        <tr>
            <td colspan="1">Sandwich <?= $type ?> (<?= count($ingredients) > 0 ? 'avec '.implode(', ', $ingredients) : 'sans extra' ?>) </td>
            <td colspan="1"><?= $nb?></td>
            <td colspan="1">4 DT</td>
        </tr>
        <tr>
            <th colspan="2">
                <?= $nb < 10 ? "Total:" : "Total avant réduction:" ?>
            </th>
            <td colspan="1">
                <?= ($nb*4)." DT" ?>
            </td>
        </tr>
        <?php 
            if($nb >= 10):
        ?>
                <th colspan="2">Total après réduction:</th>
                <td colspan="1"><?= ($nb*4*0.9)." DT"?></td>
        <?php        
            endif
        ?>
    </table>
</body>
</html>


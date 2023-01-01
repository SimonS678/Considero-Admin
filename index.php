<?php
if ( isset($_GET["action"]) ) {
    include 'config/database.php';

    $sql = "DELETE FROM anzeigen WHERE id=?";
    $stmt= $con->prepare($sql);
    $stmt->execute([$_GET['id']]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
          crossorigin="anonymous">
    <link href="css/styles.css" rel="stylesheet">
    <title>considero ADMIN-BEREICH</title>
    <script>
        function loeschen (id) {
            var check = confirm("Wollen Sie diese Stellenanzeige wirklich loeschen?");
            if (check === true ) {
                document.location.href = "index.php?action=delete&id="+id;
            }
        }
    </script>
</head>
<body>
<div class="container">
    <h1 class="mt-3 mb-3">Considero - Übersicht der Stellenanzeigen</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col"><strong>Headline</strong></th>
            <th scope="col"><strong>Erstellungsdatum</strong></th>
            <th class="last-col" scope="col">
                <a href="form.php" class="btn btn-primary btn-sm">Neue Stellenanzeige</a>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
        include 'config/database.php';
        $query = "SELECT * FROM anzeigen WHERE deutsch = 1 ORDER BY date DESC, id DESC";
        $statement = $con->prepare($query);
        $statement->execute();
        $numberOfRows = $statement->rowCount();

        if ($numberOfRows > 0) {
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<tr>";
                echo "<td>" . $headline . "</td>";
                $newDate=date_create($date);
                echo "<td>" . date_format($newDate,"d.m.Y") . "</td>";
                echo "<td>";
                echo "<a href='form.php?id=".$id."' class='btn btn-primary btn-sm btn-margin'>Bearbeiten</a>";
                echo "<button class='btn btn-secondary btn-sm' onclick='loeschen(".$id.")'>Löschen</button>";
                echo "</td>";
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>

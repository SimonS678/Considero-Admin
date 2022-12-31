<?php
    include 'config/database.php';

    $formHeadline = "Stellenanzeige anlegen";

    // Database columns
    $headline = "";
    $teasertext = "";
    $anzeigentext_oben = "";
    $anzeigentext_unten = "";
    $date = "";
    $pdf = "";

    if(isset($_GET['id'])) {
        $query = "SELECT * FROM anzeigen WHERE id=? LIMIT 0,1";
        $statement = $con->prepare($query);
        $statement->bindParam(1, $_GET['id']);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if($row) {
            extract($row);

            $formHeadline = "Stellenanzeige bearbeiten";
        } else {
            echo "<div class='container'><br><h2>Dieses Stellenangebot konnte leider nicht gefunden werden.</h2></div>";
        }
    }

    if(isset($_POST['action'])) {
        if($_POST['action'] === "insert") {
            echo "IS INSERT";
            $data = [
                'headline' => $_POST['headline'],
                'teasertext' => $_POST['teasertext'],
                'anzeigentext_oben' => $_POST['anzeigentext_oben'],
                'anzeigentext_unten' => $_POST['anzeigentext_unten'],
                'date' => $_POST['date'],
                'pdf' => isset($_POST['pdf']) ? $_POST['pdf'] : "",
                'deutsch' => 1,
                'englisch' => 1,
                'in_referenzen' => 0,
                'in_stellenangebote' => 0,
            ];
            $sql = "INSERT INTO anzeigen (headline, teasertext, anzeigentext_oben, anzeigentext_unten, date, pdf, deutsch, englisch, in_stellenangebote, in_referenzen) 
                    VALUES (:headline, :teasertext, :anzeigentext_oben, :anzeigentext_unten, :date, :pdf, :deutsch, :englisch, :in_stellenangebote, :in_referenzen)";
            $statement= $con->prepare($sql);
            $statement->execute($data);
            header("Location: index.php");
        }

        if($_POST['action'] === "update") {
            echo "IS UPDATE";
        }
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
  <script src="js/tinymce/tinymce.min.js"></script>
  <script>
    tinymce.init({
      selector: '.textareaMCETeaser',
      menubar: false,
      plugins: 'lists link',
      toolbar: 'undo redo bold italic numlist bullist link',
      branding: false,
      height: 180
    });
    tinymce.init({
      selector: '.textareaMCEOben',
      menubar: false,
      plugins: 'lists link',
      toolbar: 'undo redo bold italic numlist bullist link',
      branding: false,
      height: 325
    });
    tinymce.init({
      selector: '.textareaMCEUnten',
      menubar: false,
      plugins: 'lists link powerpaste',
      toolbar: 'undo redo bold italic numlist bullist link powerpaste',
      branding: false,
      height: 520
    });
  </script>
    <title>considero ADMIN-BEREICH</title>
</head>
<body>
<form method="post">
  <div class="container">
    <h1 class="mt-3 mb-3"><?php echo $formHeadline; ?></h1>
    <div class="row">
      <div class="col-lg-6">
        <label for="date">Datum (tt.mm.jjjj):</label>
        <input id="date" name="date" type="date" class="form-control mb-3" value="<?php echo $date; ?>">
        <label for="teaser">Teasertext</label>
        <textarea id="teaser" name="teasertext" rows="4" cols="50" class="form-control mb-3 textareaMCETeaser"><?php echo $teasertext; ?></textarea>
        <label for="textOben">Text oben</label>
        <textarea id="textOben" name="anzeigentext_oben" rows="10" cols="50" class="form-control mb-3 textareaMCEOben"><?php echo $anzeigentext_oben; ?></textarea>
        <div class="mb-5">
          <label><strong>PDF-Datei</strong><br>Bitte nur Dateien mit der Endung .pdf hochladen<br>Die Dateinamen dürfen keine Umlaute, Leerzeichen und Sonderzeichen enthalten</label><br>
          <input type="file">
        </div>
      </div>
      <div class="col-lg-6">
        <label for="ueberschrift">Überschrift</label>
        <textarea id="ueberschrift" name="headline" rows="2" cols="50" class="form-control mb-3"><?php echo $headline ?></textarea>
        <label for="textUnten">Text unten</label>
        <textarea id="textUnten" name="anzeigentext_unten" rows="10" cols="50" class="form-control mb-3 textareaMCEUnten"><?php echo nl2br($anzeigentext_unten); ?></textarea>
        <div class="btn-align">
          <a class="btn btn-secondary" href="index.php">Zurück</a>
          <button class="btn btn-primary" type="submit">Speichern</button>
        </div>
      </div>
        <?php if(isset($_GET['id'])) : ?>
        <input type="hidden" name="action" value="update">
        <?php else :  ?>
        <input type="hidden" name="action" value="insert">
        <?php endif; ?>
</form>

</body>
</html>

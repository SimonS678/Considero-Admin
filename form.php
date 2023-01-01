<?php
include 'config/database.php';

$formHeadline = "Stellenanzeige anlegen";
$errorMsg = "";

// Database columns
$headline = "";
$teasertext = "";
$anzeigentext_oben = "";
$anzeigentext_unten = "";
$date = "";
$pdf = "";

if (isset($_GET['id'])) {
    $query = "SELECT * FROM anzeigen WHERE id=? LIMIT 0,1";
    $statement = $con->prepare($query);
    $statement->bindParam(1, $_GET['id']);
    $statement->execute();

    $row = $statement->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        extract($row);

        $formHeadline = "Stellenanzeige bearbeiten";
    } else {
        echo "<div class='container'><br><h2>Dieses Stellenangebot konnte leider nicht gefunden werden.</h2></div>";
    }
}

if (isset($_POST['action'])) {
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

    if ($_POST['action'] === "insert") {
        $sql = "INSERT INTO anzeigen (headline, teasertext, anzeigentext_oben, anzeigentext_unten, date, pdf, deutsch, englisch, in_stellenangebote, in_referenzen) 
                    VALUES (:headline, :teasertext, :anzeigentext_oben, :anzeigentext_unten, :date, :pdf, :deutsch, :englisch, :in_stellenangebote, :in_referenzen)";
        $statement = $con->prepare($sql);
        $statement->execute($data);
        $lastInsertedId = $con->lastInsertId();
    }

    if ($_POST['action'] === "update") {
        $data['id'] = $_POST['id'];
        $sql = "UPDATE anzeigen SET 
                    headline = :headline, 
                    teasertext = :teasertext, 
                    anzeigentext_oben = :anzeigentext_oben, 
                    anzeigentext_unten = :anzeigentext_unten, 
                    date = :date, 
                    pdf = :pdf, 
                    deutsch = :deutsch, 
                    englisch = :englisch, 
                    in_stellenangebote = :in_stellenangebote, 
                    in_referenzen = :in_referenzen 
                WHERE id = :id";
        $statement = $con->prepare($sql);
        $statement->execute($data);
    }

    if(array_key_exists('pdf', $_FILES) && array_key_exists('name', $_FILES['pdf']) && $_FILES["pdf"]["name"]) {
        $uploadOk = true;
        $stelleId = isset($lastInsertedId) ? $lastInsertedId : $_POST['id'];
        $target_dir = "downloads/".$stelleId."/";
        $target_file = $target_dir . basename($_FILES["pdf"]["name"]);
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $target_path = $_SERVER['DOCUMENT_ROOT'] . "/downloads/" . $stelleId . "/" . basename($_FILES['pdf']['name']);
        $target_dir_full = $_SERVER['DOCUMENT_ROOT'] . "/downloads/" . $stelleId;

        if ($fileType != "pdf") {
            $uploadOk = false;
            $errorMsg = "Bitte verwenden Sie nur PDF-Dateien.";
        }

        if($uploadOk) {
            if (!is_dir($target_dir_full)) {
                mkdir($target_dir_full);
            }

            if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $target_path)) {
                $sql="UPDATE anzeigen SET pdf=? WHERE id=?";
                $statement = $con->prepare($sql);
                $statement->execute([$target_file, $stelleId]);
            } else {
                $errorMsg = "Das PDF konnte leider nicht hochgeladen werden.";
            }

        } else {
            $errorMsg = "Die Datei konnte leider nicht hochgeladen werden. " . $errorMsg;
        }
    }

    if ($errorMsg === "") {
        header("Location: index.php");
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
            plugins: 'lists link paste',
            toolbar: 'undo redo bold italic numlist bullist link',
            branding: false,
            height: 80,
            paste_as_text: true
        });
        tinymce.init({
            selector: '.textareaMCEOben',
            menubar: false,
            plugins: 'lists link paste',
            toolbar: 'undo redo bold italic numlist bullist link',
            branding: false,
            height: 300,
            paste_as_text: true
        });
        tinymce.init({
            selector: '.textareaMCEUnten',
            menubar: false,
            plugins: 'lists link paste',
            toolbar: 'undo redo bold italic numlist bullist link',
            branding: false,
            height: 640,
            paste_as_text: true
        });
    </script>
    <title>considero ADMIN-BEREICH</title>
</head>
<body>
<form method="post" enctype="multipart/form-data">
    <div class="container">
        <?php if ($errorMsg !== "") : ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?php echo $errorMsg; ?>
        </div>
        <?php endif; ?>
        <h1 class="mt-3 mb-3"><?php echo $formHeadline; ?></h1>
        <div class="row">
            <div class="col-lg-6">
                <label for="date">Datum (tt.mm.jjjj):</label>
                <input id="date" name="date" type="date" required class="form-control mb-3" value="<?php echo $date; ?>">
                <label for="teaser">Teasertext</label>
                <textarea id="teaser" name="teasertext" rows="4" cols="50"
                          class="form-control mb-3 textareaMCETeaser"><?php echo $teasertext; ?></textarea>
                <label for="textOben">Text oben</label>
                <textarea id="textOben" name="anzeigentext_oben" rows="10" cols="50"
                          class="form-control mb-3 textareaMCEOben"><?php echo $anzeigentext_oben; ?></textarea>
                <div class="mb-5">
                    <?php if($pdf != "") : ?>
                        <?php
                        $pos = strrpos($pdf, '/');
                        $pdfFilename = $pos === false ? $pdf : substr($pdf, $pos + 1);
                        ?>
                        <p><strong>Aktuelles PDF:</strong> <a href="<?php echo "/".$pdf ?>" target="_blank" style="text-decoration: underline"><?php echo $pdfFilename ?></a></p>
                    <?php endif; ?>
                    <label><strong>PDF-Datei</strong><br>Bitte nur Dateien mit der Endung .pdf hochladen<br>Die
                        Dateinamen dürfen keine Umlaute, Leerzeichen und Sonderzeichen enthalten</label><br>
                    <input type="file" id="pdf" name="pdf">
                </div>
            </div>
            <div class="col-lg-6 mb-5">
                <label for="ueberschrift">Überschrift</label>
                <input id="ueberschrift" required name="headline" class="form-control mb-3" value="<?php echo $headline ?>"/>
                <label for="textUnten">Text unten</label>
                <textarea id="textUnten" name="anzeigentext_unten" rows="10" cols="50"
                          class="form-control mb-3 textareaMCEUnten"><?php echo $anzeigentext_unten; ?></textarea>
                <div class="btn-align">
                    <a class="btn btn-secondary" href="index.php">Zurück</a>
                    <button class="btn btn-primary" type="submit">Speichern</button>
                </div>
            </div>
            <?php if (isset($_GET['id'])) : ?>
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
            <?php else : ?>
                <input type="hidden" name="action" value="insert">
            <?php endif; ?>
</form>

</body>
</html>

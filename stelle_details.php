<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta NAME="description"   CONTENT="Informieren Sie sich jetzt online auf der Homepage der CONSIDERO Executive Search">
    <meta NAME="keywords"   CONTENT="Ricker, Considero, Executive Search, Personalberatung, K&ouml;ln, Gesundheitsindustrie, Personalsuche">
    <meta NAME="publisher"   CONTENT="CONSIDERO Executive Search">
    <meta NAME="copyright"   CONTENT="CONSIDERO Executive Search">
    <meta NAME="page-topic"   CONTENT="Dienstleistung, Personalberatung, Personalsuche">
    <meta NAME="language" CONTENT="de; deutsch">
    <title>CONSIDERO Executive Search</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="../css/composite.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<?php $active = 1; include("../navigation.php"); ?>
<?php include("_social-pusher.php"); ?>
<section>
    <div class="container">
        <div class="row flex-row">

            <div class="col-sm-4 left-content hidden-xs white">
                <?php include("../animation.php"); ?>
            </div>

            <div class="col-xs-12 col-sm-8 main-content colored has-padding-xl">
                <?php
                include '../admin/config/database.php';
                $pdfFilePath = "";

                $query = "SELECT * FROM anzeigen WHERE id=? LIMIT 0,1";
                $statement = $con->prepare($query);
                $statement->bindParam(1, $_GET['id']);
                $statement->execute();

                $row = $statement->fetch(PDO::FETCH_ASSOC);
                if($row) {
                    extract($row);

                    echo nl2br($anzeigentext_oben);
                    echo "<h2>" . $headline . "</h2><br />";
                    echo nl2br($anzeigentext_unten);

                    if(array_key_exists('pdf', $row)) {
                        $pdfFilePath = $pdf;
                    }
                } else {
                    echo "<h2>Dieses Stellenangebot konnte leider nicht gefunden werden.</h2><br><br><br><br><br><br>";
                }
                ?>

                <div class="stelle-abbinder">
                    <div class="stelle-abbinder-links">
                        <?php if($row) : ?>
                        <a href="<?php echo "mailto:info@considero.com?subject=Bewerbung als ".$headline."&body=%0D%0AWir freuen uns über Ihr Interesse an der ausgeschriebenen Position! Senden Sie uns Ihre Bewerbung ausschließlich per Mail an diese Adresse. Die Dateien sollten 10 MB nicht überschreiten. Vielen Dank!%0D%0A%0D%0A" ?>">Jetzt bewerben</a><br>
                        <?php if($pdfFilePath != ""): ?>
                            <a href="<?php echo '/'.$pdf; ?>" target="_blank">Download PDF</a><br>
                        <?php endif; ?>
                        <a href="<?php echo "mailto:?body=%0D%0A".$headline."%0D%0A"."http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."%0D%0A%0D%0A"; ?>">Weiterleiten</a><br>
                        <a href="javascript:window.print()">Drucken</a>
                        <?php endif; ?>
                    </div>
                    <div class="stelle-abbinder-adresse">
                        <strong>CONSIDERO</strong> Personalberatung<br>
                        Ricker, Weber & Gottschlich<br><br>

                        Telefon +49-(0)221-94087-0<br>
                        E-Mail <a href="info@considero.com">info@considero.com</a>
                    </div>
                </div>
                <div class="divider"></div>
                <a href="stellenangebote.php">zurück zu den Stellenangeboten</a>
            </div>

        </div>

    </div>
</section>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-4 main-content">
                <?php include("_footer-content.php"); ?>
            </div>
        </div>
    </div>
</footer>


<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script><script src="../js/animation.js"></script>
<script src="../js/app.js"></script>
<script src="../js/animation.js"></script>

</body>

</html>

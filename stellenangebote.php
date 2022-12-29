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
    <title>CONSIDERO Executive Search - Stellenangebote</title>

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
                <?php include '../animation.php'; ?>
            </div>

            <div class="col-xs-12 col-sm-8 main-content colored has-padding">
                <p>Unsere Vermittlungs-Aufträge im Bereich <strong>Top-Executives</strong> werden üblicherweise verdeckt ausgeführt und sind nicht Bestandteil der nachfolgenden Ausschreibungen.</strong></p>

                <?php
                include '../admin/config/database.php';
                $query = "SELECT * FROM anzeigen WHERE deutsch = 1 ORDER BY date DESC, id DESC";
                $statement = $con->prepare($query);
                $statement->execute();
                $numberOfRows = $statement->rowCount();

                if ($numberOfRows > 0) {
                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<div class='stelle-block'>";
                        echo "<h2>" . $headline . "</h2>";
                        echo "<p>" . $teasertext . "</p>";
                        echo "<a href='stelle_details.php?id=" . $id . "'>Mehr Informationen</a>";
                        echo "<a href='mailto:info@considero.com?subject=Bewerbung als ".$headline."&body=%0D%0AWir freuen uns über Ihr Interesse an der ausgeschriebenen Position! Senden Sie uns Ihre Bewerbung ausschließlich per Mail an diese Adresse. Die Dateien sollten 10 MB nicht überschreiten. Vielen Dank!%0D%0A%0D%0A' style='margin-left: 40px'>Jetzt bewerben</a>";
                        echo "</div>";
                    }
                }
                ?>
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

<?php
require_once ('connect.php');
require_once ('ablogin.php');
session_start();
if (!isset($_SESSION["error"])){
    $_SESSION["error"] = "";
}
if (!isset($_SESSION["admin"])){
    $_SESSION["admin"] = false;
}


if (isset($_REQUEST['login']) && isset($_REQUEST['pass'])){
    login($_POST['login'], $_POST['pass']);
}

global $yhendus;

//andmete lisamine tabelisse
if(isset($_REQUEST['lisamisvorm']) &&!empty($_REQUEST['loomatuup'] &&!empty($_REQUEST['nimi']) &&!empty($_REQUEST['vanus'] &&!empty($_REQUEST['silmadevarv'])))){
    $paring=$yhendus->prepare(
        "INSERT INTO loomaaed(loomatuup,loomanimi,vanus,silmadevarv,pilt) Values (?,?,?,?,?)"
    );
    $paring->bind_param("ssiss",$_REQUEST["loomatuup"],$_REQUEST["nimi"],$_REQUEST["vanus"],$_REQUEST["silmadevarv"],$_REQUEST["pilt"]);
    //("s",$_REQUEST["nimi"]) - "s" - string - tekstikastiga "nimi"
    $paring->execute();
}

//kustutamine
if(isset($_REQUEST['kustuta'])) {
    $paring = $yhendus->prepare("DELETE FROM loomaaed WHERE id=?");
    $paring->bind_param('i', $_REQUEST['kustuta']);
    $paring->execute();
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Loomaaed</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="modal.css">
</head>
<body>
<header>
    <h1>Loomaaed</h1>
    <nav>
    </nav>
</header>
<div id="menuArea" style="position:absolute; top:355px ;left:25px;">
    <?php
    if (isset($_SESSION["kasutaja"])){
        ?>
        <h2> <?="$_SESSION[kasutaja]"?> on sisse logitud</h2>
        <a href="logout.php">Logi välja</a>
        <?php
    }
    ?>
</div>
<?php
if (!isset($_SESSION["kasutaja"])){
    ?>
    <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;position:absolute; top:25px ;left:25px;">Logi Sisse</button>
    <?php
}
?>
<div id="id01" class="modal">

    <form class="modal-content animate" action="" method="post">
        <div class="imgcontainer">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Login">&times;</span>
        </div>

        <div class="container">
            <label for="login"><b>Kasutajanimi</b></label>
            <input type="text" placeholder="Kasutajanimi" name="login" id="login" required>
            <label for="pass"><b>Parool</b></label>
            <input type="password" placeholder="Parool" name="pass" id="pass" required>
            <input class="modal-submit" type="submit" value="Logi Sisse"><button type="button" class="modal-submit" onclick="document.getElementById('id01').style.display='none'">Tühista</button>
            <input class="register" type="button" onclick="window.location.href='https://saiko21.thkit.ee/loomaaed/register.php';" value="Register" />
        </div>
        <div class="container" style="background-color:#f1f1f1">
        </div>
    </form>
</div>
<table>
    <tr>
        <th>
            Loomatüüp
        </th>
        <th>
            Looma Nimi
        </th>
        <th>
            Vanus
        </th>
        <th>
            Pilt
        </th>
        <th>
            Silmadevärv
        </th>
    </tr>

    <?php
    // tabeli sisu näitamine
    global $yhendus;
    $kask = $yhendus->prepare('
SELECT id, loomaNimi, vanus, loomatuup, silmadevarv, pilt FROM loomaaed');
    $kask->bind_result($id, $loomaNimi, $vanus, $loomatuup, $silmadevarv, $pilt);
    $kask->execute();
    while ($kask->fetch()) {
        echo "<tr>";
        echo "<td>" . $loomatuup . "</td>";
        echo "<td>" . $loomaNimi . "</td>";
        echo "<td>" . $vanus . "<br></td>";
        $kommentaarid = nl2br(htmlspecialchars($loomatuup));
        echo "<td> <img width='150'  src='$pilt' alt='pilt'></td>";
        echo "<td>" . $silmadevarv . "</td>";

        echo "</tr>";
    }
    ?>
<style>
    body {
        height: 125vh;
        background-size: cover;
        font-family: sans-serif;
        margin-top: 80px;
        padding: 30px;
    }

    main {
        color: white;
    }

    header {
        background-color: white;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 80px;
        display: flex;
        align-items: center;
        box-shadow: 0 0 25px 0 black;
    }

    input[type=text], select {
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type=submit] {
        background-color: #000;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    table {
            width: 100%;
            border-collapse: collapse;
        }
        /* Zebra striping */
        th {
            background: #333;
            color: white;
            font-weight: bold;
        }
        td, th {
            padding: 6px;
            border: 1px solid #ccc;
            text-align: left;
        }

</style>
</body>
</html>
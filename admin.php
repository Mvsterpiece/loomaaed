<?php
require_once('connect.php');

if (!empty($_REQUEST['lisamisvorm'])){
    global $yhendus;
    $kask=$yhendus->prepare("INSERT INTO loomaaed(loomatuup,loomanimi,vanus,silmadevarv,pilt) Values (?,?,?,?,?)");
    $kask->bind_param("ssiss",$_REQUEST["loomatuup"],$_REQUEST["nimi"],$_REQUEST["vanus"],$_REQUEST["silmadevarv"],$_REQUEST["pilt"]);
    $kask->execute();

    header("Location: $_SERVER[PHP_SELF]");

}
//punktide nulliks
if (isset($_REQUEST['punkt0'])) {
    global $yhendus;
    $kask = $yhendus->prepare('
UPDATE tantsud SET punktid=0 WHERE id=?');
    $kask->bind_param("s", $_REQUEST['punkt0']);
    $kask->execute();

    header("Location: $_SERVER[PHP_SELF]");
}

//peitmine
if (isset($_REQUEST['peitmine'])) {
    global $yhendus;
    $kask = $yhendus->prepare('
UPDATE tantsud SET avalik=0 WHERE id=?');
    $kask->bind_param("i", $_REQUEST['peitmine']);
    $kask->execute();

    header("Location: $_SERVER[PHP_SELF]");
}

//näitamine
if (isset($_REQUEST['naitamine'])) {
    global $yhendus;
    $kask = $yhendus->prepare('
UPDATE tantsud SET avalik=1 WHERE id=?');
    $kask->bind_param("i", $_REQUEST['naitamine']);
    $kask->execute();

    header("Location: $_SERVER[PHP_SELF]");
}

//kustutamine paari
if (isset($_REQUEST["kustutusid"])) {
    global $yhendus;
    $kask = $yhendus->prepare("DELETE FROM loomaaed WHERE id=?");
    $kask->bind_param("s", $_REQUEST['kustutusid']);
    $kask->execute();

    header("Location: $_SERVER[PHP_SELF]");
}


//kommentaari kustutamine
if (isset($_REQUEST['komment0'])) {
    global $yhendus;
    $kask = $yhendus->prepare('
UPDATE loomaaed SET silmadevarv="" WHERE id=?');
    $kask->bind_param("s", $_REQUEST['komment0']);
    $kask->execute();

    header("Location: $_SERVER[PHP_SELF]");
}

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Loomaaed</title>
</head>
<body>
<header>
    <h1>Loomaaed</h1>
    <nav>
        <ul>
            <li>

            </li>
            <li>

            </li>
        </ul>
        <ul>
            <li>

            </li>
        </ul>
        <ul>
            <li>

            </li>
        </ul>
        <ul>
            <li>

            </li>
        </ul>
        <ul>
            <li>

            </li>
        </ul>
        <ul>
            <li>

            </li>
        </ul>
        <ul>
            <li>

            </li>
        </ul>
        <ul>
            <li>

            </li>
        </ul>
        <ul>
            <li>

            </li>
        </ul>
        <ul>
            <li>

            </li>
        </ul>
        <ul>
            <li>

            </li>
        </ul>
        <ul>
            <li>

            </li>
        </ul>
        <ul>
            <li>

            </li>
        </ul>
        <ul>
            <li>
                <form action="logout.php" method="post">
                    <input type="submit" value="Logi välja" name="logout">
                </form>
            </li>
        </ul>
    </nav>
</header>
<table>
    <tr>
        <th>
            Kustutamine
        </th>
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
        ?>
        <td><a style="color: black" href="?kustutusid=<?=$id ?>"
               onclick="return confirm('Kas ikka soovid kustutada?')">Kustutada</a>
        </td>
        <?php
        echo "<td>" . $loomatuup . "</td>";
        echo "<td>" . $loomaNimi . "</td>";
        echo "<td>" . $vanus . "<br></td>";
        $kommentaarid = nl2br(htmlspecialchars($loomatuup));
        echo "<td> <img width='150'  src='$pilt' alt='pilt'></td>";
        echo "<td>" . $silmadevarv . "</td>";

        echo "</tr>";
    }
    ?>
</table>
<?php
    //tabeli looma lisamine
    echo "<div class='name'>";
    echo "<h2>Uue looma lisamine</h2>";
    echo "<form name='lisamisvorm'method='post' action='?'>";
            echo "<input type='hidden' name='lisamisvorm' value='jah'>";
            echo "<input type='text' name='loomatuup' placeholder='Loomatüüp'>";
            echo "<br>";
            echo "<input type='text' name='nimi' placeholder='Looma nimi'>";
            echo "<br>";
            echo "<input type='text' name='vanus' placeholder='Looma vanus'>";
            echo "<br>";
            echo "<textarea name='pilt'>Siia lisa pildi aadress.</textarea>";
            echo "<br>";
            echo "<label>Vali silmadevärv.</label>";
            echo "<input type='color' id='varv' name='silmadevarv'>";
            echo "<br>";
            echo "<input type='submit' value='OK'>";
    echo "</form>";
echo "</div>";
    ?>

    <style>

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

        header * {
            display: inline;
        }

        header li {
            margin: 20px;
        }

        header li a {
            color: black;
            text-decoration: none;
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


    </style>
</body>
</html>
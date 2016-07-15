<?php include '../config.php'; ?>
<?php include '../header.php'; ?>


    <div class="general-content">
        <h1>Le morpion</h1>
        <h2>Explications sur l'exercice</h2>
        <p>Faire un jeu de morpion, l'adversaire est l'ordinateur, il n'y a pas deux joueurs.
        </p>
        <h2>Faire une partie</h2>

        <?php
        // first launch and game reset
        if (isset($_GET["rejouer"]) || empty($_GET)) {
            session_destroy();
            session_start();
            $_SESSION['z'] = array('vide', 'vide', 'vide', 'vide', 'vide', 'vide', 'vide', 'vide', 'vide');
        }

        // gets play move and launches function move
        if (isset($_GET['z'])) {
            $play = $_GET['z'];
            move($play);
        }

        // shows cicles and crosses
        function zone($z)
        {
            return $_SESSION['z'][$z - 1];
        }

        // agressive-defensive AI
        function smartai()
        {
            $p1 = array(0, 1, 0, 3, 5, 4, 6, 7, 6, 0, 3, 0, 1, 4, 1, 2, 5, 2, 0, 4, 0, 2, 4, 2);
            $p2 = array(1, 2, 2, 4, 3, 5, 7, 8, 8, 3, 6, 6, 4, 7, 7, 5, 8, 8, 4, 8, 8, 4, 6, 6);
            $v = array(2, 0, 1, 5, 4, 3, 8, 6, 7, 6, 0, 3, 7, 1, 4, 8, 2, 5, 8, 0, 4, 6, 2, 4);
            $result = false;
            if ($_SESSION['z'][4] == 'vide') {
                $_SESSION['z'][4] = 'rond';
                $result = true;
            }
            for ($j = 0; $j < 24; $j++) {
                if ($result == false && $_SESSION['z'][$p1[$j]] == $_SESSION['z'][$p2[$j]] && $_SESSION['z'][$p1[$j]] == 'rond') {
                    if ($_SESSION['z'][$v[$j]] == 'vide') {
                        $_SESSION['z'][$v[$j]] = 'rond';
                        $result = true;
                        break;
                    }
                }
            }
            for ($j = 0; $j < 24; $j++) {
                if ($result == false && $_SESSION['z'][$p1[$j]] == $_SESSION['z'][$p2[$j]] && $_SESSION['z'][$p1[$j]] == 'croix') {
                    if ($_SESSION['z'][$v[$j]] == 'vide') {
                        $_SESSION['z'][$v[$j]] = 'rond';
                        $result = true;
                        break;
                    }
                }
            }
            return $result;
        }

        // changes global var state, dumb AI plus victory conditions
        function move($play)
        {
            $play = $play - 1;
            if ($_SESSION['z'][$play] == 'vide') {
                $_SESSION['z'][$play] = 'croix';
                if (smartai() == false) {
                    for ($i = 1; $i < 10; $i++) {
                        $rand = rand(0, 8);
                        if ($_SESSION['z'][$rand] == 'vide') {
                            $_SESSION['z'][$rand] = 'rond';
                            break;
                        }
                    }
                }
            }
            if ($_SESSION['z'][0] == $_SESSION['z'][1] && $_SESSION['z'][0] == $_SESSION['z'][2]) {
                winlose(0);
            }
            if ($_SESSION['z'][3] == $_SESSION['z'][4] && $_SESSION['z'][5] == $_SESSION['z'][4]) {
                winlose(4);
            }
            if ($_SESSION['z'][6] == $_SESSION['z'][7] && $_SESSION['z'][8] == $_SESSION['z'][7]) {
                winlose(6);
            }
            if ($_SESSION['z'][0] == $_SESSION['z'][3] && $_SESSION['z'][6] == $_SESSION['z'][3]) {
                winlose(0);
            }
            if ($_SESSION['z'][1] == $_SESSION['z'][4] && $_SESSION['z'][7] == $_SESSION['z'][4]) {
                winlose(1);
            }
            if ($_SESSION['z'][2] == $_SESSION['z'][5] && $_SESSION['z'][8] == $_SESSION['z'][5]) {
                winlose(2);
            }
            if ($_SESSION['z'][0] == $_SESSION['z'][4] && $_SESSION['z'][8] == $_SESSION['z'][4]) {
                winlose(0);
            }
            if ($_SESSION['z'][2] == $_SESSION['z'][4] && $_SESSION['z'][6] == $_SESSION['z'][4]) {
                winlose(2);
            }
        }

        // win or lose buttons
        function winlose($num)
        {
            if ($_SESSION['z'][$num] == 'croix') {
                echo '<div style="text-align:center;margin-bottom:30px;width:100%;"><a href="/morpion/?rejouer=ok" class="btn btn-info" style="font-size:50px;padding-left:100px;padding-right:100px;">Bravo, tu as gagné !!<br>Rejouer une partie</a></div><table id="center">';
            } else if ($_SESSION['z'][$num] == 'rond') {
                echo '<div style="text-align:center;margin-bottom:30px;width:100%;"><a href="/morpion/?rejouer=ok" class="btn btn-info" style="font-size:50px;padding-left:100px;padding-right:100px;">PERDU LOSER !!<br>Rejouer une partie</a></div><table id="center">';
            }
        }

        ?>
        <table id="center">
            <tbody>
            <tr>
                <td class="carre" id="Zonea1"><a href="/morpion/?z=1"><img src="/img/<?= zone(1); ?>.png"></a></td>
                <td class="carre" id="Zonea2"><a href="/morpion/?z=2"><img src="/img/<?= zone(2); ?>.png"></a></td>
                <td class="carre" id="Zonea3"><a href="/morpion/?z=3"><img src="/img/<?= zone(3); ?>.png"></a></td>
            </tr>
            <tr>
                <td class="carre" id="Zoneb1"><a href="/morpion/?z=4"><img src="/img/<?= zone(4); ?>.png"></a></td>
                <td class="carre" id="Zoneb2"><a href="/morpion/?z=5"><img src="/img/<?= zone(5); ?>.png"></a></td>
                <td class="carre" id="Zoneb3"><a href="/morpion/?z=6"><img src="/img/<?= zone(6); ?>.png"></a></td>
            </tr>
            <tr>
                <td class="carre" id="Zonec1"><a href="/morpion/?z=7"><img src="/img/<?= zone(7); ?>.png"></a></td>
                <td class="carre" id="Zonec2"><a href="/morpion/?z=8"><img src="/img/<?= zone(8); ?>.png"></a></td>
                <td class="carre" id="Zonec3"><a href="/morpion/?z=9"><img src="/img/<?= zone(9); ?>.png"></a></td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- Fin php -->
    <script>
        $(document).ready(function () {
            $('.menu-link').menuFullpage();
        });
    </script>
<?php include '../footer.php'; ?>
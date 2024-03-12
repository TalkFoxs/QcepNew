<footer>
    <?php
    $protadaVista = new PortadaVista();
    $protadaModel = new PortadaModel();
    $result = $protadaModel->read();
    $html = '';
    foreach ($result as $key => $value) {
        foreach ($value as $k => $var) {
            if ($k == "icono") {
                $ruta = $var;
            }
            else if ($k == "enllac") {
                $enllac = $var;
            }
            else if ($k = "descripcio") {
                $desc = $var;
            }
        }
        $html .= "<a href='{$enllac}'><img src='{$ruta}'target='_blank' title='{$desc}'></a>";
    }
    echo $html;

    ?>
</footer>
</body>

</html>
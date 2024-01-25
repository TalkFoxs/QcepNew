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
            if ($k == "enllac") {
                $enllac = $var;
            }
        }
        $html .= "<a href='{$enllac}'><img src='{$ruta}'target='_blank'></a>";
    }
    echo $html;

    ?>
</footer>
</body>

</html>
<?php
        $contentContainer= $_POST["contentContainer"];
        echo '<table>';
        foreach($contentContainer["elements"] as $maps){ ?>
            <tr>
                <td><?php echo $maps["name"]; ?></td>
                <td onclick='$("#secondary_content").load("Views/showMap.php", {"map": <?php echo json_encode($maps) ?>})'>Pokaż</td>
            </tr>
        <?php }
        echo '</table>';
?>
            <button>Dodaj mapę</button>
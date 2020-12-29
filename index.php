<!DOCTYPE html>
<html>
    <head>
        <?php

        $files = scandir("./data");

        foreach ($files as $file) {
            echo "<a href=viewData.php?date=" . $file . ">" . $file . "</a>";
            echo "<br>";
        }

        ?>
    </head>
</html>
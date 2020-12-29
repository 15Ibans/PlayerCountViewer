<!DOCTYPE html>
<html>

<head>

    <?php
    $file = htmlspecialchars($_GET["date"]);
    $raw_json = file_get_contents("./data/" . $file);
    $minified =  json_encode(json_decode($raw_json));
    ?>

    <script src="./dist/Chart.min.js"></script>
    <canvas id="myChart" width="395" height="190"></canvas>
    <script>
        function resize() {

            var canvas = document.getElementById("myChart");
            var canvasRatio = canvas.height / canvas.width;
            var windowRatio = window.innerHeight / window.innerWidth;
            var width;
            var height;

            if (windowRatio < canvasRatio) {
                height = window.innerHeight;
                width = height / canvasRatio;
            } else {
                width = window.innerWidth;
                height = width * canvasRatio;
            }

            canvas.style.width = width + 'px';
            canvas.style.height = height + 'px';
        };

        window.addEventListener('resize', resize, false);

        function timeFromUnix(timestamp) {
            let date = new Date(parseFloat(timestamp) * 1000);
            return date.toLocaleTimeString("en-GB");
        }

        function randomColor() {
            return "#000000".replace(/0/g, function() {
                return (~~(Math.random() * 16)).toString(16);
            });
        }

        function getPlayerCounts(input) {
            let ret = "[";
            let i = 0;
            for (var server in input) {
                let label = server;
                let playerCount = Object.keys(input[label]).map(function(key) {
                    return input[label][key];
                });
                ret += "{\"label\": \"" + label + "\", \"borderColor\": \"" + randomColor() + "\", \"data\": " + JSON.stringify(playerCount) + "}";
                if (i !== Object.keys(input).length - 1) {
                    ret += ",";
                }
                i++;
            }
            ret += "]";
            return JSON.parse(ret);
        }

        let fileName = "<?php echo $file;?>";
        let ctx = document.getElementById("myChart").getContext("2d");

        let theData = JSON.parse('<?php echo $minified; ?>');
        let lineChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: Object.keys(theData[Object.keys(theData)[0]]).map(function(time) {
                    return timeFromUnix(time)
                }),
                datasets: getPlayerCounts(theData)
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Player Counts for ' + fileName.substr(0, fileName.lastIndexOf("."))
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Time'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Player Count'
                        }
                    }]
                }
            }
        });
    </script>
</head>

<body>
</body>

</html>
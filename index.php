<!DOCTYPE html>
<html>
    <head>
        <?php
        $raw_json = file_get_contents("./2020-12-26.json");
        $minified =  json_encode(json_decode($raw_json));
        ?>
        <script src="./dist/Chart.min.js"></script>
        <canvas id="myChart" width="400" height="400"></canvas>
        <script>
            function timeFromUnix(timestamp) {
                let date = new Date(parseFloat(timestamp) * 1000);
                return date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds(); 
            }

            function randomColor() {
                return "#000000".replace(/0/g,function(){return (~~(Math.random()*16)).toString(16);});
            }

            function getPlayerCounts(input) {
                let ret = "[";
                let i = 0;
                for (var server in input) {
                    let label = server;
                    let playerCount = Object.keys(input[label]).map(function (key) {
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

            let ctx = document.getElementById("myChart").getContext("2d");

            let theData = JSON.parse('<?php echo $minified;?>');
            let lineChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: Object.keys(theData[Object.keys(theData)[0]]).map(function(time) { return timeFromUnix(time) }),
                    datasets: getPlayerCounts(theData)
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Chart.js Line Chart'
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
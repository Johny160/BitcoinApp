<?php
    $url = "https://www.bitstamp.net/api/v2/ticker/btcusd/";
    $fgc = file_get_contents($url);
    $json = json_decode($fgc, true);

    $price = $json["last"];
    $high = $json["high"];
    $low = $json["low"];
    $date = date("m-d-Y - h:i:sa");
    $open = $json["open"];

    if($open < $price) {
        //price went up
        $indicator = "+ ";
        $change = $price - $open;
        $percent = $change / $open;
        $percentCalc = $percent * 100;
        $percentChange = $indicator.number_format($percent, 2);
        $color = "green";
    }

    if($open > $price) {
        //price went down
        $indicator = "- ";
        $change = $open - $price;
        $percent = $change / $open;
        $percentCalc = $percent * 100;
        $percentChange = $indicator.number_format($percent, 2);
        $color = "red";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Bitcoin price</title>
</head>
<body>
    <div id="container">
        <table>
            <tr>
                <td rowspan="3" id="lastPrice">$ <?php echo $price; ?></td>
                <td align="right" style="color: <?php echo $color;?>"><?php echo $percentChange; ?> %</td>
            </tr>
            <tr>
                <td align="right">$ <?php echo $high; ?></td>
            </tr>
            <tr>
                <td align="right">$ <?php echo $low; ?></td>
            </tr>
            <tr>
                <td colspan="2" align="right" id="timeData"><?php echo $date; ?></td>
            </tr>
        </table>
    </div>

    <script>
        $('document').ready(function (){
            refreshData();
        });
        
        function refreshData(){
            $('#container').load("index.php", function(){
                setTimeout(refreshData, 2500);
            });
        }
    </script>
</body>
</html>
<?php
require_once("../connection/connect.php");
session_start();
if (!isset($_SESSION["email"])) {
    header("Location:../front/userlogin.php");
}
$user = "SELECT * FROM userlogin WHERE email=:email";
$stmt = $conn->prepare($user);
$stmt->execute(
    array(
        ':email' => $_SESSION["email"]
    )
);
foreach ($stmt as $row) {
    $name = $row["firstname"] . " " . $row["lastname"];
}

$chart = "SELECT count(dtype) as dcount, dtype from deals where dresponsible='$name' group by dtype";
$analysis = $conn->prepare($chart);
$analysis->execute();
$chartarray = $analysis->fetchAll(PDO::FETCH_ASSOC);

$total = "SELECT sum(damount) as tamount,dtype from deals where dresponsible='$name' group by dtype";
$amt = $conn->prepare($total);
$amt->execute();
$tamountarray = $amt->fetchAll(PDO::FETCH_ASSOC);

$sum = 0;
foreach ($tamountarray as $key => $amount) {
    $sum += $amount['tamount'];
}
$totalsum = $sum - floatval($tamountarray[0]['tamount']);
?>
<!DOCTYPE html>
<html>

<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Deals', 'count'],
            <?php foreach ($chartarray as $key => $val) { ?>['<?php echo $val['dtype'] ?>',
                <?php echo $val['dcount'] ?>],
            <?php } ?>
        ]);
        var options = {
            width: 450,
            height: 240,
            chartArea: {
                width: "100%",
                height: "80%"
            },
            legend: {
                'position': 'bottom'
            },
            colors: ['rgb(220, 57, 18)', 'rgb(16, 150, 24)', 'rgb(255, 153, 0)', 'rgb(51, 102, 204)'],
            is3D: true
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
    </script>

    <title> Analytics | C3</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Items | C3 </title>
    <link rel="icon" href="../images/logo.svg">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
    </style>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/analytics.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <!--<button class="btn" id="menu" style="font-size:24px"><i class="fa fa-bars"></i></button>-->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="../front/dashboard.php">Home<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Project Management
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="projects.php"><i class='far'>&#xf2bb;</i> Projects</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="tasks.php"><i class='fa'>&#xf0ae;</i> Tasks</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="solutions.php"><i class='far'>&#xf15c;</i> Solutions</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        CRM
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="deals.php"><i class='fas'>&#xf5bf;</i> Deals</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="invoice.php"><i class='fas'>&#xf1ec;</i> Invoice</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class='fas'>&#xf0b0;</i> Analysis</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../front/customers.php"><i class='fas'>&#xf756;</i> Customers</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Product Management
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../front/items.php"><i class='fas'>&#xf0c0;</i> Items</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Human Resources
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../front/employee.php"><i class='fas'>&#xf0c0;</i> Employees</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $name ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="logout.php"><i style='font-size:24px' class='fas'>&#xf2f5;</i>
                            Log out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="d-flex" id="wrapper">
        <div id="page-content-wrapper">
            <div class="header">
                <i class='fa'> &#xf201;</i> ANALYSIS
            </div>
            <div class="container-fluid">
                <div id="deals-analytics">
                    <div id="deals-analysis-header-main">
                        <span id="deals-analysis-header">DEALS ANALYSIS</span>
                    </div>
                    <div class="charts" id="charts">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="piechart" style="width: 900px; height: 500px;"></div>
                            </div>
                            <div class="col-md-6" id="block-elements">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="amount-title">
                                            Total value of deals
                                        </div>
                                        <div id="amount">
                                            $<span><?php echo floatval(($totalsum)); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div id="win-amount-title">
                                            Total of deals won
                                        </div>
                                        <div id="win-amount">
                                            $<span><?php echo floatval($tamountarray[1]['tamount']); ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="progress-amount-title">
                                            Total of deals progress
                                        </div>
                                        <div id="progress-amount">
                                            $<span><?php echo floatval($tamountarray[2]['tamount']); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script src="../js/deals.js"></script>
</body>

</html>
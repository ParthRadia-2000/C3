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
?>
<!DOCTYPE html>
<html>

<head>
    <title> Deals | C3</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../images/logo.svg">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
    </style>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/deals.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
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
                        <a class="dropdown-item" href="#"><i class='fas'>&#xf5bf;</i> Deals</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="invoice.php"><i class='fas'>&#xf1ec;</i> Invoice</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="analytics.php"><i class='fas'>&#xf0b0;</i> Analysis</a>
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
                <i class='fa'> &#xf5bf;</i> DEALS
            </div>
            <div class="container-fluid">
                <div class="kanban">
                    <div class="row">
                        <div class="col-md-3" id="div-new">
                            <div class="board-column" id="board-column">
                                <div class="board-title" id="board-title-new">
                                    New
                                </div>
                                <div class="board-value" id="board-value-new">
                                    $<span>0</span>
                                </div>
                                <div id="content-new">
                                </div>
                                <div class="board-card" id="board-card-new">
                                    <div id="add-deals-new" data-toggle="modal" data-target="#new">
                                        +
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="new" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Deal</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="client">Client</label>
                                                            <input type="text" class="form-control" placeholder="Client"
                                                                id="client">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="company">Company</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Company" id="company">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="dealname">Deal Name</label>
                                                            <input type="text" class="form-control" placeholder="Deal"
                                                                id="deal">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="amount">Amount in($)</label>
                                                            <input type="text" class="form-control" placeholder="Amount"
                                                                id="amount">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="responsible">Responsible</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="Responsible Person"
                                                                value="<?php echo $name ?>" id="responsible"
                                                                readonly="readonly">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="probability">Probability</label>
                                                            <input type="text" class="form-control"
                                                                placeholder="pobability" id="probability">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="startdate">Start Date</label>
                                                            <input type="date" class="form-control"
                                                                placeholder="Start Date" id="sdate">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="dealtype">Deal Type</label>
                                                            <input type="text" class="form-control" value="New"
                                                                id="dtype" readonly="readonly">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary"
                                                    id="save-new">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" id="div-progress">
                            <div class="board-column" id="board-column">
                                <div class="board-title" id="board-title-progress">
                                    In Progress
                                </div>
                                <div class="board-value" id="board-value-progress">
                                    $<span>0</span>
                                </div>
                                <div id="content-progress">
                                </div>
                                <div class="board-card" id="board-card-progress">
                                    <div id="add-deals-progress" data-toggle="modal" data-target="#progress">
                                        +
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="progress" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Deal</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="client">Client</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Client" id="p-client">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="company">Company</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Company" id="p-company">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="dealname">Deal Name</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Deal" id="p-deal">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="amount">Amount in($)</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Amount" id="p-amount">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="responsible">Responsible</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Responsible Person"
                                                                    value="<?php echo $name ?>" id="p-responsible"
                                                                    readonly="readonly">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="probability">Probability</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="pobability" id="p-probability">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="startdate">Start Date</label>
                                                                <input type="date" class="form-control"
                                                                    placeholder="Start Date" id="p-sdate">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="dealtype">Deal Type</label>
                                                                <input type="text" class="form-control"
                                                                    value="InProgress" id="p-dtype" readonly="readonly">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="save-progress">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" id="div-win">
                            <div class="board-column" id="board-column">
                                <div class="board-title" id="board-title-win">
                                    Deal Won
                                </div>
                                <div class="board-value" id="board-value-win">
                                    $<span>0</span>
                                </div>
                                <div id="content-win">
                                </div>
                                <div class="board-card" id="board-card-win">
                                    <div id="add-deals-win" data-toggle="modal" data-target="#won">
                                        +
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="won" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Deal</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="client">Client</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Client" id="w-client">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="company">Company</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Company" id="w-company">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="dealname">Deal Name</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Deal" id="w-deal">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="amount">Amount in($)</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Amount" id="w-amount">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="responsible">Responsible</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Responsible Person"
                                                                    value="<?php echo $name ?>" id="w-responsible"
                                                                    readonly="readonly">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="probability">Probability</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="pobability" id="w-probability">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="startdate">Start Date</label>
                                                                <input type="date" class="form-control"
                                                                    placeholder="Start Date" id="w-sdate">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="dealtype">Deal Type</label>
                                                                <input type="text" class="form-control" value="DealWon"
                                                                    readonly="readonly" id="w-dtype">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="save-won">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3" id="div-lost">
                            <div class="board-column" id="board-column">
                                <div class="board-title" id="board-title-lost">
                                    Deal Lost
                                </div>
                                <div class="board-value" id="board-value-lost">
                                    $<span>0</span>
                                </div>
                                <div id="content-lost">
                                </div>
                                <div class="board-card-lost">
                                    <div id="add-deals-lost" data-toggle="modal" data-target="#lost">
                                        +
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="lost" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Deal</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="client">Client</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Client" id="l-client">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="company">Company</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Company" id="l-company">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="dealname">Deal Name</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Deal" id="l-deal">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="amount">Amount in($)</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Amount" id="l-amount">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="responsible">Responsible</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Responsible Person"
                                                                    value="<?php echo $name ?>" id="l-responsible"
                                                                    readonly="readonly">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="probability">Probability</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="pobability" id="l-probability">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="startdate">Start Date</label>
                                                                <input type="date" class="form-control"
                                                                    placeholder="Start Date" id="l-sdate">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="dealtype">Deal Type</label>
                                                                <input type="text" class="form-control" value="DealLost"
                                                                    readonly="readonly" id="l-dtype">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="save-lost">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="form-lost">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script src="../js/deals.js"></script>
    <!-- Modal -->
    <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Deal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="client">Client</label>
                                <input type="text" class="form-control" placeholder="Client" id="u-client">
                            </div>
                            <div class="col-md-6">
                                <label for="company">Company</label>
                                <input type="text" class="form-control" placeholder="Company" id="u-company">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="dealname">Deal Name</label>
                                <input type="text" class="form-control" placeholder="Deal" id="u-deal">
                            </div>
                            <div class="col-md-6">
                                <label for="amount">Amount in($)</label>
                                <input type="text" class="form-control" placeholder="Amount" id="u-amount">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="startdate">Start Date</label>
                                <input type="date" class="form-control" placeholder="Start Date" id="u-sdate">
                            </div>
                            <div class="col-md-6">
                                <label for="dealtype">Deal Type</label>
                                <input type="text" class="form-control" name="dtype" id="u-dtype">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-lost">Save</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
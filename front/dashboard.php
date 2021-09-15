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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard | C3 </title>
    <link rel="icon" href="../images/logo.svg">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <div class="d-flex" id="wrapper">
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link" href="../front/dashboard.php">Home<span
                                    class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Project Management
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="../front/projects.php"><i class='far'>&#xf2bb;</i>
                                    Projects</a>
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
                                <a class="dropdown-item" href="../front/deals.php"><i class='fas'>&#xf5bf;</i> Deals</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="invoice.php"><i class='fas'>&#xf1ec;</i> Invoice</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="analytics.php"><i class='fas'>&#xf0b0;</i> Analysis</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../front/customers.php"><i class='fas'>&#xf756;</i>
                                    Customers</a>
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
                                <a class="dropdown-item" href="../front/employee.php"><i class='fas'>&#xf0c0;</i>
                                    Employees</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $name ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="logout.php"><i style='font-size:24px'
                                        class='fas'>&#xf2f5;</i> Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="header">
                <i class='fa'>&#xf518;</i> MY AGENDA
            </div>
            <div class="container-fluid">
                <div class="row-content">
                    <div class="main-content" id="main-content">
                        <div id="calender-content">
                            <!--Model Add-->
                            <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Add Event</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="title" class="col-sm-2 control-label">Title</label>
                                                <div class="col-sm-12">
                                                    <input type="text" name="title" class="form-control" id="title"
                                                        placeholder="Title">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="color" class="col-sm-2 control-label">Color</label>
                                                <div class="col-sm-12">
                                                    <select name="color" class="form-control" id="color">
                                                        <option value="">Choose</option>
                                                        <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue
                                                        </option>
                                                        <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise
                                                        </option>
                                                        <option style="color:#008000;" value="#008000">&#9724; Green
                                                        </option>
                                                        <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow
                                                        </option>
                                                        <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange
                                                        </option>
                                                        <option style="color:#FF0000;" value="#FF0000">&#9724; Red
                                                        </option>
                                                        <option style="color:#000;" value="#000">&#9724; Black</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="start" class="col-sm-4 control-label">Start date</label>
                                                <div class="col-sm-12">
                                                    <input type="text" name="start" class="form-control" id="start"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="end" class="col-sm-4 control-label">End date</label>
                                                <div class="col-sm-12">
                                                    <input type="text" name="end" class="form-control" id="end"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" id="event-creator"
                                                    value=<?php echo $_SESSION["email"] ?>>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary"
                                                    id="add-event">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--Model Add End-->
                            </div>
                            <div id="list-content" style="background-color:yellow">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#wrapper -->
        <!--Model Edit-->
        <div class="modal fade" id="eventEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit event</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" class="form-control" id="id">
                            <label for="title" class="col-sm-4 control-label">Title</label>
                            <div class="col-sm-12">
                                <input type="text" name="title" class="form-control" id="title-edit"
                                    placeholder="Title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="color" class="col-sm-4 control-label">Color</label>
                            <div class="col-sm-12">
                                <select name="color" class="form-control" id="color">
                                    <option value="">Choose</option>
                                    <option style="color:#0071c5;" value="#0071c5">&#9724; Dark blue</option>
                                    <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquoise</option>
                                    <option style="color:#008000;" value="#008000">&#9724; Green</option>
                                    <option style="color:#FFD700;" value="#FFD700">&#9724; Yellow</option>
                                    <option style="color:#FF8C00;" value="#FF8C00">&#9724; Orange</option>
                                    <option style="color:#FF0000;" value="#FF0000">&#9724; Red</option>
                                    <option style="color:#000;" value="#000">&#9724; Black</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <input type="checkbox" id="delete" name="delete">
                                    <label for="delete" class="text-danger"> Delete event</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="edit-event">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Model Edit End-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
        </script>
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
        <script src="../js/dashboard.js"></script>
</body>

</html>
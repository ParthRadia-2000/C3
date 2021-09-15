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

$project = "SELECT projectid,project_title FROM projects where project_created_by='$name'";
$dropdown = $conn->prepare($project);
$dropdown->execute();
$drop = $dropdown->fetchAll(PDO::FETCH_ASSOC);


$employee = "SELECT id,firstname,lastname FROM employees where createdby='$name'";
$dropemp = $conn->prepare($employee);
$dropemp->execute();
$emp = $dropemp->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tasks | C3 </title>
    <link rel="icon" href="../images/logo.svg">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
    </style>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/tasks.css">
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
                        <a class="dropdown-item" href="../front/projects.php"><i class='far'>&#xf2bb;</i> Projects</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class='fa'>&#xf0ae;</i> Tasks</a>
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
                <i class='fa'> &#xf0ae;</i> TASKS
            </div>
            <div class="container-fluid">
                <div class="project-details">
                    <butoon class="add-project" data-toggle="modal" data-target="#AddTask"><i class='fas'>&#xf055;</i>
                        Assign Task</button>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row-content">
                    <div class="main-content" id="main-content">
                        <div class="table-responsive">
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">Action</th>
                                        <th scope="col" id="element-id">Task id</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Start-date</th>
                                        <th scope="col">End-date</th>
                                        <th scope="col" type="hidden" id="element-id">projectid</th>
                                        <th scope="col">Project</th>
                                        <th scope="col">Receiver</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">AssignOn</th>
                                        <th scope="col">Sender</th>
                                        <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                </tbody>
                            </table>
                        </div>
                        <!---ADD TASK MODEL START-->
                        <div class="modal fade bd-example-modal-lg" id="AddTask" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Assign Task</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="taskname">Task title</label>
                                                    <input type="text" class="form-control" id="title"
                                                        placeholder="Task title">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="taskdescription">Task description</label>
                                                    <textarea type="text" class="form-control"
                                                        id="description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="startdate">Start date</label>
                                                    <input type="date" class="form-control" id="sdate">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="enddate">End date</label>
                                                    <input type="date" class="form-control" id="edate">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="project">Project</label>
                                                    <select name="project" class="form-control" id="task-project">
                                                        <?php
                                                        foreach ($drop as $val) {
                                                        ?>
                                                        <option
                                                            value='<?php echo $val['projectid'] ?><?php echo " "; ?><?php echo $val['project_title'] ?>'>
                                                            <?php echo $val['projectid'] . ' ' .  $val['project_title'] ?>
                                                        </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="project">Task receiver</label>
                                                    <select name="project" class="form-control" id="receiver">
                                                        <?php
                                                        foreach ($emp as $val) {
                                                        ?>
                                                        <option
                                                            value='<?php echo $val['firstname'] ?><?php echo " "; ?><?php echo $val['lastname'] ?>'>
                                                            <?php echo $val['firstname'] . ' ' . $val['lastname']; ?>
                                                        </option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="taskstatus">Task status</label>
                                                    <input type="text" class="form-control" readonly="readonly"
                                                        id="status" value="Assigned">
                                                    <!--<select name="status" class="form-control" id="status">
                                                            <option vaalue="assigned">Assigned</option>
                                                            <option vaalue="completed">Completed</option>
                                                        </select>-->
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="assigndate">Date of assignment</label>
                                                    <input type="text" class="form-control" id="adate"
                                                        value='<?php echo date('Y-m-d'); ?>' readonly="readonly">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="assigner">Task sender</label>
                                                    <input type="text" class="form-control" id="sender"
                                                        value='<?php echo $name; ?>' readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="add">Assign Task</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!---ADD TASK MODEL END-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---EDIT PROJECT MODEL START-->
    <div class="modal fade bd-example-modal-lg" id="update" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="taskname">Task id</label>
                                <input type="text" class="form-control" id="u-id" readonly="readonly">
                            </div>
                            <div class="col-md-6">
                                <label for="taskname">Project id</label>
                                <input type="text" class="form-control" id="u-p-id" readonly="readonly">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="taskname">Task title</label>
                                <input type="text" class="form-control" id="u-title" placeholder="Task title">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="taskdescription">Task description</label>
                                <textarea type="text" class="form-control" id="u-description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="startdate">Start date</label>
                                <input type="date" class="form-control" id="u-sdate">
                            </div>
                            <div class="col-md-6">
                                <label for="enddate">End date</label>
                                <input type="date" class="form-control" id="u-edate">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <!--<div class="col-md-6">
                                                    <label for="project">Project</label>
                                                    <select name="project" class="form-control" id="u-task-project">
                                                            <?php
                                                            foreach ($drop as $val) {
                                                            ?>
                                                                <option value='<?php echo $val['project_title'] ?>'><?php echo $val['project_title'] ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                    </select>
                                                </div>-->
                            <div class="col-md-12">
                                <label for="project">Task receiver</label>
                                <select name="project" class="form-control" id="u-receiver">
                                    <?php
                                    foreach ($emp as $val) {
                                    ?>
                                    <option
                                        value='<?php echo $val['firstname'] ?><?php echo " "; ?><?php echo $val['lastname'] ?>'>
                                        <?php echo $val['firstname'] . ' ' . $val['lastname']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <input type="checkbox" id="delete" name="delete">
                                    <label for="delete" class="text-danger"> Delete Project</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="edit">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!---EDIT PROJECT MODEL END-->
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
</script>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
<script src="../js/tasks.js"></script>
<html>
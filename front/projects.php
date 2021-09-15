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

$project = "SELECT * FROM projects where project_created_by='$name'";
$draw_chart = $conn->prepare($project);
$draw_chart->execute();
$chart = $draw_chart->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Projects | C3 </title>
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
    <link rel="stylesheet" href="../css/projects.css">

    <!--CHART-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {
        'packages': ['gantt']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task ID');
        data.addColumn('string', 'Task Name');
        data.addColumn('string', 'Resource');
        data.addColumn('date', 'Start Date');
        data.addColumn('date', 'End Date');
        data.addColumn('number', 'Duration');
        data.addColumn('number', 'Percent Complete');
        data.addColumn('string', 'Dependencies');
        <?php foreach ($chart as $key => $val) {
                $start_date = $val['project_start_date'];
                $start_year = date('Y', strtotime($start_date));
                $start_month = date('m', strtotime($start_date)) - 1;
                $start_day = date('d', strtotime($start_date));
                $end_date = $val['project_end_date'];
                $end_year = date('Y', strtotime($end_date));
                $end_month = date('m', strtotime($end_date)) - 1;
                $end_day = date('d', strtotime($end_date));

                $id = $val["projectid"];
                $project_count = "SELECT task_title FROM tasks where task_project_id=$id";
                $p_count = $conn->prepare($project_count);
                $p_count->execute();
                $p = $p_count->fetchAll();

                $pro_count = 0;
                foreach ($p as $pp) {
                    $pro_count += 1;
                }
                //echo $pro_count;
                $complete_project = "SELECT task_title FROM tasks where task_project_id=$id AND task_status='Completed'";
                $complete = $conn->prepare($complete_project);
                $complete->execute();
                $c = $complete->fetchAll();

                $count_completed = 0;
                foreach ($c as $cc) {
                    $count_completed += 1;
                }
                $assigned_project = "SELECT task_title FROM tasks where task_project_id=$id AND task_status='Assigned'";
                $assi = $conn->prepare($assigned_project);
                $assi->execute();
                $a = $assi->fetchAll();
                $assign_count = 0;
                foreach ($a as $aa) {
                    $assign_count += 1;
                }
                $final_count = ((($count_completed) / $pro_count) * 100);
            ?>
        data.addRows([
            ['<?php echo $val["projectid"] ?>',
                '<?php echo $val["project_title"] ?>',
                'null',
                new Date(<?php echo $start_year ?>, <?php echo $start_month ?>, <?php echo $start_day ?>),
                new Date(<?php echo $end_year ?>, <?php echo $end_month ?>, <?php echo $end_day ?>),
                null,
                <?php echo $final_count ?>,
                null
            ]
        ]);
        <?php } ?>
        var options = {
            height: 400,
        }
        var chart = new google.visualization.Gantt(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
    </script>
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
                        <a class="dropdown-item" href="#"><i class='far'>&#xf2bb;</i> Projects</a>
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
                <i class='fa'>&#xf2bb;</i> PROJECTS
            </div>
            <div class="container-fluid">
                <div class="project-details">
                    <butoon class="add-project" data-toggle="modal" data-target="#AddProject"><i
                            class='fas'>&#xf055;</i> Add Project</button>
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
                                        <th scope="col">Title</th>
                                        <th scope="col" type="hidden" id="element-id">Id</th>
                                        <th scope="col">Start-date</th>
                                        <th scope="col">End-date</th>
                                        <th scope="col">CreatedOn</th>
                                        <th scope="col">CreatedBy</th>
                                        <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">

                                </tbody>
                            </table>
                        </div>
                        <!---ADD PROJECT MODEL START-->
                        <div class="modal fade bd-example-modal-lg" id="AddProject" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Project</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="id">Project Id</label>
                                                    <input type="text" class="form-control" id="project-id"
                                                        placeholder="This is auto generated id" required readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="projectname">Project title</label>
                                                    <input type="text" class="form-control" id="title"
                                                        placeholder="Project title">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="projectdescription">Project description</label>
                                                    <textarea class="form-control" id="description"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="startdate">Start Date</label>
                                                    <input type="date" class="form-control" id="s-date"
                                                        value='<?php echo date('Y-m-d'); ?>'>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="enddate">End date</label>
                                                    <input type="date" class="form-control" id="e-date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="createdon">Created on</label>
                                                    <input type="text" class="form-control" id="createdon"
                                                        value='<?php echo date('Y-m-d'); ?>' readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="createdby">Created By</label>
                                                    <input type="text" class="form-control" id="createdby"
                                                        value='<?php echo $name ?>' readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="add">Add Project</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!---ADD PROJECT MODEL END-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="project-analysis" id="pro-analysis">
            <span id="p-analysis">Project analysis</span>
        </div>
        <div class="container-fluid">
            <div id="chart_div" style="margin:20px;"></div>
        </div>
    </div>
    </div>
    <!---EDIT PROJECT MODEL START-->
    <div class="modal fade bd-example-modal-lg" id="update" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="id">Project Id</label>
                                <input type="text" class="form-control" id="u-project-id"
                                    placeholder="This is auto generated id" required readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="projectname">Project title</label>
                                <input type="text" class="form-control" id="u-title" placeholder="Project title">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="projectdescription">Project description</label>
                                <textarea class="form-control" id="u-description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="startdate">Start Date</label>
                                <input type="date" class="form-control" id="u-s-date"
                                    value='<?php echo date('Y-m-d'); ?>'>
                            </div>
                            <div class="col-md-6">
                                <label for="enddate">End date</label>
                                <input type="date" class="form-control" id="u-e-date">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script src="../js/projects.js"></script>
</body>

</html>
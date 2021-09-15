<?php
require("../connection/connect.php");
session_start();

if (!isset($_SESSION["emp_email"])) {
    header("Location:../front/employeelogin.php");
}
$email = $_SESSION['emp_email'];
$employee = "SELECT id,firstname,lastname,createdby FROM employees where email = '$email'";
$stmt = $conn->prepare($employee);
$stmt->execute();
foreach ($stmt as $val) {
    $emp_name = $val['firstname'] . ' ' . $val['lastname'];
    $emp_company = $val['createdby'];
}

if (isset($_POST["save"])) {
    $file_task = $_POST["title"];

    // name of the uploaded file
    $filename = $_FILES['file']['name'];


    // destination of the file on the server
    $destination = 'F:\xamppinstall\htdocs\C3\front\uploads/'  . $filename;

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['file']['tmp_name'];

    $size = $_FILES['file']['size'];
    if ($_FILES['file']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
        echo '<script>alert("FILE IS TOO LARGE!")</script>';
    } else {
        if (move_uploaded_file($file, $destination)) {
            $query = "INSERT INTO files(task_id,project_title,task_title,file_s_date,file_employee,file_name,file_size,file_company)
                VALUES(:tid,:tptitle,:ttitle,:fsdate,:femployee,:fname,:fsize,:fcompany)";
            $stmt = $conn->prepare($query);
            $stmt->execute(
                array(
                    ':tid' => $_POST["id"],
                    ':tptitle' => $_POST["p-title"],
                    ':ttitle' => $_POST["title"],
                    ':fsdate' => $_POST["s-date"],
                    ':femployee' => $_POST["task-submitter"],
                    ':fname' => $filename,
                    ':fsize' => $size,
                    ':fcompany' => $_POST["task-company"]
                )
            );
        }
        $update = "UPDATE tasks SET task_status='Completed' WHERE task_id=:tid";
        $statement = $conn->prepare($update);
        $statement->execute(
            array(
                'tid' => $_POST["id"]
            )
        );
        if ($statement) {
            echo '<script>alert("TASK SOLUTION SUBMITTED SUCCESSFULLY")</script>';
        } else {
            echo '<script>alert("AILED WHILE UPLOADING TASK SOKUTION")</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Employee Dashboard | C3</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/employeedashboard.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand"><?php echo $emp_name; ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="employeelogout.php" style="font-size:24px;"><span
                            class="glyphicon glyphicon-log-out"></span>Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="page-content-wrapper">
        <div class="header">
            <i class='fa'> &#xf0ae;</i> TASKS
        </div>
        <div class="container-fluid">
            <div class="row-content">
                <div class="table-responsive">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">Action</th>
                                <th scope="col" id="element-id">Id</th>
                                <th scope="col">Title</th>
                                <th scope="col">Project</th>
                                <th scope="col">Assign Date</th>
                                <th scope="col">Description</th>
                            </tr>
                        </thead>
                        <tbody id="table-data">

                        </tbody>
                    </table>
                </div>
                <div class="modal" id="solution" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Submit Solution</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="#" method="POST" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="id">Task Id</label>
                                            <input type="text" class="form-control" name="id" id="id"
                                                readonly="readonly">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="tasktitle">Task title</label>
                                            <input type="text" class="form-control" name="title" id="title"
                                                placeholder="Task title" readonly="readonly">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="projecttitle">Project title</label>
                                            <input type="text" class="form-control" name="p-title" id="p-title"
                                                placeholder="Task title" readonly="readonly">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="submissiondate">Submission Date</label>
                                            <input type="text" class="form-control" name="s-date" id="s-date"
                                                value='<?php echo date('Y-m-d') ?>' readonly="readonly">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="file">Employee</label>
                                            <input type="text" class="form-control" name="task-submitter"
                                                id="task-submitter" value="<?php echo $emp_name; ?>"
                                                readonly="readonly">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="file">Company</label>
                                            <input type="text" class="form-control" name="task-company"
                                                id="task-company" value="<?php echo $emp_company; ?>"
                                                readonly="readonly">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="file">Solution</label>
                                            <input type="file" class="form-control" name="file" id="file" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="save">Submit</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script src="../js/employeedashboard.js"></script>
</body>

</html>
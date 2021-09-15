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
    <title>Customers | C3 </title>
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
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/customers.css">
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
                        <a class="dropdown-item" href="deals.php"><i class='fas'>&#xf5bf;</i> Deals</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="invoice.php"><i class='fas'>&#xf1ec;</i> Invoice</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="analytics.php"><i class='fas'>&#xf0b0;</i> Analysis</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class='fas'>&#xf756;</i> Customers</a>
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
                <i class='fa'> &#xf756;</i> CUSTOMERS
            </div>
            <div class="container-fluid">
                <div class="item-details">
                    <butoon class="add-customer" data-toggle="modal" data-target="#AddCustomer"><i
                            class='fas'>&#xf055;</i> Add New Customer</button>
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
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">status</th>
                                        <th scope="col">Industry</th>
                                        <th scope="col">SalesRep.</th>
                                        <th scope="col">Address</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                </tbody>
                            </table>
                        </div>
                        <!--Modal start-->
                        <div class="modal fade bd-example-modal-lg" id="AddCustomer" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="id">Customer Id</label>
                                                    <input type="text" class="form-control" id="c-id"
                                                        placeholder="This is auto generated id" readonly="readonly">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="customername">Customer Name</label>
                                                    <input type="text" class="form-control" id="c-name"
                                                        placeholder="Customer Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="salesrep">Sales Rep.</label>
                                                    <input type="text" class="form-control" id="salesrep"
                                                        value="<?php echo $name ?>" readonly="readonly">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="status">Status</label>
                                                    <select name="status" class="form-control" id="status">
                                                        <option value="Active">Active</option>
                                                        <option value="Inactive">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="phone">Phone</label>
                                                    <input type="tel" class="form-control" id="phone" maxlength="10">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="productmanager">Email</label>
                                                    <input type="text" class="form-control" id="email"
                                                        placeholder="Email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="industry">Industry</label><br>
                                                    <select name="industry" class="form-control" id="industry">
                                                        <option value="Aerospace & Defense">Aerospace & Defense</option>
                                                        <option value="Electonic Equip./ Components">Electonic Equip./
                                                            Components</option>
                                                        <option value="Energy/Netural Resources">Energy/Netural
                                                            Resources</option>
                                                        <option value="Environmental Protection">Environmental
                                                            Protection</option>
                                                        <option value="Films $ Entertainment">Films $ Entertainment
                                                        </option>
                                                        <option value="Financial Services">Financial Services</option>
                                                        <option value="Food Services & Product">Food Services & Product
                                                        </option>
                                                        <option value="Health Care Services">Health Care Services
                                                        </option>
                                                        <option value="Computer Hardware Or Software">Computer Hardware
                                                            Or Software</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="address">Address</label><br>
                                                    <input type="text" class="form-control" id="address"
                                                        placeholder="Address">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary" id="add">Add Customer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Modal End-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Modal edit start-->
    <div class="modal fade bd-example-modal-lg" id="EditCustomer" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="customername">Customer Name</label>
                                <input type="text" class="form-control" id="edit-c-name" placeholder="Customer Name">
                            </div>
                            <div class="col-md-6">
                                <label for="productmanager">Email</label>
                                <input type="text" class="form-control" id="edit-email" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" id="edit-status">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="phone">Phone</label>
                                <input type="tel" class="form-control" id="edit-phone" maxlength="10">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="industry">Industry</label><br>
                                <select name="industry" class="form-control" id="edit-industry">
                                    <option value="Aerospace & Defense">Aerospace & Defense</option>
                                    <option value="Electonic Equip./ Components">Electonic Equip./ Components</option>
                                    <option value="Energy/Netural Resources">Energy/Netural Resources</option>
                                    <option value="Environmental Protection">Environmental Protection</option>
                                    <option value="Films $ Entertainment">Films $ Entertainment</option>
                                    <option value="Financial Services">Financial Services</option>
                                    <option value="Food Services & Product">Food Services & Product</option>
                                    <option value="Health Care Services">Health Care Services</option>
                                    <option value="Computer Hardware Or Software">Computer Hardware Or Software</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="address">Address</label><br>
                                <input type="text" class="form-control" id="edit-address" placeholder="Address">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <input type="checkbox" id="delete" name="delete">
                                    <label for="delete" class="text-danger"> Delete Customer</label>
                                </div>
                                <input type="hidden" name="c-name" class="form-control" id="ref-name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!--Modal edit End-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script src="../js/customers.js"></script>
</body>

</html>
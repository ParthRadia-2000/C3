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
$date = date("Y-m-d");
?>
<!Doctype html>
<html>

<head>
    <title>
        Contracts | C3
    </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Items | C3 </title>
    <link rel="icon" href="../images/logo.svg">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css">
    </style>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--EXTERNAL CSS-->
    <link rel="stylesheet" href="../css/contracts.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn" id="menu" style="font-size:24px"><i class="fa fa-bars"></i></button>
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
                        <a class="dropdown-item" href="#"><i class='far'>&#xf017;</i> Timesheets</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        CRM
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="../front/contracts.php"><i class='fas'>&#xf5bf;</i> Contracts</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class='fas'>&#xf0fe;</i> Oppertunities</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class='fas'>&#xf0c0;</i> Contacts</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class='fas'>&#xf1ad;</i> Contect Center</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class='fas'>&#xf0b0;</i> Leads</a>
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
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i style='font-size:24px' class='fas'>&#xf2f5;</i> Log out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">C3</div>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action bg-light"><i
                        style='font-size:24px; margin-right:4px;' class='fa'>&#xf518;</i>My Agenda</a>
                <a href="#" class="list-group-item list-group-item-action bg-light"><i style="font-size:24px"
                        class="fa">&#xf1ea;</i>
                    News Feed</a>
                <a href="#" class="list-group-item list-group-item-action bg-light"><i style="font-size:24px"
                        class="fa">&#xf073;</i>
                    Calender</a>
                <a href="#" class="list-group-item list-group-item-action bg-light"><i style='font-size:24px'
                        class='fa'>&#xf0ae;</i>
                    Tasks</a>
                <a href="#" class="list-group-item list-group-item-action bg-light"><i
                        class="material-icons">&#xe0b0;</i>Call Logs</a>
                <a href="#" class="list-group-item list-group-item-action bg-light"><i
                        style='font-size:24px; margin-right:4px;' class='fas'>&#xf02d;</i>Notes</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="header">
                <i class='fa'>&#xf5bf;</i> CONTRACTS
            </div>
            <div class="container-fluid">
                <div class="item-details">
                    <div class="dropdown">
                        <butoon class="dropbtn" id="add-contract"><i class='fas'>&#xf055;</i> Add New Item</button>
                            <div class="dropdown-content" id="content">
                                <a data-toggle="modal" href="#retainer">Retainer Contract</a>
                                <a data-toggle="modal" href="#sales">Sales Contract</a>
                            </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row-content">
                    <div class="main-content" id="main-content">
                        <div class="table-responsive">
                            <table class="table" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col">Item</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Manager</th>
                                        <th scope="col">Cost</th>
                                        <th scope="col">Taxcode</th>
                                        <th scope="col">Size</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Billtype</th>
                                        <th scope="col">Condition</th>
                                        <th scope="col">Inventory type</th>
                                        <th scope="col">Sale</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">

                                </tbody>
                            </table>
                            <!-- Sales contract modal start-->
                            <div class="modal fade bd-example-modal-lg" id="sales" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Sales contract</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="title1">
                                                <i class="fa fa-angle-down"></i> Contract Information
                                            </div>
                                            <div class="content1">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="salesid">Contract id</label>
                                                            <input type="text" class="form-control" id="salesid"
                                                                placeholder="Auto generated number" readonly="readonly">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="salesrep">Sales Rep.</label>
                                                            <input type="text" class="form-control" id="salesrep"
                                                                value="<?php echo $name ?>" readonly="readonly">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="employee">Employee</label>
                                                            <input type="text" class="form-control" id="employee"
                                                                value="<?php echo $name ?>" readonly="readonly">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="customer">Customer</label>
                                                            <input type="text" class="form-control" id="customer">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="name">Name</label>
                                                            <input type="text" class="form-control" id="name">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="status">status</label>
                                                            <select name="status" class="form-control" id="status">
                                                                <option value="Draft">Draft</option>
                                                                <option value="Sent for signature">Sent for signature
                                                                </option>
                                                                <option value="Execured">Execured</option>
                                                                <option value="Expired">Expired</option>
                                                                <option value="Canceled">Canceled</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="employee">Effective Date</label>
                                                            <input type="date" class="form-control" id="date"
                                                                value="<?php echo $date ?>">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="customer">Invoice timing</label>
                                                            <select name="invoice" class="form-control" id="status">
                                                                <option value="At the bigining of the period">At the
                                                                    bigining of the period</option>
                                                                <option value="At the end of the period">At the end of
                                                                    the period</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="title2">
                                                <i class="fa fa-angle-right"></i> Items
                                            </div>
                                            <div class="content2">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>tile</label>
                                                            <input type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="title3">
                                                <i class="fa fa-angle-right"></i> Terms & Renewal
                                            </div>
                                            <div class="content3">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label>tile</label>
                                                            <input type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="add">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Sales contract modal end-->
                        </div>
                        <div class="contract-content">
                            <!--Retainer Contract Modal Start-->
                            <div class="modal fade bd-example-modal-lg" id="retainer" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Retainer contract</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="id">Item Id</label>
                                                        <input type="text" class="form-control" id="item-id"
                                                            placeholder="This is auto generated id" required readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="itemname">Item Name</label>
                                                        <input type="text" class="form-control" id="item-name"
                                                            placeholder="Item Name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="price">Price(INR)</label>
                                                        <input type="text" class="form-control" id="price"
                                                            placeholder="0.00">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="standardcost">Standard Cost(INR)</label>
                                                        <input type="text" class="form-control" id="stdcost"
                                                            placeholder="0.00">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="taxcode">Tax Code</label>
                                                        <input type="text" class="form-control" id="taxcode">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="productmanager">Product Manager</label>
                                                        <input type="text" class="form-control" id="manager"
                                                            value="<?php echo $name ?>" readonly="readonly">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="forsale">Enabled For Sale</label><br>
                                                        <span id="sale"><input type="radio" name="radio-btn" value="yes"
                                                                checked> YES</span>
                                                        <span id="sale"><input type="radio" name="radio-btn" value="no">
                                                            NO</span>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="forbill">Bill of Materials Type</label><br>
                                                        <span><input type="radio" name="rbtn" value="standard" id="bill"
                                                                checked> STANDARD</span>
                                                        <span><input type="radio" name="rbtn" value="configurable"
                                                                id="bill"> CONFIGURABLE</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="size">Size</label>
                                                        <input type="text" class="form-control" placeholder="size"
                                                            id="size">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="color">Color</label>
                                                        <input type="text" class="form-control" placeholder="color"
                                                            id="color">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Condition</label>
                                                        <select name="condition" class="form-control" id="condition">
                                                            <option value="new">New</option>
                                                            <option value="refurbished">Refurbished</option>
                                                            <option value="used">Used</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label>Inventory type</label>
                                                        <select name="inventory" class="form-control" id="inventory">
                                                            <option value="purchased">Purchased</option>
                                                            <option value="drop shipped">Drop shipped</option>
                                                            <option value="manufactured">Manufactured</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="add">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Retainer Contract Modal End-->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
    <script src="../js/contracts.js"></script>
    <!--Sales Contract Modal Start-->

    <!--Sales Contract Modal End-->
</body>

</html>
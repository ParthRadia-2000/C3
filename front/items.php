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
    <title>Items | C3 </title>
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
    <link rel="stylesheet" href="../css/items.css">
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
                        <a class="dropdown-item" href="../front/customers.php"><i class='fas'>&#xf756;</i> Customers</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Product Management
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#"><i class='fas'>&#xf0c0;</i> Items</a>
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
                <i class='fa'> &#xf07a;</i> ITEMS
            </div>
            <div class="container-fluid">
                <div class="item-details">
                    <butoon class="add-item" data-toggle="modal" data-target="#AddItem"><i class='fas'>&#xf055;</i> Add
                        New Item</button>
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
                                        <th scope="col" id="element-id">Id</th>
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
                        </div>
                        <!--Modal start-->
                        <div class="modal fade bd-example-modal-lg" id="AddItem" tabindex="-1" role="dialog"
                            aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
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
                                                        placeholder="This is auto generated id" readonly="readonly">
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
                                        <button type="button" class="btn btn-primary" id="add">Add Item</button>
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
    </div>
    </div>
    <!-- edit Modal start-->
    <div class="modal fade bd-example-modal-lg" id="EditItem" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="itemid">Item Id</label>
                                <input type="text" class="form-control" id="edit-id" readonly="readonly">
                            </div>
                            <div class="col-md-6">
                                <label for="itemname">Item Name</label>
                                <input type="text" class="form-control" id="edit-name" placeholder="Item Name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="price">Price(INR)</label>
                                <input type="text" class="form-control" id="edit-price" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="standardcost">Standard Cost(INR)</label>
                                <input type="text" class="form-control" id="edit-stdcost" placeholder="0.00">
                            </div>
                            <div class="col-md-6">
                                <label for="taxcode">Tax Code</label>
                                <input type="text" class="form-control" id="edit-taxcode">
                            </div>
                        </div>
                    </div>
                    <!--<div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="forsale">Enabled For Sale</label><br>
                                                                <span><input type="radio" name="edit-radio-btn" id="edit-sale" value="yes"> YES</span>
                                                                <span><input type="radio" name="edit-radio-btn" id="edit-sale" value="no"> NO</span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="forbill">Bill of Materials Type</label><br>
                                                                <span><input type="radio" name="edit-rbtn" value="standard" id="edit-bill"> STANDARD</span>
                                                                <span><input type="radio" name="edit-rbtn" value="configurable" id="edit-bill"> CONFIGURABLE</span>
                                                        </div>
                                                    </div>
                                                </div>-->
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="size">Size</label>
                                <input type="text" class="form-control" placeholder="size" id="edit-size">
                            </div>
                            <div class="col-md-6">
                                <label for="color">Color</label>
                                <input type="text" class="form-control" placeholder="color" id="edit-color">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Condition</label>
                                <select name="condition" class="form-control" id="edit-condition">
                                    <option value="new">New</option>
                                    <option value="refurbished">Refurbished</option>
                                    <option value="used">Used</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Inventory type</label>
                                <select name="inventory" class="form-control" id="edit_inventory">
                                    <option value="purchased">Purchased</option>
                                    <option value="drop shipped">Drop shipped</option>
                                    <option value="manufacture">manufactured</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <input type="checkbox" id="delete" name="delete">
                                    <label for="delete" class="text-danger"> Delete Item</label>
                                </div>
                                <!--<input type="text" class="form-control" id="ref-name">-->
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
    <script src="../js/items.js"></script>
</body>

</html>
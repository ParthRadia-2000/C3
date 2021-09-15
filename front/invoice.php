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

// for invoice 
$statement = "SELECT * FROM tbl_order ORDER BY order_id DESC";
$order = $conn->prepare($statement);
$order->execute();
$all_result = $order->fetchAll(PDO::FETCH_ASSOC);
$total_rows = $order->rowCount();

//insert invoice
if (isset($_POST["create_invoice"])) {
    $order_total_before_tax = 0;
    $order_total_tax1 = 0;
    $order_total_tax2 = 0;
    $order_total_tax3 = 0;
    $order_total_tax = 0;
    $order_total_after_tax = 0;
    $statement = $conn->prepare("
      INSERT INTO tbl_order 
        (order_no, order_date, order_receiver_name, order_receiver_address, order_total_before_tax, order_total_tax1, order_total_tax2, order_total_tax3, order_total_tax, order_total_after_tax, order_datetime)
        VALUES (:order_no, :order_date, :order_receiver_name, :order_receiver_address, :order_total_before_tax, :order_total_tax1, :order_total_tax2, :order_total_tax3, :order_total_tax, :order_total_after_tax, :order_datetime)
    ");
    $statement->execute(
        array(
            ':order_no'               =>  trim($_POST["order_no"]),
            ':order_date'             =>  trim($_POST["order_date"]),
            ':order_receiver_name'          =>  trim($_POST["order_receiver_name"]),
            ':order_receiver_address'       =>  trim($_POST["order_receiver_address"]),
            ':order_total_before_tax'       =>  $order_total_before_tax,
            ':order_total_tax1'           =>  $order_total_tax1,
            ':order_total_tax2'           =>  $order_total_tax2,
            ':order_total_tax3'           =>  $order_total_tax3,
            ':order_total_tax'            =>  $order_total_tax,
            ':order_total_after_tax'        =>  $order_total_after_tax,
            ':order_datetime'           =>  date("Y-m-d")
        )
    );

    $statement = $conn->query("SELECT LAST_INSERT_ID()");
    $order_id = $statement->fetchColumn();

    for ($count = 0; $count < $_POST["total_item"]; $count++) {
        $order_total_before_tax = $order_total_before_tax + floatval(trim($_POST["order_item_actual_amount"][$count]));

        $order_total_tax1 = $order_total_tax1 + floatval(trim($_POST["order_item_tax1_amount"][$count]));

        $order_total_tax2 = $order_total_tax2 + floatval(trim($_POST["order_item_tax2_amount"][$count]));

        $order_total_tax3 = $order_total_tax3 + floatval(trim($_POST["order_item_tax3_amount"][$count]));

        $order_total_after_tax = $order_total_after_tax + floatval(trim($_POST["order_item_final_amount"][$count]));

        $statement = $conn->prepare("
          INSERT INTO tbl_order_item 
          (order_id, item_name, order_item_quantity, order_item_price, order_item_actual_amount, order_item_tax1_rate, order_item_tax1_amount, order_item_tax2_rate, order_item_tax2_amount, order_item_tax3_rate, order_item_tax3_amount, order_item_final_amount)
          VALUES (:order_id, :item_name, :order_item_quantity, :order_item_price, :order_item_actual_amount, :order_item_tax1_rate, :order_item_tax1_amount, :order_item_tax2_rate, :order_item_tax2_amount, :order_item_tax3_rate, :order_item_tax3_amount, :order_item_final_amount)
        ");

        $statement->execute(
            array(
                ':order_id'               =>  $order_id,
                ':item_name'              =>  trim($_POST["item_name"][$count]),
                ':order_item_quantity'          =>  trim($_POST["order_item_quantity"][$count]),
                ':order_item_price'           =>  trim($_POST["order_item_price"][$count]),
                ':order_item_actual_amount'       =>  trim($_POST["order_item_actual_amount"][$count]),
                ':order_item_tax1_rate'         =>  trim($_POST["order_item_tax1_rate"][$count]),
                ':order_item_tax1_amount'       =>  trim($_POST["order_item_tax1_amount"][$count]),
                ':order_item_tax2_rate'         =>  trim($_POST["order_item_tax2_rate"][$count]),
                ':order_item_tax2_amount'       =>  trim($_POST["order_item_tax2_amount"][$count]),
                ':order_item_tax3_rate'         =>  trim($_POST["order_item_tax3_rate"][$count]),
                ':order_item_tax3_amount'       =>  trim($_POST["order_item_tax3_amount"][$count]),
                ':order_item_final_amount'        =>  trim($_POST["order_item_final_amount"][$count])
            )
        );
    }
    $order_total_tax = $order_total_tax1 + $order_total_tax2 + $order_total_tax3;

    $statement = $conn->prepare("
        UPDATE tbl_order 
        SET order_total_before_tax = :order_total_before_tax, 
        order_total_tax1 = :order_total_tax1, 
        order_total_tax2 = :order_total_tax2, 
        order_total_tax3 = :order_total_tax3, 
        order_total_tax = :order_total_tax, 
        order_total_after_tax = :order_total_after_tax 
        WHERE order_id = :order_id 
      ");
    $statement->execute(
        array(
            ':order_total_before_tax'     =>  $order_total_before_tax,
            ':order_total_tax1'         =>  $order_total_tax1,
            ':order_total_tax2'         =>  $order_total_tax2,
            ':order_total_tax3'         =>  $order_total_tax3,
            ':order_total_tax'          =>  $order_total_tax,
            ':order_total_after_tax'      =>  $order_total_after_tax,
            ':order_id'             =>  $order_id
        )
    );
    header("location:invoice.php");
}
// update invoice
if (isset($_POST["update_invoice"])) {
    $order_total_before_tax = 0;
    $order_total_tax1 = 0;
    $order_total_tax2 = 0;
    $order_total_tax3 = 0;
    $order_total_tax = 0;
    $order_total_after_tax = 0;

    $order_id = $_POST["order_id"];

    $statement = $conn->prepare("
                DELETE FROM tbl_order_item WHERE order_id = :order_id
            ");
    $statement->execute(
        array(
            ':order_id' => $order_id
        )
    );

    for ($count = 0; $count < $_POST["total_item"]; $count++) {
        $order_total_before_tax = $order_total_before_tax + floatval(trim($_POST["order_item_actual_amount"][$count]));
        $order_total_tax1 = $order_total_tax1 + floatval(trim($_POST["order_item_tax1_amount"][$count]));
        $order_total_tax2 = $order_total_tax2 + floatval(trim($_POST["order_item_tax2_amount"][$count]));
        $order_total_tax3 = $order_total_tax3 + floatval(trim($_POST["order_item_tax3_amount"][$count]));
        $order_total_after_tax = $order_total_after_tax + floatval(trim($_POST["order_item_final_amount"][$count]));
        $statement = $conn->prepare("INSERT INTO tbl_order_item (order_id, item_name, order_item_quantity, order_item_price, order_item_actual_amount, order_item_tax1_rate, order_item_tax1_amount, order_item_tax2_rate, order_item_tax2_amount, order_item_tax3_rate, order_item_tax3_amount, order_item_final_amount) 
          VALUES (:order_id, :item_name, :order_item_quantity, :order_item_price, :order_item_actual_amount, :order_item_tax1_rate, :order_item_tax1_amount, :order_item_tax2_rate, :order_item_tax2_amount, :order_item_tax3_rate, :order_item_tax3_amount, :order_item_final_amount)
        ");
        $statement->execute(
            array(
                ':order_id'                 =>  $order_id,
                ':item_name'                =>  trim($_POST["item_name"][$count]),
                ':order_item_quantity'          =>  trim($_POST["order_item_quantity"][$count]),
                ':order_item_price'            =>  trim($_POST["order_item_price"][$count]),
                ':order_item_actual_amount'     =>  trim($_POST["order_item_actual_amount"][$count]),
                ':order_item_tax1_rate'         =>  trim($_POST["order_item_tax1_rate"][$count]),
                ':order_item_tax1_amount'       =>  trim($_POST["order_item_tax1_amount"][$count]),
                ':order_item_tax2_rate'         =>  trim($_POST["order_item_tax2_rate"][$count]),
                ':order_item_tax2_amount'       =>  trim($_POST["order_item_tax2_amount"][$count]),
                ':order_item_tax3_rate'         =>  trim($_POST["order_item_tax3_rate"][$count]),
                ':order_item_tax3_amount'       =>  trim($_POST["order_item_tax3_amount"][$count]),
                ':order_item_final_amount'      =>  trim($_POST["order_item_final_amount"][$count])
            )
        );
    }
    $order_total_tax = $order_total_tax1 + $order_total_tax2 + $order_total_tax3;

    $statement = $conn->prepare("
        UPDATE tbl_order 
        SET order_no = :order_no, 
        order_date = :order_date, 
        order_receiver_name = :order_receiver_name, 
        order_receiver_address = :order_receiver_address, 
        order_total_before_tax = :order_total_before_tax, 
        order_total_tax1 = :order_total_tax1, 
        order_total_tax2 = :order_total_tax2, 
        order_total_tax3 = :order_total_tax3, 
        order_total_tax = :order_total_tax, 
        order_total_after_tax = :order_total_after_tax 
        WHERE order_id = :order_id 
      ");

    $statement->execute(
        array(
            ':order_no'               =>  trim($_POST["order_no"]),
            ':order_date'             =>  trim($_POST["order_date"]),
            ':order_receiver_name'        =>  trim($_POST["order_receiver_name"]),
            ':order_receiver_address'     =>  trim($_POST["order_receiver_address"]),
            ':order_total_before_tax'     =>  $order_total_before_tax,
            ':order_total_tax1'          =>  $order_total_tax1,
            ':order_total_tax2'          =>  $order_total_tax2,
            ':order_total_tax3'          =>  $order_total_tax3,
            ':order_total_tax'           =>  $order_total_tax,
            ':order_total_after_tax'      =>  $order_total_after_tax,
            ':order_id'               =>  $order_id
        )
    );
    header("location:invoice.php");
}

// delete invoice
if (isset($_GET["delete"]) && isset($_GET["id"])) {
    $statement = $conn->prepare("DELETE FROM tbl_order WHERE order_id = :id");
    $statement->execute(
        array(
            ':id'       =>      $_GET["id"]
        )
    );
    $statement = $conn->prepare(
        "DELETE FROM tbl_order_item WHERE order_id = :id"
    );
    $statement->execute(
        array(
            ':id'       =>      $_GET["id"]
        )
    );
    header("location:invoice.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title> Deals | C3</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Items | C3 </title>
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
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
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
                        <a class="dropdown-item" href="deals.php"><i class='fas'>&#xf5bf;</i> Deals</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#"><i class='fas'>&#xf1ec;</i> Invoice</a>
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
                <i class='fa'> &#xf1ec;</i> INVOICES
            </div>
            <div class="container-fluid">
                <?php
                if (isset($_GET["add"])) {
                ?>
                <form method="post" id="invoice_form">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2" align="center">
                                    <h2 style="margin-top:10.5px;color:#563d7c">Create Invoice</h2>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="row">
                                        <div class="col-md-8">
                                            To,<br />
                                            <b>RECEIVER (BILL TO)</b><br />
                                            <input type="text" name="order_receiver_name" id="order_receiver_name"
                                                class="form-control input-sm" placeholder="Enter Receiver Name" />
                                            <textarea name="order_receiver_address" id="order_receiver_address"
                                                class="form-control" placeholder="Enter Billing Address"></textarea>
                                        </div>
                                        <div class="col-md-4"><br>
                                            Reverse Charge
                                            <input type="text" name="order_no" id="order_no"
                                                class="form-control input-sm" placeholder="Enter Invoice No." />
                                            Date
                                            <input type="date" name="order_date" id="order_date"
                                                class="form-control input-sm" />
                                        </div>
                                    </div>
                                    <br />
                                    <table id="invoice-item-table" class="table table-bordered">
                                        <tr>
                                            <th width="5%">Sr No.</th>
                                            <th width="15%">Item Name</th>
                                            <th width="5%">Quantity</th>
                                            <th width="9%">Price</th>
                                            <th width="10%">Actual Amt.</th>
                                            <th width="15%" colspan="2">Tax1 (%)</th>
                                            <th width="15%" colspan="2">Tax2 (%)</th>
                                            <th width="15%" colspan="2">Tax3 (%)</th>
                                            <th width="15%" rowspan="2">Total</th>
                                            <th width="3%" rowspan="2"></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Rate</th>
                                            <th>Amt.</th>
                                            <th>Rate</th>
                                            <th>Amt.</th>
                                            <th>Rate</th>
                                            <th>Amt.</th>
                                        </tr>
                                        <tr>
                                            <td><span id="sr_no">1</span></td>
                                            <td><input type="text" name="item_name[]" id="item_name1"
                                                    class="form-control input-sm" /></td>
                                            <td><input type="text" name="order_item_quantity[]"
                                                    id="order_item_quantity1" data-srno="1"
                                                    class="form-control input-sm order_item_quantity" /></td>
                                            <td><input type="text" name="order_item_price[]" id="order_item_price1"
                                                    data-srno="1"
                                                    class="form-control input-sm number_only order_item_price" /></td>
                                            <td><input type="text" name="order_item_actual_amount[]"
                                                    id="order_item_actual_amount1" data-srno="1"
                                                    class="form-control input-sm order_item_actual_amount" readonly />
                                            </td>
                                            <td><input type="text" name="order_item_tax1_rate[]"
                                                    id="order_item_tax1_rate1" data-srno="1"
                                                    class="form-control input-sm number_only order_item_tax1_rate" />
                                            </td>
                                            <td><input type="text" name="order_item_tax1_amount[]"
                                                    id="order_item_tax1_amount1" data-srno="1" readonly
                                                    class="form-control input-sm order_item_tax1_amount" /></td>
                                            <td><input type="text" name="order_item_tax2_rate[]"
                                                    id="order_item_tax2_rate1" data-srno="1"
                                                    class="form-control input-sm number_only order_item_tax2_rate" />
                                            </td>
                                            <td><input type="text" name="order_item_tax2_amount[]"
                                                    id="order_item_tax2_amount1" data-srno="1" readonly
                                                    class="form-control input-sm order_item_tax2_amount" /></td>
                                            <td><input type="text" name="order_item_tax3_rate[]"
                                                    id="order_item_tax3_rate1" data-srno="1"
                                                    class="form-control input-sm number_only order_item_tax3_rate" />
                                            </td>
                                            <td><input type="text" name="order_item_tax3_amount[]"
                                                    id="order_item_tax3_amount1" data-srno="1" readonly
                                                    class="form-control input-sm order_item_tax3_amount" /></td>
                                            <td><input type="text" name="order_item_final_amount[]"
                                                    id="order_item_final_amount1" data-srno="1" readonly
                                                    class="form-control input-sm order_item_final_amount" /></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                    <div align="right">
                                        <button type="button" name="add_row" id="add_row"
                                            class="btn btn-success btn-xs">+</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td align="right"><b>Total</td>
                                <td align="right"><b><span id="final_total_amt"></span></b></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="hidden" name="total_item" id="total_item" value="1" />
                                    <input type="submit" name="create_invoice" id="create_invoice" class="btn btn-info"
                                        value="Create"
                                        style="background-color:#563d7c;color:white;font-size: 1em;border-radius: 5px;font-weight: bolder;cursor: pointer;padding:0.9em;" />
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
                <?php
                } else if (isset($_GET["update"]) && isset($_GET["id"])) {
                    $statement = $conn->prepare("
                            SELECT * FROM tbl_order 
                                WHERE order_id = :order_id
                                LIMIT 1
                            ");
                    $statement->execute(
                        array(
                            ':order_id'       =>  $_GET["id"]
                        )
                    );
                    $result = $statement->fetchAll();
                    foreach ($result as $row) {
                    ?>

                <form method="post" id="invoice_form">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td colspan="2" align="center">
                                    <h2 style="margin-top:10.5px;color:#563d7c;">Edit Invoice</h2>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="row">
                                        <div class="col-md-8">
                                            To,<br />
                                            <b>RECEIVER (BILL TO)</b><br />
                                            <input type="text" name="order_receiver_name" id="order_receiver_name"
                                                class="form-control input-sm" placeholder="Enter Receiver Name" />
                                            <textarea name="order_receiver_address" id="order_receiver_address"
                                                class="form-control" placeholder="Enter Billing Address"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            Reverse Charge<br />
                                            <input type="text" name="order_no" id="order_no"
                                                class="form-control input-sm" placeholder="Enter Invoice No." />
                                            <input type="date" name="order_date" id="order_date"
                                                class="form-control input-sm" placeholder="Select Invoice Date" />
                                        </div>
                                    </div>
                                    <br />
                                    <table id="invoice-item-table" class="table table-bordered">
                                        <tr>
                                            <th width="5%">Sr No.</th>
                                            <th width="15%">Item Name</th>
                                            <th width="5%">Quantity</th>
                                            <th width="9%">Price</th>
                                            <th width="10%">Actual Amt.</th>
                                            <th width="15%" colspan="2">Tax1 (%)</th>
                                            <th width="15%" colspan="2">Tax2 (%)</th>
                                            <th width="15%" colspan="2">Tax3 (%)</th>
                                            <th width="15%" rowspan="2">Total</th>
                                            <th width="3%" rowspan="2"></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Rate</th>
                                            <th>Amt.</th>
                                            <th>Rate</th>
                                            <th>Amt.</th>
                                            <th>Rate</th>
                                            <th>Amt.</th>
                                        </tr>
                                        <?php
                                                $statement = $conn->prepare("
                                    SELECT * FROM tbl_order_item 
                                    WHERE order_id = :order_id
                                    ");
                                                $statement->execute(
                                                    array(
                                                        ':order_id'       =>  $_GET["id"]
                                                    )
                                                );
                                                $item_result = $statement->fetchAll();
                                                $m = 0;
                                                foreach ($item_result as $sub_row) {
                                                    $m = $m + 1;
                                                ?>
                                        <tr>
                                            <td><span id="sr_no"><?php echo $m; ?></span></td>
                                            <td><input type="text" name="item_name[]" id="item_name<?php echo $m; ?>"
                                                    class="form-control input-sm"
                                                    value="<?php echo $sub_row["item_name"]; ?>" /></td>
                                            <td><input type="text" name="order_item_quantity[]"
                                                    id="order_item_quantity<?php echo $m; ?>"
                                                    data-srno="<?php echo $m; ?>"
                                                    class="form-control input-sm order_item_quantity"
                                                    value="<?php echo $sub_row["order_item_quantity"]; ?>" /></td>
                                            <td><input type="text" name="order_item_price[]"
                                                    id="order_item_price<?php echo $m; ?>" data-srno="<?php echo $m; ?>"
                                                    class="form-control input-sm number_only order_item_price"
                                                    value="<?php echo $sub_row["order_item_price"]; ?>" /></td>
                                            <td><input type="text" name="order_item_actual_amount[]"
                                                    id="order_item_actual_amount<?php echo $m; ?>"
                                                    data-srno="<?php echo $m; ?>"
                                                    class="form-control input-sm order_item_actual_amount"
                                                    value="<?php echo $sub_row["order_item_actual_amount"]; ?>"
                                                    readonly /></td>
                                            <td><input type="text" name="order_item_tax1_rate[]"
                                                    id="order_item_tax1_rate<?php echo $m; ?>"
                                                    data-srno="<?php echo $m; ?>"
                                                    class="form-control input-sm number_only order_item_tax1_rate"
                                                    value="<?php echo $sub_row["order_item_tax1_rate"]; ?>" /></td>
                                            <td><input type="text" name="order_item_tax1_amount[]"
                                                    id="order_item_tax1_amount<?php echo $m; ?>"
                                                    data-srno="<?php echo $m; ?>" readonly
                                                    class="form-control input-sm order_item_tax1_amount"
                                                    value="<?php echo $sub_row["order_item_tax1_amount"]; ?>" /></td>
                                            <td><input type="text" name="order_item_tax2_rate[]"
                                                    id="order_item_tax2_rate<?php echo $m; ?>"
                                                    data-srno="<?php echo $m; ?>"
                                                    class="form-control input-sm number_only order_item_tax2_rate"
                                                    value="<?php echo $sub_row["order_item_tax2_rate"]; ?>" /></td>
                                            <td><input type="text" name="order_item_tax2_amount[]"
                                                    id="order_item_tax2_amount<?php echo $m; ?>"
                                                    data-srno="<?php echo $m; ?>" readonly
                                                    class="form-control input-sm order_item_tax2_amount"
                                                    value="<?php echo $sub_row["order_item_tax2_amount"]; ?>" /></td>
                                            <td><input type="text" name="order_item_tax3_rate[]"
                                                    id="order_item_tax3_rate<?php echo $m; ?>"
                                                    data-srno="<?php echo $m; ?>"
                                                    class="form-control input-sm number_only order_item_tax3_rate"
                                                    value="<?php echo $sub_row["order_item_tax3_rate"]; ?>" /></td>
                                            <td><input type="text" name="order_item_tax3_amount[]"
                                                    id="order_item_tax3_amount<?php echo $m; ?>"
                                                    data-srno="<?php echo $m; ?>" readonly
                                                    class="form-control input-sm order_item_tax3_amount"
                                                    value="<?php echo $sub_row["order_item_tax3_amount"]; ?>" /></td>
                                            <td><input type="text" name="order_item_final_amount[]"
                                                    id="order_item_final_amount<?php echo $m; ?>"
                                                    data-srno="<?php echo $m; ?>" readonly
                                                    class="form-control input-sm order_item_final_amount"
                                                    value="<?php echo $sub_row["order_item_final_amount"]; ?>" /></td>
                                            <td></td>
                                        </tr>
                                        <?php
                                                }
                                                ?>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="right"><b>Total</td>
                                <td align="right"><b><span
                                            id="final_total_amt"><?php echo $row["order_total_after_tax"]; ?></span></b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="hidden" name="total_item" id="total_item" value="<?php echo $m; ?>" />
                                    <input type="hidden" name="order_id" id="order_id"
                                        value="<?php echo $row["order_id"]; ?>" />
                                    <input type="submit" name="update_invoice" id="create_invoice" class="btn btn-info"
                                        style="background-color:#563d7c;color:white;font-size: 1em;border-radius: 5px;font-weight: bolder;cursor: pointer;padding:0.9em;"
                                        value="Edit" />
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
                <script>
                $(document).ready(function() {

                    $('#order_no').val(<?php echo $row["order_no"]; ?>);
                    $('#order_date').val("<?php echo $row["order_date"]; ?>");
                    $('#order_receiver_name').val("<?php echo $row["order_receiver_name"]; ?>");
                    $('#order_receiver_address').val("<?php echo $row["order_receiver_address"]; ?>");

                    var final_total_amt = $('#final_total_amt').text();

                    var count = "<?php echo $m; ?>";

                    function cal_final_total(count) {
                        var final_item_total = 0;
                        for (j = 1; j <= count; j++) {
                            var quantity = 0;
                            var price = 0;
                            var actual_amount = 0;
                            var tax1_rate = 0;
                            var tax1_amount = 0;
                            var tax2_rate = 0;
                            var tax2_amount = 0;
                            var tax3_rate = 0;
                            var tax3_amount = 0;
                            var item_total = 0;
                            quantity = $('#order_item_quantity' + j).val();
                            if (quantity > 0) {
                                price = $('#order_item_price' + j).val();
                                if (price > 0) {
                                    actual_amount = parseFloat(quantity) * parseFloat(price);
                                    $('#order_item_actual_amount' + j).val(actual_amount);
                                    tax1_rate = $('#order_item_tax1_rate' + j).val();
                                    if (tax1_rate > 0) {
                                        tax1_amount = parseFloat(actual_amount) * parseFloat(tax1_rate) / 100;
                                        $('#order_item_tax1_amount' + j).val(tax1_amount);
                                    }
                                    tax2_rate = $('#order_item_tax2_rate' + j).val();
                                    if (tax2_rate > 0) {
                                        tax2_amount = parseFloat(actual_amount) * parseFloat(tax2_rate) / 100;
                                        $('#order_item_tax2_amount' + j).val(tax2_amount);
                                    }
                                    tax3_rate = $('#order_item_tax3_rate' + j).val();
                                    if (tax3_rate > 0) {
                                        tax3_amount = parseFloat(actual_amount) * parseFloat(tax3_rate) / 100;
                                        $('#order_item_tax3_amount' + j).val(tax3_amount);
                                    }
                                    item_total = parseFloat(actual_amount) + parseFloat(tax1_amount) +
                                        parseFloat(tax2_amount) + parseFloat(tax3_amount);
                                    final_item_total = parseFloat(final_item_total) + parseFloat(item_total);
                                    $('#order_item_final_amount' + j).val(item_total);
                                }
                            }
                        }
                        $('#final_total_amt').text(final_item_total);
                    }

                    $(document).on('blur', '.order_item_price', function() {
                        cal_final_total(count);
                    });

                    $(document).on('blur', '.order_item_tax1_rate', function() {
                        cal_final_total(count);
                    });

                    $(document).on('blur', '.order_item_tax2_rate', function() {
                        cal_final_total(count);
                    });

                    $(document).on('blur', '.order_item_tax3_rate', function() {
                        cal_final_total(count);
                    });

                    $('#create_invoice').click(function() {
                        if ($.trim($('#order_receiver_name').val()).length == 0) {
                            alert("Please Enter Reciever Name");
                            return false;
                        }

                        if ($.trim($('#order_no').val()).length == 0) {
                            alert("Please Enter Invoice Number");
                            return false;
                        }

                        if ($.trim($('#order_date').val()).length == 0) {
                            alert("Please Select Invoice Date");
                            return false;
                        }

                        for (var no = 1; no <= count; no++) {
                            if ($.trim($('#item_name' + no).val()).length == 0) {
                                alert("Please Enter Item Name");
                                $('#item_name' + no).focus();
                                return false;
                            }

                            if ($.trim($('#order_item_quantity' + no).val()).length == 0) {
                                alert("Please Enter Quantity");
                                $('#order_item_quantity' + no).focus();
                                return false;
                            }

                            if ($.trim($('#order_item_price' + no).val()).length == 0) {
                                alert("Please Enter Price");
                                $('#order_item_price' + no).focus();
                                return false;
                            }

                        }

                        $('#invoice_form').submit();

                    });

                });
                </script>
                <?php
                    }
                } else {
                    ?>
                <h3 align="center" style="color:#563d7c;"> Generate Invoice</h3>

                <br />
                <div align="right">
                    <a href="invoice.php?add=1" class="btn btn-info btn-xs"
                        style="background-color:#563d7c;color:white;font-size: 1em;border-radius: 5px;font-weight: bolder;cursor: pointer;padding:0.9em;">Create</a>
                </div>
                <br />
                <table id="data-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Invoice No.</th>
                            <th>Invoice Date</th>
                            <th>Receiver Name</th>
                            <th>Invoice Total</th>
                            <th>PDF</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <?php
                        if ($total_rows > 0) {
                            foreach ($all_result as $row) {
                                echo '
                            <tr>
                                <td>' . $row["order_no"] . '</td>
                                <td>' . $row["order_date"] . '</td>
                                <td>' . $row["order_receiver_name"] . '</td>
                                <td>' . $row["order_total_after_tax"] . '</td>
                                <td><a href="print_invoice.php?pdf=1&id=' . $row["order_id"] . '"><span><i class="fa" style="color:#563d7c;">&#xf019;</i></span></a></td>
                                <td><a href="invoice.php?update=1&id=' . $row["order_id"] . '"><span><i class="far" style="color:#563d7c;">&#xf044;</i></span></a></td>
                                <td><a href="#" id="' . $row["order_id"] . '" class="delete"><span><i class="fa" style="color:#563d7c;">&#xf00d;</i></span></a></td>
                            </tr>
                            ';
                            }
                        }
                        ?>
                </table>
                <?php
                }
                ?>
            </div>
            <br>
            <footer class="container-fluid text-center">

            </footer>
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
    <script src="../js/invoice.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        var table = $('#data-table').DataTable({
            "order": [],
            "columnDefs": [{
                "targets": [4, 5, 6],
                "orderable": false,
            }, ],
            "pageLength": 25
        });
        $(document).on('click', '.delete', function() {
            var id = $(this).attr("id");
            if (confirm("Are you sure you want to remove this?")) {
                window.location.href = "invoice.php?delete=1&id=" + id;
            } else {
                return false;
            }
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        $('.number_only').keypress(function(e) {
            return isNumbers(e, this);
        });

        function isNumbers(evt, element) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (
                (charCode != 46 || $(element).val().indexOf('.') != -1) && // “.” CHECK DOT, AND ONLY ONE.
                (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    });
    </script>
</body>

</html>
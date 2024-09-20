<?php
include "./header.php";
include "./sidebar.php";

?>

<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">

                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- [ Main Content ] start -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Reports</h5>
                                        <span class="d-block m-t-5">This Report Shows the Expense details</span>
                                    </div>
                                    <div class="card-block table-border-style">

                                        <form id="userForm">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <select name="type" id="type" class="form-control">
                                                        <option value="0">All</option>
                                                        <option value="custome">Custome</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="date" name="from" id="from" class="form-control">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="date" name="to" id="to" class="form-control">
                                                </div>
                                                <div class="col-sm-12 w-100 mt-2">
                                                    <button type="submit" class="btn btn-info w-100 font-weight-bold" id="addNew">Show All</button>
                                                </div>
                                            </div>

                                        </form>
                                        <div class="table-responsive" id="printArea">
                                            <table class="table" id="userTable">
                                                <thead>

                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>

                                        </div>
                                        <button class="btn btn-success" id="print"> <i class="fa fa-print"></i>Print</button>
                                        <button class="btn btn-info" id="export"> <i class="fa fa-file"></i>Export</button>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- [ Main Content ] end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include "./footer.php"
?>

<script src="../js/userStatement.js"></script>
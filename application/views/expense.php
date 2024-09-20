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
                                        <h5>Expense Table</h5>
                                        <span class="d-block m-t-5">This Table Shows the Expense details</span>
                                    </div>
                                    <div class="card-block table-border-style">

                                        <button class="btn btn-info float-right font-weight-bold" id="addNew">ADD NEW TRANSACTION</button>
                                        <div class="table-responsive">
                                            <table class="table" id="expenseTable">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Amount</th>
                                                        <th>Type</th>
                                                        <th>Description</th>
                                                        <th>User</th>
                                                        <th>Date</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal" tabindex="-1" role="dialog" id="expenseModal">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Register New Transaction</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="post" id="expenseForm">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="alert alert-success d-none" role="alert">
                                                        This is a success alert—check it out!
                                                    </div>
                                                    <div class="alert alert-danger d-none" role="alert">
                                                        This is a danger alert—check it out!
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <input type="text" hidden class="form-control" name="id" id="id">
                                                    <div class="form-group">
                                                        <label for="amount">Amount</label>
                                                        <input class="form-control" type="number" name="amount" id="amount">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="type">Type</label>
                                                        <select name="type" id="type" class="form-control">
                                                            <option value="Income">Income</option>
                                                            <option value="Expense">Expense</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="desc">Description</label>
                                                        <textarea name="desc" id="desc" class="form-control" rows="5"></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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

<script src="../js/expense.js"></script>
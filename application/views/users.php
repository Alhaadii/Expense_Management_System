<?php
include "./header.php";
include "./sidebar.php";

?>

<style>
    #show {
        width: 150px;
        height: 150px;
        border: solid 1px #744547;
        border-radius: 50%;
        object-fit: cover;
    }
</style>

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
                                        <h5>Users Table</h5>
                                        <span class="d-block m-t-5">This Table Shows the users details</span>
                                    </div>
                                    <div class="card-block table-border-style">

                                        <button class="btn btn-info float-right font-weight-bold" id="addNew">ADD NEW User</button>
                                        <div class="table-responsive">
                                            <table class="table" id="userTable">
                                                <thead>

                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal" tabindex="-1" role="dialog" id="userModal">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Register New User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="#" method="post" id="userForm" enctype="multipart/form-data">
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
                                                        <label for="username">User Name</label>
                                                        <input class="form-control" type="text" name="username" id="username">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="password">Password</label>
                                                        <input class="form-control" type="password" name="password" id="password">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="image">user image</label>
                                                        <input class="form-control" type="file" name="image" id="image">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group d-flex justify-content-center align-items-center">
                                                        <img id="show">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
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

<script src="../js/users.js"></script>
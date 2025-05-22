<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form>
                            <div id="progressbarwizard">

                                <ul class="nav nav-pills nav-justified form-wizard-header mb-3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a href="#account-2" data-bs-toggle="tab" data-toggle="tab"
                                            class="nav-link rounded-0 py-2 active" aria-selected="true" role="tab">
                                            <i class="bi bi-person-circle fs-18 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Account</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#profile-tab-2" data-bs-toggle="tab" data-toggle="tab"
                                            class="nav-link rounded-0 py-2" aria-selected="false" role="tab"
                                            tabindex="-1">
                                            <i class="bi bi-emoji-smile fs-18 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Profile</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a href="#finish-2" data-bs-toggle="tab" data-toggle="tab"
                                            class="nav-link rounded-0 py-2" aria-selected="false" role="tab"
                                            tabindex="-1">
                                            <i class="bi bi-check2-circle fs-18 align-middle me-1"></i>
                                            <span class="d-none d-sm-inline">Upload Image</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content b-0 mb-0">

                                    <div id="bar" class="progress mb-3" style="height: 7px;">
                                        <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"
                                            style="width: 33.3333%;"></div>
                                    </div>

                                    <div class="tab-pane active show" id="account-2" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="userName1">User
                                                        name</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" id="userName1"
                                                            name="userName1">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="password1">
                                                        Password</label>
                                                    <div class="col-md-9">
                                                        <input type="password" id="password1" name="password1"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="confirm1">Re
                                                        Password</label>
                                                    <div class="col-md-9">
                                                        <input type="password" id="confirm1" name="confirm1"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                    </div>

                                    <div class="tab-pane" id="profile-tab-2" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="name1"> First
                                                        name</label>
                                                    <div class="col-md-9">
                                                        <input type="text" id="name1" name="name1"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label" for="surname1"> Last
                                                        name</label>
                                                    <div class="col-md-9">
                                                        <input type="text" id="surname1" name="surname1"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label class="col-md-3 col-form-label"
                                                        for="email1">Email</label>
                                                    <div class="col-md-9">
                                                        <input type="email" id="email1" name="email1"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                    </div>

                                    <div class="tab-pane" id="finish-2" role="tabpanel">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="example-fileinput" class="form-label">Default file
                                                        input</label>
                                                    <input type="file" id="example-fileinput"
                                                        class="form-control">
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                    </div>

                                    <div class="d-flex wizard justify-content-between flex-wrap gap-2 mt-3">
                                        <div class="first">
                                            <a href="javascript:void(0);" class="btn btn-primary disabled">
                                                First
                                            </a>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            <div class="previous">
                                                <a href="javascript:void(0);" class="btn btn-primary disabled">
                                                    <i class="bx bx-left-arrow-alt me-2"></i>Back To Previous
                                                </a>
                                            </div>
                                            <div class="next">
                                                <a href="javascript:void(0);" class="btn btn-primary mt-3 mt-md-0">
                                                    Next Step<i class="bx bx-right-arrow-alt ms-2"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="last">
                                            <a href="javascript:void(0);" class="btn btn-primary mt-3 mt-md-0">
                                                Finish
                                            </a>
                                        </div>
                                    </div>

                                </div> <!-- tab-content -->
                            </div> <!-- end #progressbarwizard-->
                        </form>
            </div> <!-- modal-body -->

        </div>
    </div>
</div>

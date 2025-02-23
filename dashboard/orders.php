<?php

?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Policies</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
        <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
            <svg class="bi">
                <use xlink:href="#calendar3" />
            </svg>
            This week
        </button>
    </div>
</div>
<button class="btn btn-sm btn-outline-secondary text-warning mt-2 mb-3" onclick="showModal();">Add New &nbsp<i class="fas fa-plus"></i></button>

<h2>Pending Policies</h2>
<div class="table-responsive small mb-3">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Header</th>
                <th scope="col">Header</th>
                <th scope="col">Header</th>
                <th scope="col">Header</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1,001</td>
                <td>random</td>
                <td>data</td>
                <td>placeholder</td>
                <td>text</td>
            </tr>
            <tr>
                <td>1,002</td>
                <td>placeholder</td>
                <td>irrelevant</td>
                <td>visual</td>
                <td>layout</td>
            </tr>
            <tr>
                <td>1,003</td>
                <td>data</td>
                <td>rich</td>
                <td>dashboard</td>
                <td>tabular</td>
            </tr>

        </tbody>
    </table>
</div>

<h2>Previous Policies</h2>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Header</th>
                <th scope="col">Header</th>
                <th scope="col">Header</th>
                <th scope="col">Header</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1,001</td>
                <td>random</td>
                <td>data</td>
                <td>placeholder</td>
                <td>text</td>
            </tr>
            <tr>
                <td>1,002</td>
                <td>placeholder</td>
                <td>irrelevant</td>
                <td>visual</td>
                <td>layout</td>
            </tr>
            <tr>
                <td>1,003</td>
                <td>data</td>
                <td>rich</td>
                <td>dashboard</td>
                <td>tabular</td>
            </tr>

        </tbody>
    </table>
</div>



<!-- add new customr modal begin -->
<div class="modal fade" tabindex="-1" id="addNewModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="con ">
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="" class="form-label">Police Number :</label>
                            <input type="text" class="form-control form-control-sm">

                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Date : *</label>
                            <input type="date" class="form-control form-control-sm">

                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="" class="form-label">First Name :</label>
                            <input type="text" class="form-control form-control-sm">

                        </div>
                        <div class="col-6">
                            <label for="" class="form-label">Last Name :</label>
                            <input type="text" class="form-control form-control-sm">

                        </div>

                    </div>
                    <div class="row mb-2">
                        <div>
                            <label for="" class="form-label">NIC Number : </label>
                            <input type="text" class="form-control form-control-sm">
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div>
                            <label for="" class="form-label">Contact Number : *</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div>
                            <label for="" class="form-label">Note : </label>
                            <textarea type="text" class="form-control form-control-sm" cols="5" rows="5"></textarea>
                        </div>

                    </div>
                    <div class="row mb-2">
                        <label for="" class="form-label">Location :*</label>
                        <div class="col-12" onclick="getLocation();">

                            <input type="text"  class="form-control form-control-sm" id="locText" >

                        </div>
                        

                    </div>


                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-warning btn-sm">Confirm</button>
            </div>
        </div>
    </div>
</div>





</div>

<?php







































?>
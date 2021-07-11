@extends('Admin.Master')

 @section('content')
 <div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        
        <div class="col-lg-6 mt-4 " >
            <div class="card">
                <div class="card-body">

                    <h4 class="mb-3 header-title">Add Category</h4>

                    <form class="form-horizontal">
                        <div class="form-group  mb-3">
                            <label for="catName" class="col-3 col-form-label">Category Name</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="catName" name="catName" placeholder="Category Name">
                            </div>
                        </div>
                        <div class="form-group  mb-3">
                            <label for="catDesc" class="col-5 col-form-label">Category Description</label>
                            <div class="col-9">
                                <textarea rows="3" class="form-control" id="catDesc" name="catDesc" placeholder="Category Description"> </textarea>
                            </div>
                        </div>
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-9">
                                <button type="submit" class="btn btn-info waves-effect waves-light">Add</button>
                            </div>
                        </div>
                    </form>

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>
    </div>
<div>
    
 @endsection
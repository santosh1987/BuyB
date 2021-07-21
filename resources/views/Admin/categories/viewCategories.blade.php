@extends('Master')

 @section('content')
<script>
    // alert("{{Session::get('message')}}");
    </script>
 <div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12 ">
                <div class="card">                    
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="header-title">All Categories</h3>
                            </div>
                            <div class="col-6">
                                <div class="" style="float:right;margin-top:-10px;">                                
                                    <a href="#custom-modal" class="btn btn-primary waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlayColor="#38414a"><i
                                        class="mdi mdi-plus-circle mr-1" onclick="loadModalInsert()"></i> Add Category</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                    &nbsp;
                        </div>
                        <div class="col-lg-12">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            @if ($message = Session::get('message'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>    
                                <strong>{{ $message }}</strong>
                            </div>
                            @endif
                            
                        </div>
                        <table id="key-datatable" class="table dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>S No</th>
                                    <th>Category Name</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                <?php $i = 0  ?>
                                @foreach($categories as $category)
                                <tr>
                                    <td> {{ ++$i}} </td>
                                    <td>{{$category->categoryName}}</td>
                                    <td>{{$category->description}}</td>
                                    <td><i style='color:#5f82bd;font-size:20px;' class='fa fa-edit' onclick="updateModal({{$category->id}})"></i>&emsp;&emsp;&emsp;<i  style='color:red;font-size:20px;' class='fa fa-trash' id="sa-warning" onclick='deleteCategory("+value.id+")'></i></td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        
         <!-- Modal -->
         <div id="custom-modal" class="modal-demo">
            <button type="button" class="close" onclick="Custombox.modal.close();">
                <span>&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="custom-modal-title">New Category</h4>
            <div class="custom-modal-text text-left">
                <form action="addCategory"  method="POST">
                    @csrf
                    <input type="hidden" class="form-control" id="upsert" name="upsert" value="0">
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
                </form>
                <div class="form-group mb-0 justify-content-end row">
                    <div class="col-9">
                        <button onclick="saveMasterCategory(0)" id="buttonChange" class="btn btn-info waves-effect waves-light">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div>
 <script>
     function updateModal(val) {
        $.ajax('getMasterCategoryById', {
            type: 'POST',  // http method
            data: { "id": val },  // data to submit
            success: function (data, status, xhr) {
                alert(data);
                data = JSON.parse(data);
                    loadModal(data);
                },
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
            }
        });
     }

     /* 
        Load Modal Data 
        with data from server
    */
    function loadModal(data) {
        $("#catName").val(data[0].categoryName);
        $("#catDesc").val(data[0].description);
        $("#upsert").val("1");
        // alert(data[0].id);
        $("#buttonChange").attr("onclick", "saveMasterCategory("+data[0].id+")");
        $("#buttonChange").html("Update");
        $("#custom-modal").modal('show'); 
    }

    /* 
        * Writing this for Refreshing the modal when clicked on add button 
    */
    function loadModalInsert() {
        $("#catName").val("");
        $("#catDesc").val("");
        $("#upsert").val("0");
        $("#buttonChange").attr("onclick", "saveMasterCategory(0)");
        $("#buttonChange").html("Add");
        $("#custom-modal").modal();
    }
 </script>
 <script>
     $("#key-datatable").DataTable( {
        fixedHeader: true,
        responsive: true,
     });
     function deleteCategory(id) {
    // toastr.error("Need to check all the key contraints which are dependant");
    
    $("#sa-warning").modal();
        
}
 </script>   
 @endsection
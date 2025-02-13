@extends('Master')

 @section('content')
 <div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-12 ">
                <div class="card">
                    
                    <div class="card-body">
                        <h3 class="header-title">All Sub Categories</h3>
                        <br>
                        <div class="col-lg-12">
                            <div class="text-lg-right mt-3 mt-lg-0">
                                
                                <a href="#custom-modal" class="btn btn-primary waves-effect waves-light"
                                    data-animation="fadein" data-plugin="custommodal" data-overlayColor="#38414a"><i
                                        class="mdi mdi-plus-circle mr-1"></i> Add SubCategory</a>
                            </div>
                        </div>
                         <br>
                        <table id="key-datatable" class="table dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>SNo</th>
                                    <th>Category Name</th>
                                    <th>Sub Category Name </th>
                                    <th>Description </th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                <?php $i = 0  ?>
                                @foreach($subcategories as $subcategory)
                                <tr>
                                    <td> {{ ++$i}} </td>
                                    <td>{{$subcategory->categoryName}}</td>
                                    <td>{{$subcategory->subCategoryName}}</td>
                                    <td>{{$subcategory->description}}</td>
                                    <td><i style='color:#5f82bd;font-size:20px;' class='fa fa-edit' onclick="updateModal({{$subcategory->id}})"></i>&emsp;&emsp;&emsp;<i  style='color:red;font-size:20px;' class='fa fa-trash' onclick='deleteSubCategory({{$subcategory->id}})'></i>&emsp;&emsp;&emsp;<?php if($subcategory->status == 'ACTIVE') { ?> <i  style='color:blue;font-size:20px;' class='fas fa-eye' onclick='changeStatus({{$subcategory->id}})'></i><?php } else if($subcategory->status == 'IN-ACTIVE') {?>&emsp;&emsp;&emsp;<i  style='color:blue;font-size:20px;' class='fas fa-eye-slash' onclick='changeStatus({{$subcategory->id}})'></i><?php } ?></td>
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
            <h4 class="custom-modal-title">New Sub Category</h4>
            <div class="custom-modal-text text-left">
                <form method="post" action="addSubCat" id="formId">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="catName">Category Name</label>
                        <div class="col-9">
                        <select class="form-control" id="catId" name="catId" required>
                            <option value="">Select</option>
                            <?php 
                                $cats = \App\Models\Category::get();
                                ?>
                                @foreach($cats as $category) 
                                <option value="{{$category['id']}}">{{$category['categoryName']}}</option>
                                @endforeach
                            
                        </select>
                    </div>
                    </div>
                    <div class="form-group  mb-3">
                        <label for="subcatName" class="col-3 col-form-label">Sub Category Name</label>
                        <div class="col-9">
                            <input type="hidden" class="form-control" id="id" name="id" value="">
                            <input type="text" class="form-control" id="subCatName" name="subCatName" placeholder="Sub Category Name" required>
                        </div>
                    </div>
                    <div class="form-group  mb-3">
                        <label for="subcatDesc" class="col-5 col-form-label">Sub Category Description</label>
                        <div class="col-9">
                            <textarea rows="3" class="form-control" id="subCatDesc" name="subCatDesc" required placeholder="sub Category Description"> </textarea>
                        </div>
                    </div>
                    <div class="form-group mb-0 justify-content-end row">
                        <div class="col-9">
                            <button type="submit" id="buttonChange" class="btn btn-info waves-effect waves-light">Add</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<div>
<script>
     function updateModal(val) {
        $.ajax('getSubMasterCategoryById', {
            type: 'POST',  // http method
            data: { "id": val },  // data to submit
            success: function (data, status, xhr) {
                // alert(data);
                data = JSON.parse(data);
                    loadModal(data);
                },
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
            }
        });
     }


     function saveMasterCategory(id) {
        var catName = $("#catName").val();
        var catDesc = $("#catDesc").val();
        $.ajax('updateCategory', {
            type: 'POST',  // http method
            data: { "id": id, "catName":catName, "catDesc":catDesc },  // data to submit
            success: function (data, status, xhr) {
                if(data == 'success') {
                    toastr.success("Category Updated");
                }    
                setTimeout(function () {
                    location.reload(true);
                }, 2000);
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
        $("#catId").val(data[0].catId);
        $("#subCatName").val(data[0].subCategoryName);
        $("#subCatDesc").val(data[0].description);
        $("#upsert").val("1");
        $("#id").val(data[0].id);
        $("#formId").attr('action','updateSubCat')
        // alert(data[0].id);
        // $("#buttonChange").attr("onclick", "saveMasterCategory("+data[0].id+")");
        $("#buttonChange").html("Update");
        var modal = new Custombox.modal({
            content: {
                effect: 'fadein',
                target: '#custom-modal'
            }
        });

        // Open
        modal.open();
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
        var modal = new Custombox.modal({
        content: {
                effect: 'fadein',
                target: '#custom-modal'
            }
        });

        // Open
        modal.open();
    }
    function deleteSubCategory(id) {
        $.ajax('deleteSubCategory', {
            type: 'POST',  // http method
            data: { "id": id},  // data to submit
            success: function (data, status, xhr) {
                if(data == 'success') {
                    toastr.error("Sub Category Deleted");
                }    
                setTimeout(function () {
                    location.reload(true);
                }, 2000);
            },
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
            }
        });
    }
    function changeStatus(id) {
        $.ajax('changeStatusSubCat', {
            type: 'POST',  // http method
            data: { "id": id},  // data to submit
            success: function (data, status, xhr) {
                if(data == 'success') {
                    toastr.info("Sub Category Status Changed");
                }    
                setTimeout(function () {
                    location.reload(true);
                }, 2000);
            },
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
            }
        });
    }
 </script>
     
 @endsection
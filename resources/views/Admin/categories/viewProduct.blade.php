<!-- {{$products}} -->
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
                                <h3 class="header-title">All Products</h3>
                            </div>
                            <div class="col-6">
                                <div class="" style="float:right;margin-top:-10px;">                                
                                    <button onclick="javascript:location.href='addProduct'" class="btn btn-primary" data-overlayColor="#38414a"><i
                                        class="mdi mdi-plus-circle mr-1" ></i> Add Product</button>
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
                                    <th>Sub Category Name</th>
                                    <th>Product Name</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                <?php $i = 0  ?>
                                @foreach($products as $product)
                                <tr>
                                    <td> {{ ++$i}} </td>
                                    <td>{{$product->categoryName}}</td>
                                    <td>{{$product->subCategoryName}}</td>
                                    <td>{{$product->productName}}</td>
                                    <td>{{$product->description}}</td>
                                    <td><img onclick="showImages({{$product->id}})" style="max-width: 40%; height: auto;" src="storage/app/{{$product->imagePath}}"></td>
                                    <td><i style='color:#5f82bd;font-size:20px;' class='fa fa-edit' onclick="update({{$product->id}})"></i>&emsp;&emsp;&emsp;<i  style='color:red;font-size:20px;' class='fa fa-trash' id="sa-warning" onclick='deleteProduct({{$product->id}})'></i>&emsp;&emsp;&emsp;<?php if($product->status == "ACTIVE") { ?> <i  style='color:blue;font-size:20px;' class='fas fa-eye' onclick='changeStatus({{$product->id}})'></i><?php } else if($product->status == 'IN-ACTIVE') {?>&emsp;&emsp;&emsp;<i  style='color:blue;font-size:20px;' class='fas fa-eye-slash' onclick='changeStatus({{$product->id}})'></i><?php } ?>&emsp;&emsp;&emsp;<i style='color:blue;font-size:20px;' onclick="addImages({{$product->id}})"class='fa fa-plus-circle'></i></td>
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
                <form action="addCategory" id="formId"  method="POST">
                    @csrf
                    <input type="hidden" class="form-control" id="upsert" name="upsert" value="0">
                    <div class="form-group  mb-3">
                        <label for="catName" class="col-3 col-form-label">Category Name</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="catName" name="catName" placeholder="Category Name" required>
                        </div>
                    </div>
                    <div class="form-group  mb-3">
                        <label for="catDesc" class="col-5 col-form-label">Category Description</label>
                        <div class="col-9">
                            <textarea rows="3" class="form-control" id="catDesc" name="catDesc" placeholder="Category Description" required> </textarea>
                        </div>
                    </div>   
                    <div class="form-group mb-0 justify-content-end row">
                        <div class="col-9">
                            <button onclick="saveMasterCategory(0)" id="buttonChange" class="btn btn-info waves-effect waves-light">Add</button>
                        </div>
                    </div>                 
                </form>
                
            </div>
        </div>
    </div>
<div>
<div id="custom-modal-New" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">New Images</h4>
    <div class="custom-modal-text text-left">
    <form id="formId"  method="POST">
        @csrf
        <input type="hidden" class="form-control" id="productId" name="productId">
        <div class="form-group mb-3" >
            <label for="example-input-large">Product Image<span style="color:red;">*</span></label></label>
            <input type="file" id="file" accept="image/*" multiple style="height:10%">
            <input type="hidden" class="form-control-file" name="imageChange" id="imageChange" value="no">
            <img id="imagePath" class="avatar-sm rounded bg-light" style="display:none;" alt="">
        </div>
        <!-- Preview -->
        <div class="dropzone-previews mt-3" id="file-previews"></div>
        <!-- file preview template -->
        <div class="d-none" id="uploadPreviewTemplate">
            <div class="card mt-1 mb-0 shadow-none border">
                <div class="p-2">
                    <div class="row align-items-center">
                    
                        <div class="col-auto">
                            <img data-dz-thumbnail class="avatar-sm rounded bg-light" alt="">
                        </div>
                        <div class="col pl-0">
                            <a href="javascript:void(0);" class="text-muted font-weight-bold" data-dz-name></a>
                            <p class="mb-0" data-dz-size></p>
                        </div>
                        <div class="col-auto">
                            <!-- Button -->
                            <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                <i class="mdi mdi-close-circle"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                        
    </form>  
    <div class="form-group mb-0 justify-content-end row">
            <!-- <div class="col-md-1"></div> -->
            <div class="col-md-6">
                <button onclick="saveImages()" id="buttonChange" class="btn btn-info waves-effect waves-light">Add</button>
            </div>
            
        </div> 
</div>
</div>


<div id="custom-modal-Image" class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Images</h4>
    <div class="custom-modal-text text-left">
        <div class="imageData">
        <!-- <div><a href='javascript:void(0);' class='text-muted font-weight-bold' data-dz-name><img src=storage/app/3/5/logo-sm.png /></a><p class='mb-0 data-dz-size'></p></div><div><a href='javascript:void(0);' class='text-muted font-weight-bold' data-dz-name><img src=storage/app/3/5/3.png /></a><p class='mb-0 data-dz-size'></p></div><div><a href='javascript:void(0);' class='text-muted font-weight-bold' data-dz-name><img src=storage/app/3/5/2.png /></a><p class='mb-0 data-dz-size'></p></div><div><a href='javascript:void(0);' class='text-muted font-weight-bold' data-dz-name><img src=storage/app/3/5/1.png /></a><p class='mb-0 data-dz-size'></p></div><div><a href='javascript:void(0);' class='text-muted font-weight-bold' data-dz-name><img src=storage/app/3/5/images_santosh.jpg /></a><p class='mb-0 data-dz-size'></p></div> -->
        </div>
        
    </div>
</div>
<script>
     function updateModal(val) {
        $.ajax('getMasterCategoryById', {
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

    function saveImages() {
        var image = $('#file')[0].files;
        var formData = new FormData();    
        for (var index = 0; index < image.length; index++) {
            formData.append("files[]", image[index]);
        }
        formData.append("id",$("#productId").val());
        $.ajax("{{url('addImages')}}", {
            type: 'POST',  // http method
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            enctype: 'multipart/form-data', 
            data: formData,   
            success: function (data, status, xhr) {
                if(data == 'success') {
                    toastr.success("Added");
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
    //  function saveMasterCategory(id) {
    //     var catName = $("#catName").val();
    //     var catDesc = $("#catDesc").val();
    //     $.ajax("{{url('updateCategory')}}, {
    //         type: 'POST',  // http method
    //         data: { "id": id, "catName":catName, "catDesc":catDesc },  // data to submit
    //         success: function (data, status, xhr) {
    //             if(data == 'success') {
    //                 toastr.success("Category Updated");
    //             }    
    //             setTimeout(function () {
    //                 location.reload(true);
    //             }, 2000);
    //         },
    //         error: function (jqXhr, textStatus, errorMessage) {
    //             // alert(data+" "+status);
    //         }
    //     });
    //  }
    
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
    function deleteProduct(id) {
        $.ajax("{{url('deleteProduct')}}", {
            type: 'POST',  // http method
            data: { "id": id},  // data to submit
            success: function (data, status, xhr) {
                if(data == 'success') {
                    toastr.error("Product Deleted");
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
        $.ajax("{{url('changeStatusProd')}}", {
            type: 'POST',  // http method
            data: { "id": id},  // data to submit
            success: function (data, status, xhr) {
                if(data == 'success') {
                    toastr.info("Product Status Changed");
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
    function update(id) {
        location.href = "{{url('updateProduct')}}/"+id;
    }
    function addImages(id) {
        // alert(id);
        $("#productId").val(id);
        var modal = new Custombox.modal({
        content: {
                effect: 'fadein',
                target: '#custom-modal-New'
            }
        });

        // Open
        modal.open();
        // $("#productId").val(id);
        // alert($("#productId").val());
    }
    $(document).ready(function() {
        $('input[type="file"]').imageuploadify();
    })
    function showImages(id) {
        $.ajax("{{url('getImagesById')}}", {
            type: 'POST',  // http method
            data: { "id": id},  // data to submit
            success: function (data, status, xhr) {
                // alert(data);
                data = JSON.parse(data);
                var htmlText = "";
                for(var i=0; i<data.length; i++) {
                    htmlText += "<div><a href='javascript:void(0);' class='text-muted font-weight-bold' data-dz-name>";
                    htmlText += "<img src=storage/app/"+data[i]['imagePath']+" />";
                    htmlText += "</a><p class='mb-0 data-dz-size'></p></div>";
                }
                alert(htmlText);
               
               
                $("#imageData").html(htmlText);
            },
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
            }
        }).done(function(){
            var modal = new Custombox.modal({
            content: {
                effect: 'fadein',
                target: '#custom-modal-Image'
                }
            });

            // Open
            modal.open();
        });
        
    }
 </script>
  
 @endsection
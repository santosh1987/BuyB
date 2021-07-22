@extends('Admin.Master')

 @section('content')
 <div class="content">

    <!-- Start Content-->
    <div class="container-fluid">        
        <div class="col-lg-9 mt-4 offset-1 " >
            <div class="card">
                <div class="card-title bg-purple">
                    <h4 style="color:white;padding-left:20px;">Add Product</h4>
                </div>
                <div class="card-body">

                    
                    <div class="form-group mb-3">
                        <label for="example-input-large">Categories<span style="color:red;">*</span></label>
                        <select class="form-control" onchange="loadSubMasterCategory(this.value)" name="categoryName" id="categoryName">
                            <option value="">Select</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->categoryName}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="catChange" id="catChange" class="form-control" value="no">
                    </div>

                    <div class="form-group mb-3">
                    <label for="example-input-large">Sub Categories<span style="color:red;">*</span></label>
                        <select class="form-control" name="subCategoryName" id="subCategoryName">                           
                        </select>
                        <input type="hidden" name="subCatChange" id="subCatChange" class="form-control" value="no">  
                        <input type="hidden" name="upinsert" id="upinsert" class="form-control" value="insert">  
                    </div>

                    <div class="form-group mb-3">
                        <label for="example-input-large">Product Name<span style="color:red;">*</span></label></label>
                        <input type="text" name="productName" id="productName" class="form-control" required="true">
                    </div>
                    <div class="form-group mb-3">
                        <label for="example-input-large">Product Description<span style="color:red;">*</span></label></label>
                        <textarea rows="5" cols="5" class="form-control" name="desc" id="desc"></textarea>
                    </div>
                    <div class="form-group mb-3" >
                        <label for="example-input-large">Product Image<span style="color:red;">*</span></label></label>
                        <input type="file" id="file" accept="image/*" multiple style="height:10%">
                        <input type="hidden" class="form-control-file" name="imageChange" id="imageChange" value="no">
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
                    <div class="row" style="margin-top:2%;">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"><button id="buttonChange" onclick="saveProduct(0)" class="btn btn-primary m-b-0">Add Product</button></div>
                    </div>

                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>
    </div>
<div>
<script>
    function loadSubMasterCategory(id) {
        // var catId = $("#categoryName").val();
        // alert(id);
        $.ajax('getSubMasterCategoryByCatId', {
            type: 'post',  // http method
            data:{"id":id},
            success: function (data, status, xhr) {
                // alert(data);
                data = JSON.parse(data);
                var selectData = "<option >Select</option>";
                //    alert('hi');
                for(var i=0; i<data.length; i++) {
                    // alert("for");
                    selectData += "<option value="+data[i].id+">"+data[i].subCategoryName+"</option>";
                }
                //    alert(selectData);
                $("#subCategoryName").html(selectData);
                },
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
            }
        });
    }
    function saveProduct(id) {
        var categoryName = $("#categoryName").val();
        var subCategoryName = $("#subCategoryName").val();
        var productName = $("#productName").val();
        var description = $("#desc").val();
        var upinsert = $("#upinsert").val();
        
       
        var formDOMObj = document.addProduct;
       
        var image = $('#file')[0].files[0];
        // alert(image);
        // alert(image+" "+ $('#file').val());
        // $('#image').change(function(){
            
        var imageChange = $("#imageChange").val();
        // });
        
        var formData = new FormData();    
        
        formData.append("file",image);
        //alert(file1);
        
        formData.append("categoryName",categoryName);
        formData.append("subCategoryName",subCategoryName);
        formData.append("productName",productName);
        formData.append("description",description);
        formData.append("imageChange",imageChange);

        flag = checkData(categoryName, subCategoryName, productName, image, description, upinsert);
        var targetUrl = ''
        var id1 = 0;
        
        // alert(flag);
        if(upinsert === "insert" && flag) {
            // alert("hi")
            targetUrl = 'saveProduct';
            saveData(targetUrl, formData, id1, upinsert);
        } else if(upinsert === "update"  && flag) {
            targetUrl = 'updateProduct';
            id1 = id;
            formData.append("catChange", $("#catChange").val());
            formData.append("subCatChange", $("#subCatChange").val());
            saveData(targetUrl, formData, id1, upinsert);
        }
       
        // loadDataTable();
        // setTimeout(function () {
        //     location.reload(true);
        // }, 2000);
       
    }
    $(document).ready(function() {
        $('input[type="file"]').imageuploadify();
    })
    $("#file").change(function(){
        // alert('hi');
        $("#imageChange").val("yes");           
    });
    $("#categoryName").change(
        function() {
            $("#catChange").val("yes");
        }
    );
    $("#subCategoryName").change(
        function() {
            $("#subCatChange").val("yes");
        }
    );
    function checkData(categoryName, subCategoryName, productName, image, description, upinsert) {
        flag = true;
        // alert(categoryName+"   "+description);
        if(categoryName == '' || categoryName == null || categoryName == 0) {
            $("#categoryName").focus();
            toastr.error('Please Select One Option, Category Name!')
            return false;
        }
        if(subCategoryName == '' || subCategoryName == null) {
            $("#suCategoryName").focus();
            toastr.error('Please Select One Option, Sub Category Name!')
            return false;
        }
        if(productName == '' || productName == null) {
            $("#productName").focus();
            toastr.error('Can not be Empty, Product Name!')
            return false;
        }
        if(productName != "" && (productName.length <3)) {
            $("#prodcutName").focus();
            toastr.error('Name Should be >4 and <16, Product Name!');
            return false;
        }
        if(description == '' || description == null) {
            $("#desc").focus();           
            toastr.error('Can not be empty, Description!')
            return false;
        }
        if(upinsert === 'insert' && (image == '' || image == null)) {
            toastr.error('Please Select Image')
            $('#filer_input1').focus();           
            return false;
        }

        if(image != "" && image != null) {
            var t = image.type.split('/').pop().toLowerCase();
            // alert(image.size);
            if (t != "jpeg" && t != "jpg" && t != "png" && t != "bmp" && t != "gif") {
                toastr.error('Please Select Valid Image media type')
                $('#file').focus();           
                return false;
            }
            if (image.size > 2048000) {
                toastr.error('Max Upload size is 2MB only');
                $('#file').focus();           
                return false;
            } 
        }
        // alert("hi");
        return flag;
    }
    function saveData(targetUrl, formData, id1, upinsert) {
        formData.append("id", id1);       
        $.ajax(targetUrl, {
            type: 'POST',  // http method
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            enctype: 'multipart/form-data', 
            data: formData,                        
            success: function (data, status, xhr) {
                //   alert(data+" "+status);
                  if(data == "success") {
                        if(upinsert === "insert")
                            toastr.success('Product Saved ');
                        else if(upinsert === "update")
                            toastr.info('Product Updated '); 
                        setTimeout(function () {
                            location.href = 'viewProduct';
                        }, 2000);
                  }

                    
                },
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
                // toastr.error('Sub Category Not Saved '+data);

            }
        });        
    }

</script>  
 @endsection
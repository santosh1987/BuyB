@extends('Master')
<?php 
$requestData = array();
if(!empty($requests) && !empty($products)) {
    $requests = $requests[0];
    $productId = $requests['productId'];
    $subCatId = $products[0]['subCatId'];
    // die($products."hi");
    $catId = $products[0]['catId'];
    $productName = $products[0]['productName'];
    $price = $requests['price'];
    $quantity = $requests['quantity']; 
    $brandName = $requests['brandName']; 
    $mfd = $requests['mfd']; 
    $id = $requests->id;
    $requestData = $requests;
    $expiry = $requests['expiry'];
    // echo $subcategories;
    $to = \Carbon\Carbon::createFromFormat('Y-m-d', $mfd);
    $from = \Carbon\Carbon::createFromFormat('Y-m-d', $expiry);
    $diff_in_months = $to->diffInMonths($from)-1;
    // print_r($diff_in_months); 
    // die();
    $exp = 0;
    if($diff_in_months <= 12) {
        $exp = 1;
    }
    else if($diff_in_months > 12 && $diff_in_months <= 24) {
        $exp = 2;
    }
    else if($diff_in_months > 24 && $diff_in_months <= 36) {
        $exp = 3;
    }
    else if($diff_in_months > 36 && $diff_in_months <= 48) {
        $exp = 4;
    }
}
else {
    $requestData = array();
    $productId = null;
    $subCatId = null;
    $catId = null;
    $productName = null;
    $price = null;
    $quantity = null;
    $brandName = null;
    $mfd = null;
    $id = null;
    $exp = 0;
    $subcategories = array();
}
?>
 @section('content')
 <div class="content">

    <!-- Start Content-->
    <div class="container-fluid">        
        <div class="col-lg-9 mt-4 offset-1 " >
            <div class="card">
                <div class="card-title bg-purple">
                    <h4 style="color:white;padding-left:20px;" id="titleId">Add Product Request</h4>
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
                    </div>

                    <div class="form-group mb-3" id="subMaster" style="display:none">
                        <label for="example-input-large">Sub Categories<span style="color:red;">*</span></label>
                        <select class="form-control" name="subCategoryName" id="subCategoryName" onchange="getProducts(this.value)">                                                
                            
                        </select>                        
                    </div>
                    <div class="form-group mb-3" id="prod" style="display:none;">
                        <label for="example-input-large">Master Products<span style="color:red;">*</span></label>
                        <select class="form-control" name="productId" id="productId">                                               
                            
                        </select>
                        
                    </div>

                    <div id="remDiv" style="display:none;">
                        <div class="form-group form-default">
                            <label class="float-label">Brand Name<span style="color:red;">*</span></label>
                            <input type="text" name="brandName" id="brandName" class="form-control" required="">
                            <span class="form-bar"></span>
                            
                        </div>
                        <div class="form-group form-default">
                            <label class="float-label">Product Quantity(in Kgs)<span style="color:red;">*</span></label>
                            <input type="text" name="quantity" id="quantity" class="form-control" required="">
                            <span class="form-bar"></span>
                        </div>
                        <div class="form-group form-default">
                            <label class="float-label">Product Price(per Kg)<span style="color:red;">*</span></label>
                            <input type="text" name="price" id="price" class="form-control" required="">
                            <span class="form-bar"></span>
                            
                        </div>
                        <div class="form-group form-default">
                            <label class="float-label">Product MFD<span style="color:red;">*</span></label>
                            <input type="date" name="mfd" id="mfd" class="form-control" required="" placeholder="ProductMFD">
                            <span class="form-bar"></span>
                            
                        </div>
                        <div class="form-group form-default">
                            <label class="float-label">Product Expiry</label>
                            <select name="expiry" id="expiry" class="form-control" >
                                <option value="">Select</option>
                                <option value="1">12 months</option>
                                <option value="2">24 months</option>
                                <option value="3">36 months</option>
                            </select>
                            <span class="form-bar"></span>
                            
                        </div>
                    </div>                                                                    
                    <div class="row" id="btnId" style="display:none;">
                        <div class="col-md-4"></div>
                        <div class="col-md-4"><button onclick="saveProduct()" class="btn btn-primary" id="btnChange">Save</button></div>
                    </div>
                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>
    </div>
<div>
<script>
    function loadSubMasterCategory(id, val){
        $.ajax("{{url('getSubMasterCategoryByIdVendor')}}", {
            type: 'post',  // http method 
            data:{"id":id},            
            success: function (data, status, xhr) {
                //   alert(data+" "+status);
                  data = JSON.parse(data);
                  var selectData = "<option value=''>Select</option>";
                  for(var i=0; i<data.length; i++) {
                    selectData += "<option value="+data[i].id+">"+data[i].subCategoryName+"</option>";
                  }
                  $("#subMaster").show();
                  $("#subCategoryName").html(selectData);
                    
                },
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
                toastr.error('Sub Category Not Saved '+data);

            }
        }).done(function() {
            if(val != null) {
            $("#subCategoryName").val("{{$subCatId}}");
            getProducts("{{$catId}}", "{{$subCatId}}", "{{$productId}}");
            }
        });
        
    }
    function getProducts(id, subCat, productId) {
        var catId = $("#categoryName").val();
        var subCatId = $("#subCategoryName").val();
        // alert(subCatId);
        $.ajax("{{url('getProductDataByCatnSubVendor')}}", {
            type: 'post',  // http method 
            data:{"catId":catId, "subCatId":subCatId},            
            success: function (data, status, xhr) {
                //   alert(data+" "+status);
                data = JSON.parse(data);
                  var selectData = "<option value=''>Select</option>";
                  for(var i=0; i<data.length; i++) {
                    selectData += "<option value="+data[i].id+">"+data[i].productName+"("+data[i].description+")"+"</option>";
                  }
                  $("#prod").show();
                  $("#productId").html(selectData);  
                },
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
                toastr.error('Sub Category Not Saved '+data);

            }
        }).done(function(){
            $("#productId").val(productId);   
        });
    }
    $("#productId").change(function() {
        $("#remDiv").show();
        $("#btnId").show();
    });
    function  checkData(categoryName, subCategoryName, productId, brandName, quantity, price, mfd, expiry) {
        if(categoryName == '' || categoryName == null) {
            $("#categoryName").focus();
            toastr.error('Please Select Master Category!')
            return false;
        }
        if(subCategoryName == '' || subCategoryName == null) {
            $("#subCategoryName").focus();
            toastr.error('Please Select Master Sub Category!')
            return false;
        }
        if(productId == '' || productId == null) {
            $("#productId").focus();
            toastr.error('Please Select Product!')
            return false;
        }
        if(brandName == '' || brandName == null) {
            $("#brandName").focus();
            toastr.error('Please Enter Brand Name!')
            return false;
        }
        if(quantity == '' || quantity == null) {
            $("#quantity").focus();
            toastr.error('Please Enter Quantity in Kgs!')
            return false;
        }
        if(price == '' || price == null) {
            $("#price").focus();
            toastr.error('Please Enter Price Per Kgs!')
            return false;
        }
        if(mfd == '' || mfd == null) {
            $("#mfd").focus();
            toastr.error('Please Enter MFD!')
            return false;
        }
        return true;
    }
    function saveProduct(id) {
        var categoryName = $("#categoryName").val();
        var subCategoryName = $("#subCategoryName").val();
        var productId = $("#productId").val();
        var brandName = $("#brandName").val();
        var quantity = $("#quantity").val();
        var price = $("#price").val();
        var mfd = $("#mfd").val();
        var expiry = $("#expiry").val();
        var flag = checkData(categoryName, subCategoryName, productId, brandName, quantity, price, mfd, expiry);
        var formData = new FormData(); 
        var id1 = 0;
        formData.append("categoryName", categoryName);
        formData.append("subCategoryName", subCategoryName);
        formData.append("productId", productId);
        formData.append("brandName", brandName);
        formData.append("quantity", quantity);
        formData.append("price", price);
        formData.append("mfd", mfd);
        formData.append("expiry", expiry);
        if(flag && id  == 0) { 
            saveData("{{url('addProductRequest')}}", formData, 0);
        }
        else if(flag && id != 0) {
            id1 = id;
            saveData("{{url('updateProductRequest')}}", formData, id1);
        }
    }
    function saveData(targetUrl, formData, id1) {
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
                  if(data == "success" && id1 != 1) {
                        toastr.success('Product Request Saved ');
                        
                        setTimeout(function () {
                            location.href = "{{url('viewProductRequest')}}";
                        }, 2000);
                  }
                  if(data == "success" && id1 == 1) {
                        toastr.info('Product Request Updated ');
                        
                        setTimeout(function () {
                            location.href = "{{url('viewProductRequest')}}";
                        }, 2000);
                  }
                    
                },
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
                toastr.error('Not Saved '+data);

            }
        });
        //  loadDataTable();
        
    }
    $( document ).ready(function() {
        var requests = "$requestData";
        // alert(product);
        if(requests != "" && requests != null) {
            $("#titleId").html("Update Product Request");
            $("#remDiv").show();
            $("#categoryName").val("{{$catId}}");
            $("#subMaster").show();
            $("#prod").show();
            loadSubMasterCategory("{{$catId}}", "{{$subCatId}}");
            $("#brandName").val("{{$brandName}}");
            $("#quantity").val("{{$quantity}}");
            $("#price").val("{{$price}}");
            $("#mfd").val("{{$mfd}}");
            $("#btnId").show();
            $("#btnChange").html("Update");
            // $("#btnId").addClass("btn btn-primary");
            $("#btnChange").attr('onclick','saveProduct(1)');
            $("#expiry").val("{{$exp}}");
        }
    });
</script>  
 @endsection
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
                                <h3 class="header-title">All Offers</h3>
                            </div>
                            <div class="col-6">
                                <div class="" style="float:right;margin-top:-10px;">                                
                                    <a href="{{url('addProductRequest')}}" class="btn btn-primary waves-effect waves-light" ><i
                                        class="mdi mdi-plus-circle mr-1"></i> Add Offer</a>
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
                                    <th>SubCategory Name</th>
                                    <th>Product Name</th>
                                    <th>Brand Name</th>
                                    <th>Offer</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Old Price</th>
                                    <th>New Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                <?php $i = 0  ?>
                                @foreach($offers as $offer)
                                <tr>
                                    <td> {{ ++$i}} </td>
                                    <td><p data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$offer->categoryName}}">{{strlen($offer->categoryName) > 20 ? substr($offer->categoryName,0,20)."..." : $$offer->categoryName;}}</p></td>
                                    <td>{{$offer->subCategoryName}}</td>
                                    <td>{{$offer->productName}}</td>
                                    <td>{{$offer->brandName}}</td>
                                    <td>{{$offer->offer}} %</td>
                                    <td>{{$offer->startDate}}</td>
                                    <td>{{$offer->endDate}}</td>
                                    <td>&#8377; {{number_format($request->price, 2)}}</td>
                                    <td>&#8377; {{number_format($request->price, 2)}}</td>
                                    <td><i style='color:#5f82bd;font-size:20px;' class='fa fa-edit' onclick="updateModal({{$request->id}})"></i>&emsp;&emsp;&emsp;<i  style='color:red;font-size:20px;' class='fa fa-trash' id="sa-warning" onclick='deleteProductRequest({{$request->id}})'></i></td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>        
    </div>
<div>
<script>
     function updateModal(val) {
        location.href="{{url('addProductOffer')}}/"+val;
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
        $("#catName").val(data[0].categoryName);
        $("#catDesc").val(data[0].description);
        $("#upsert").val("1");
        // alert(data[0].id);
        $("#buttonChange").attr("onclick", "saveMasterCategory("+data[0].id+")");
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
    function deleteCategory(id) {
        $.ajax('deleteCategory', {
            type: 'POST',  // http method
            data: { "id": id},  // data to submit
            success: function (data, status, xhr) {
                if(data == 'success') {
                    toastr.error("Category Deleted");
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
        $.ajax('changeStatusCat', {
            type: 'POST',  // http method
            data: { "id": id},  // data to submit
            success: function (data, status, xhr) {
                if(data == 'success') {
                    toastr.info("Category Status Changed");
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
    function deleteProductRequest(id) {
        $.ajax("{{url('deleteProductRequest')}}", {
            type: 'POST',  // http method
            data: { "id": id},  // data to submit
            success: function (data, status, xhr) {
                if(data == 'success') {
                    toastr.error("Product Request Deleted");
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
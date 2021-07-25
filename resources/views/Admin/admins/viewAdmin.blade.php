<?php 
// print_r($vendors);
use Illuminate\Support\Str;
?>
@extends('Master')

@section('content')
<div class="content">

   <!-- Start Content-->
   <div class="container-fluid">
       <div class="row mt-3">
           <div class="col-12 ">
               <div class="card">                    
                   <div class="card-body">
                       <div class="row">
                           <div class="col-6">
                               <h3 class="header-title">Representative</h3>
                           </div>
                           <div class="col-6">
                               <div class="" style="float:right;margin-top:-10px;">                                
                                   <a href="{{url('addAdmin')}}" class="btn btn-primary waves-effect waves-light" >
                                    <i class="mdi mdi-plus-circle mr-1" ></i> Add Admin</a>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                            &nbsp;
                       </div>
                       <table id="key-datatable" class="table dt-responsive nowrap">
                           <thead>
                               <tr>
                                   <th>S No</th>
                                   <th>Admin Name</th>
                                   <th>Phone No</th>
                                   <th>E-mail</th>
                                   <th>Address</th>
                                   <th>Actions</th>
                               </tr>
                           </thead>
                       
                           <tbody>
                               <?php $i = 0  ?>
                               @foreach($represents as $represent)
                               <tr>
                                   <td> {{ ++$i}} </td>
                                   <td>{{$represent->name}}</td>
                                   <td>{{$represent->phoneNo}}</td>
                                   <td>{{$represent->email}}</td>
                                   <td>{{$represent->address}}</td>
                                   <td><i style='color:#5f82bd;font-size:20px;'  class='fa fa-edit' onclick="updateAdmin({{$represent->id}})"></i>&emsp;&emsp;&emsp;<i  style='color:red;font-size:20px;' class='fa fa-trash'  onclick='deleteAdmin("{{$represent->id}}")'></i>&emsp;&emsp;&emsp;<?php if($represent['status'] === 'SUSPENDED') { ?><i  style='color:blue;font-size:20px;' class='fa fa-eye-slash' onclick='changeStatus("{{$represent->id}}")'></i><?php } else {?><i  style='color:blue;font-size:20px;' class='fa fa-eye' onclick='changeStatus("{{$represent->id}}")'></i><?php }?></td>
                               </tr>
                               @endforeach
                               
                           </tbody>
                       </table>

                   </div> <!-- end card body-->
               </div> <!-- end card -->
           </div><!-- end col-->
       </div>
       


       <div id="con-close-modal" class="modal-demo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-purple">
                        <h4 class="modal-title">Update Vendor</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="Custombox.modal.close()">×</button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">Vendor Name</label>
                                    <input type="text" class="form-control" id="vendorName" name="vendorName" placeholder="Vendor Name">
                                </div>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-2" class="control-label">Alternate Phone No</label>
                                    <input type="text" class="form-control" id="vendorMobile" name="vendorMobile" placeholder="Vendor Phone No Alternate " class="form-control">
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal-demo" onclick="Custombox.modal.close()">Close</button>
                        <button type="button" id="buttonChange" class="btn btn-info waves-effect waves-light">Save changes</button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal -->
   </div>
<div>
<script>
    function updateModal(val) {
       $.ajax("{{url('getVendorStatus')}}", {
           type: 'POST',  // http method
           data: { "id": val },  // data to submit
           success: function (data, status, xhr) {
            //    alert(data);
               data = JSON.parse(data);
                   loadModal(data);
               },
           error: function (jqXhr, textStatus, errorMessage) {
               // alert(data+" "+status);
           }
       });
    // $("#custom-modal").modal(); 
    
    }

    function updateVendor(id) {
        var vendorName = $("#vendorName").val();
        var alternate = $("#vendorMobile").val();
        $.ajax("{{url('updateVendor')}}", {
           type: 'POST',  // http method
           data: { "id": id, "vendorName": vendorName, "alternate": alternate },  // data to submit
           success: function (data, status, xhr) {
                Custombox.modal.close();
                toastr.info("updatd");
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
       $("#vendorName").val(data[0].vendorName);
       $("#vendorMobile").val(data[0].alternatePhon);
       // alert(data[0].id);
       $("#buttonChange").attr("onclick", "updateVendor("+data[0].id+")");
       $("#buttonChange").html("Update");
       
       //initiate modal
       var modal = new Custombox.modal({
            content: {
                effect: 'fadein',
                target: '#con-close-modal'
            }
        });

        // Open
        modal.open();
   }
   function deleteVendor(id) {
    $.ajax("{{url('deleteVendor')}}", {
           type: 'POST',  // http method
           data: { "id": id},  // data to submit
           success: function (data, status, xhr) {
               toastr.error("Vendor Deleted!!!!");
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
    $.ajax("{{url('changeStatus')}}", {
           type: 'POST',  // http method
           data: { "id": id},  // data to submit
           success: function (data, status, xhr) {
               toastr.info("Vendor Status Updated!!!!");
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
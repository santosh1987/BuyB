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
                                <h3 class="header-title">All Permissions</h3>
                            </div>
                            <div class="col-6">
                                <div class="" style="float:right;margin-top:-10px;">                                
                                    <a href="#con-close-modal" class="btn btn-primary waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlayColor="#38414a"><i
                                        class="mdi mdi-plus-circle mr-1" onclick="loadModalInsert()"></i> Add Permission</a>
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
                                    <th>Permission Name</th>
                                    <th>Display Name</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                <?php $i = 0  ?>
                                @foreach($permissions as $permission)
                                <tr>
                                    <td> {{ ++$i}} </td>
                                    <td>{{$permission->name}}</td>
                                    <td>{{$permission->display_name}}</td>
                                    <td>{{$permission->description}}</td>
                                    <td><i style='color:#5f82bd;font-size:20px;' class='fa fa-edit' onclick="updateModal({{$permission->id}})"></i>&emsp;&emsp;&emsp;<i  style='color:red;font-size:20px;' class='fa fa-trash' id="sa-warning" onclick='deletePermission("{{$permission->id}}")'></i></td>
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
                        <h4 class="modal-title" style="color:white;">Add Permission</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="Custombox.modal.close()">×</button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">Permission Name</label>
                                    <input type="hidden" name="upsert" id="upsert" class="form-control" value="0">
                                    <input type="text" class="form-control" placeholder="Permission Name" id="permissionName" name="permissionName" aria-label="Permission Name">
                                </div>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-2" class="control-label">Persmission Display Name</label>
                                    <input type="text" class="form-control" placeholder="Permission Display Name" id="displayName" name="displayName" aria-label="Permission Display Name">
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-2" class="control-label">Persmission Display Name</label>
                                    <input type="text" class="form-control" placeholder="Permission Description" id="description" name="description" aria-label="Permission Description">                                    
                                </div>
                            </div>
                        </div>                                               
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal-demo" onclick="Custombox.modal.close()">Close</button>
                        <button type="button" id="buttonChange" onclick="savePermission()" class="btn btn-info waves-effect waves-light">Add Permission</button>
                    </div>
                </div>
                </div>
            </div><!-- /.modal -->
    </div>
<div>
<script>
     function updateModal(val) {
        $.ajax('getPermission', {
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

     /* 
        Load Modal Data 
        with data from server
    */
    function loadModal(data) {
        $("#permissionName").val(data[0].name);
        $("#displayName").val(data[0].display_name);
        $("#description").val(data[0].description);
        $("#upsert").val("1");
        // alert(data[0].id);
        $("#buttonChange").attr("onclick", "savePermission("+data[0].id+")");
        $("#buttonChange").html("Update Permission");
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

    /* 
        * Writing this for Refreshing the modal when clicked on add button 
    */
    function loadModalInsert() {
        $("#permissionName").val("");
        $("#displayName").val("");
        $("#upsert").val("0");
        $("#description").val("");
        $("#buttonChange").attr("onclick", "savePermission(0)");
        $("#buttonChange").html("Add Permission");
        
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
    function savePermission(id) {
        var permissionName = $("#permissionName").val();
        var displayName = $("#displayName").val();
        var description = $("#description").val();
        var upsert = $("#upsert").val();
        var formData = new FormData(); 
        formData.append("permissionName", permissionName);
        formData.append("displayName", displayName);
        formData.append("description", description);
        var flag = checkData(permissionName, displayName, description);
        var id1 = 0;
        if(upsert == '0' && flag) {
            
            targetUrl = 'savePermission';
            saveData(targetUrl, formData, id1, upsert);
        } else if(upsert == '1' && flag) {
            targetUrl = 'updatePermission';
            id1 = id;
            saveData(targetUrl, formData, id1, upsert);
        }
    }
    function saveData(targetUrl, formData, id1, upsert) {
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
                        if(data === "success" && upsert == 0) {
                            toastr.success('Permission Saved '); 
                        }
                        else if(data === "success" && upsert == 1) {
                            toastr.success('Permission Updated '); 
                        }
                    },
                error: function (jqXhr, textStatus, errorMessage) {
                    // alert(data+" "+status);
                    toastr.error('Permission Not Saved '+errorMessage);

                }
            }).done(function(data, status, xhr) { //use this
                // alert(mobile);
                setTimeout(function () {
                    location.reload(true);
                }, 2000);
            });
    }
    function checkData(permissionName, displayName, description) {
        if(permissionName == '' || permissionName == null) {
            $("#permissionName").focus();
            toastr.error('Can not be empty, Permission Name!')
            return false;
        }
        if(permissionName != "" && (permissionName.length <3)) {
            $("#permissionName").focus();
            toastr.error('Name Should be >4 and <16, Permission Name!')
            return false;
        }
        if(displayName == '' || displayName == null) {
            $("#displayName").focus();
            toastr.error('Can not be empty, Display Name!')
            return false;
        }
        if(description == '' || description == null) {
            $("#description").focus();
            toastr.error('Can not be empty, Description!')
            return false;
        }
        return true;
    }
    function deletePermission(id) {
        $.ajax("{{url('deletePermission')}}", {
                type: 'POST',  // http method
                data: {"id": id},                        
                success: function (data, status, xhr) {
                    //   alert(data+" "+status);
                        if(data === "success" ) {
                            toastr.error('Permission Deleted '); 
                        }
                        else if(data === "failed" ) {
                            toastr.info('Permission Failed to delete '); 
                        }
                    },
                error: function (jqXhr, textStatus, errorMessage) {
                    // alert(data+" "+status);
                    toastr.error('Permission Not Deleted '+errorMessage);

                }
            }).done(function(data, status, xhr) { //use this
                // alert(mobile);
                setTimeout(function () {
                    location.reload(true);
                }, 2000);
            });
    }

 </script>
 @endsection
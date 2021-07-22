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
                                <h3 class="header-title">All Roles</h3>
                            </div>
                            <div class="col-6">
                                <div class="" style="float:right;margin-top:-10px;">                                
                                    <a href="#con-close-modal" class="btn btn-primary waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlayColor="#38414a"><i
                                        class="mdi mdi-plus-circle mr-1" onclick="loadModalInsert()"></i> Add Role</a>
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
                                    <th>Role Name</th>
                                    <th>Display Name</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                <?php $i = 0  ?>
                                @foreach($roles as $role)
                                <tr>
                                    <td> {{ ++$i}} </td>
                                    <td>{{$role->name}}</td>
                                    <td>{{$role->display_name}}</td>
                                    <td>{{$role->description}}</td>
                                    <td><i style='color:#5f82bd;font-size:20px;' class='fa fa-edit' onclick="updateModal({{$role->id}})"></i>&emsp;&emsp;&emsp;<i  style='color:red;font-size:20px;' class='fa fa-trash' id="sa-warning" onclick='deleteRole("{{$role->id}}")'></i></td>
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
                        <h4 class="modal-title" style="color:white;">Add Role</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="Custombox.modal.close()">×</button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-1" class="control-label">Role Name</label>
                                    <input type="hidden" name="upsert" id="upsert" class="form-control" value="0">
                                    <input type="text" class="form-control" placeholder="Role Name" id="roleName" name="roleName" aria-label="Role Name">
                                </div>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-2" class="control-label">Role Display Name</label>
                                    <input type="text" class="form-control" placeholder="Role Display Name" id="displayName" name="displayName" aria-label="Role Display Name">
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="field-2" class="control-label">Role Description</label>
                                    <input type="text" class="form-control" placeholder="Role Description" id="description" name="description" aria-label="Role Description">                                    
                                </div>
                            </div>
                        </div>                                               
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal-demo" onclick="Custombox.modal.close()">Close</button>
                        <button type="button" id="buttonChange" onclick="saveRole()" class="btn btn-info waves-effect waves-light">Add Role</button>
                    </div>
                </div>
                </div>
            </div><!-- /.modal -->
    </div>
<div>
<script>
     function updateModal(val) {
        $.ajax('getRole', {
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
        $("#roleName").val(data[0].name);
        $("#displayName").val(data[0].display_name);
        $("#description").val(data[0].description);
        $("#upsert").val("1");
        // alert(data[0].id);
        $("#buttonChange").attr("onclick", "saveRole("+data[0].id+")");
        $("#buttonChange").html("Update Role");
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
        $("#roleName").val("");
        $("#displayName").val("");
        $("#upsert").val("0");
        $("#description").val("");
        $("#buttonChange").attr("onclick", "saveRole(0)");
        $("#buttonChange").html("Add Role");
        
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
    function saveRole(id) {
        var roleName = $("#roleName").val();
        var displayName = $("#displayName").val();
        var description = $("#description").val();
        var upsert = $("#upsert").val();
        var formData = new FormData(); 
        formData.append("roleName", roleName);
        formData.append("displayName", displayName);
        formData.append("description", description);
        var flag = checkData(roleName, displayName, description);
        var id1 = 0;
        if(upsert == '0' && flag) {
            
            targetUrl = 'saveRole';
            saveData(targetUrl, formData, id1, upsert);
        } else if(upsert == '1' && flag) {
            targetUrl = 'updateRole';
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
                            toastr.success('Role Saved '); 
                        }
                        else if(data === "success" && upsert == 1) {
                            toastr.success('Role Updated '); 
                        }
                    },
                error: function (jqXhr, textStatus, errorMessage) {
                    // alert(data+" "+status);
                    toastr.error('Role Not Saved '+errorMessage);

                }
            }).done(function(data, status, xhr) { //use this
                // alert(mobile);
                setTimeout(function () {
                    location.reload(true);
                }, 2000);
            });
    }
    function checkData(roleName, displayName, description) {
        if(roleName == '' || roleName == null) {
            $("#roleName").focus();
            toastr.error('Can not be empty, Role Name!')
            return false;
        }
        if(roleName != "" && (roleName.length <3)) {
            $("#roleName").focus();
            toastr.error('Name Should be >4 and <16, Role Name!')
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
    function deleteRole(id) {
        $.ajax("{{url('deleteRole')}}", {
                type: 'POST',  // http method
                data: {"id": id},                        
                success: function (data, status, xhr) {
                    //   alert(data+" "+status);
                        if(data === "success" ) {
                            toastr.error('Role Deleted '); 
                        }
                        else if(data === "failed" ) {
                            toastr.info('Role Failed to delete '); 
                        }
                    },
                error: function (jqXhr, textStatus, errorMessage) {
                    // alert(data+" "+status);
                    toastr.error('Role Not Deleted '+errorMessage);

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
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
                                <h3 class="header-title">Assign Permissions</h3>
                            </div>
                            
                        </div>
                        <div class="row">
                    &nbsp;
                        </div>
                        <div class="row">
                            <div class="col-md-9 offset-2">
                                <div class="form-group mb-3">
                                    <label for="example-select">Select Role</label>
                                    <select class="form-control" id="roleId" onchange="getPermissions(this.value)">
                                        <option>Select Role</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-3" style="display:none;" id="showDiv">
                                    <label for="example-select">Assigned Roles</label>
                                    <div id="selectedRoles">
                                    </div>
                                    <label for="example-select">Not Assigned Roles</label>
                                    <div id="notselectedRoles">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <button class="btn btn-primary" style="display:none;" id="buttonChange">Save Changes</button>
                                </div>
                            </div> 
                        </div>
                        
                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        
        
    </div>
<div>
<script>
     function getPermissions(value) {
        $.ajax("{{url('getPermissionByRoleId')}}", {
            type: 'POST',  // http method
            data: {"id": value},                        
            success: function (data, status, xhr) {
                //   alert(data+" "+status);
                //    alert(data);
                   data = JSON.parse(data);
                   var text = '';
                   for(var i=0; i<data.length; i++) {
                       text += "<input class='form-select' type='checkbox' name='selectbox[]' id='selectbox' checked='true' value='"+data[i].id+"' /><lable>"+data[i].name+"</lable><br>";
                   }
                   $("#selectedRoles").html(text);
                   getNotAssignedPermission(value);
                   $("#showDiv").show();
                },
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
                

            }
        }).done(function(data, status, xhr) { //use this
            // alert(mobile);
           
        });
     }
     function getNotAssignedPermission(value) {
        $.ajax("{{url('getNotAssignedPermissionByRoleId')}}", {
            type: 'POST',  // http method
            data: {"id": value},                        
            success: function (data, status, xhr) {
                //   alert(data+" "+status);
                //    alert(data);
                data = JSON.parse(data);
                var text = '';
                for(var i=0; i<data.length; i++) {
                    text += "<input class='form-select' type='checkbox' name='unselectbox[]' id='unselectbox' value='"+data[i].id+"'  /><lable>"+data[i].name+"</lable><br>";
                }
                if(text === '')
                    $("#notselectedRoles").html("No Roles to be assign");
                else
                    $("#notselectedRoles").html(text);    
                $("#buttonChange").show();  
                },
                error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
                

                }
            }).done(function(data, status, xhr) { //use this
            // alert(mobile);
           
        });
     }
     $("#buttonChange").click(function() {
        alert('hi');
        var roleId = $("#roleId").val();
        var selected = []
        $("#selectbox:checked").each(function()
        {
            selected.push($(this).val());
        });
        $("#unselectbox:checked").each(function()
        {
            selected.push($(this).val());
        });
        alert(selected);
        $.ajax("{{url('updatePermissions')}}", {
            type: 'POST',  // http method
            data: {"id": roleId, "selected":selected},                        
            success: function (data, status, xhr) {
                //   alert(data+" "+status);
                //    alert(data);
                    if(data === "success") {
                        toastr.success("Permissions are updated for the selected role!!!");
                    } else {
                        toastr.danger("Permissions are not updated for the selected role!!!");
                    }

                },
                error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
                

                }
            }).done(function(data, status, xhr) { //use this
            // alert(mobile);
            setTimeout(function(){ location.reload() }, 3000);
           
        });




     });
 </script>
 @endsection
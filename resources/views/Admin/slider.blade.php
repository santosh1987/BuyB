
@extends('master')

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
                                <h3 class="header-title">All Sliders</h3>
                            </div>
                            <div class="col-6">
                                <div class="" style="float:right;margin-top:-10px;">                                
                                    <button href="#exampleModalScrollable"  class="btn btn-primary waves-effect waves-light" id="btnId" data-animation="fadein" data-plugin="custommodal" data-overlayColor="#38414a"><i
                                        class="mdi mdi-plus-circle mr-1" onclick="loadModalInsert()" ></i> Add Slider</button>
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
                                    <th>Title</th>
                                    <th>Text</th>
                                    <th>Button Text</th>
                                    <th>Button Url</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                <?php $i = 0  ?>
                                @foreach($sliders as $slider)
                                <tr>
                                    <td> {{ ++$i}} </td>
                                    <td>{{$slider->title}}</td>
                                    <td>{{$slider->text}}</td>
                                    <td>{{$slider->buttonText}}</td>
                                    <td>{{$slider->buttonUrl}}</td>
                                    <td><img style="max-width: 40%; height: auto;" src="storage/app/{{$slider->imagePath}}"></td>
                                    <td><i style='color:#5f82bd;font-size:20px;' class='fa fa-edit' onclick="updateModal({{$slider->id}})"></i>&emsp;&emsp;&emsp;<i  style='color:red;font-size:20px;' class='fa fa-trash' id="sa-warning" onclick='deleteSlider({{$slider->id}})'></i>&emsp;&emsp;&emsp;<?php if($slider->status == "ACTIVE") { ?> <i  style='color:blue;font-size:20px;' class='fas fa-eye' onclick='changeStatus({{$slider->id}})'></i><?php } else if($slider->status == 'IN-ACTIVE') {?>&emsp;&emsp;&emsp;<i  style='color:blue;font-size:20px;' class='fas fa-eye-slash' onclick='changeStatus({{$slider->id}})'></i><?php } ?></td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>
        
         <!-- Long Content Scroll Modal -->
         <div class="modal-demo" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header  bg-purple">
                        <h5 class="modal-title" style="color:white;" id="exampleModalScrollableTitle">Add Slider</h5>
                        <button type="button" class="close" data-dismiss="modal-demo" aria-label="Close" onclick="Custombox.modal.close();">
                            <span style="color:black;"  aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group  mb-3">
                            <label for="Slider Title" class="col-5 col-form-label">Slider Title<span style="color:red">*</span></label>
                            <div class="col-9">
                                <input type="hidden" class="form-control" id="upsert" name="upsert" value="0">
                                <input type="text" class="form-control" id="sliderTitle" name="sliderTitle" placeholder="Slider Title" required />
                            </div>
                        </div> 
                        <div class="form-group  mb-3">
                            <label for="text" class="col-3 col-form-label">Slider Text<span style="color:red">*</span></label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="sliderText" name="sliderText" placeholder="Slider Text" required>
                            </div>
                        </div>
                        <div class="form-group  mb-3">
                            <label for="buttontext" class="col-3 col-form-label">Button Text<span style="color:red">*</span></label>
                            <div class="col-9">
                                <textarea rows="3" class="form-control" id="buttonText" name="buttonText" placeholder="Button Text" required></textarea>
                            </div>
                        </div>
                        <div class="form-group  mb-3">
                            <label for="buttonurl" class="col-3 col-form-label">Button URL<span style="color:red">*</span></label>
                            <div class="col-9">
                            <textarea rows="3" class="form-control" id="buttonUrl" name="buttonUrl" placeholder="Button URL" required></textarea>
                            </div>
                        </div>
                        <div class="form-group mb-3" >
                            <label for="example-input-large">Slider Image<span style="color:red;">*</span></label></label>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="Custombox.modal.close();" data-dismiss="modal-demo">Close</button>
                        <button type="button" onclick="saveSlider(0)" id="buttonChange" class="btn btn-info waves-effect waves-light">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div>
<script>
     function updateModal(val) {
        $.ajax("{{url('getSliderById')}}", {
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


     function saveSlider(id) {
        var sliderTitle = $("#sliderTitle").val();
        var sliderText = $("#sliderText").val();
        var buttonText = $("#buttonText").val();
        var buttonUrl = $("#buttonUrl").val();
        var upsert = $("#upsert").val();
        var image = $('#file')[0].files[0];
        var imageChange = $("#imageChange").val();

        var id1 = 0;
        var formData = new FormData();
        formData.append("sliderTitle", sliderTitle);
        formData.append("sliderText", sliderText);
        formData.append("buttonText", buttonText);
        formData.append("buttonUrl", buttonUrl);
        formData.append("upsert", upsert);
        formData.append("image", image);
        formData.append("imageChange", imageChange);
        var targetUrl = '';
        var flag = checkData(sliderTitle, sliderText, buttonText, buttonUrl, upsert, image);
        if(flag && upsert == 0) {
            targetUrl = "{{url('saveSlider')}}";
        }
        else if(flag && upsert == 1) {
            id1 = id;
            targetUrl = "{{url('updateSlider')}}";
            formData.append("id", id1);
        }
        
        saveData(targetUrl, formData, upsert, id1);
     }
     function checkData(sliderTitle, sliderText, buttonText, buttonUrl, upsert, image) {
        flag = true;
        // alert(categoryName+"   "+description);
        if(sliderTitle == '' || sliderTitle == null) {
            $("#sliderTitle").focus();
            toastr.error('Please Enter Slider Text!')
            return false;
        }
        if(sliderText == '' || sliderText == null) {
            $("#sliderText").focus();
            toastr.error('Please Enter Slider Text!')
            return false;
        }
        if(buttonText == '' || buttonText == null) {
            $("#buttonText").focus();
            toastr.error('Can not be Empty, Slider Button Text!')
            return false;
        }
        if(buttonText != "" && (buttonText.length <3)) {
            $("#buttonText").focus();
            toastr.error('Button text Should be >4 and <16, Button Text!');
            return false;
        }
        if(buttonUrl == '' || buttonUrl == null) {
            $("#buttonUrl").focus();
            toastr.error('Can not be Empty, Slider Button Url!')
            return false;
        }
        if(buttonUrl != "" && (buttonUrl.length <3)) {
            $("#buttonUrl").focus();
            toastr.error('Button Url Should be >4 and <16, Button Url!');
            return false;
        }
        
        if(upsert === '0' && (image == '' || image == null)) {
            toastr.error('Please Select Image')
            $('#file').focus();           
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
     function saveData(targetUrl, formData, upsert, id1) {
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
                        if(upsert === "0")
                            toastr.success('Slider Saved ');
                        else if(upsert === "1")
                            toastr.info('Slider Updated '); 
                        setTimeout(function () {
                            location.href = "{{url('viewSlider')}}";
                        }, 2000);
                  }

                    
                },
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
                // toastr.error('Sub Category Not Saved '+data);

            }
        });
     }
    
    /* 
        * Writing this for Refreshing the modal when clicked on add button 
    */
    function loadModalInsert() {
        $("#sliderTitle").val();
        $("#sliderText").val();
        $("#buttonText").val();
        $("#buttonUrl").val();
        $("#upsert").val("0");
        $("#imagePath").hide();
        // $("#imagePath").attr('src','./storage/app/'+data[0].imagePath);
        $("#buttonChange").attr("onclick", "saveSlider(0)");
        $("#buttonChange").html("Save Slider");
        $("#exampleModalScrollableTitle").html("Add Slider");
        var modal = new Custombox.modal({
            content: {
                effect: 'fadein',
                target: '#exampleModalScrollable'
            }
        });

        // Open
        modal.open();
    }
    function deleteSlider(id) {
        $.ajax("{{url('deleteSlider')}}", {
            type: 'POST',  // http method
            data: { "id": id},  // data to submit
            success: function (data, status, xhr) {
                if(data == 'success') {
                    toastr.error("Slider Deleted");
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
        $.ajax("{{url('changeStatusSlide')}}", {
            type: 'POST',  // http method
            data: { "id": id},  // data to submit
            success: function (data, status, xhr) {
                if(data == 'success') {
                    toastr.info("Slider Status Changed");
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
    
    $(document).ready(function() {
        $('input[type="file"]').imageuploadify();
    })
    function loadModal(data) {
   
        $("#sliderTitle").val(data[0].title);
        $("#sliderText").val(data[0].text);
        $("#buttonText").val(data[0].buttonText);
        $("#buttonUrl").val(data[0].buttonUrl);
        $("#upsert").val("1");
        $("#imagePath").show();
        $("#imagePath").attr('src','./storage/app/'+data[0].imagePath);
        $("#buttonChange").attr("onclick", "saveSlider("+data[0].id+")");
        $("#buttonChange").html("Update Slider");
        $("#exampleModalScrollableTitle").html("Update Slider");
        var modal = new Custombox.modal({
            content: {
                effect: 'fadein',
                target: '#exampleModalScrollable'
            }
        });

        // Open
        modal.open();        
    }
    $("#file").change(function(){
        // alert('hi');
        $("#imageChange").val("yes");   
        $("#imagePath").hide();        
    });
 </script>
  
 @endsection
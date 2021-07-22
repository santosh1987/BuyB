@extends('Master')

 @section('content')
 <style>
 .inputs input {
    width: 8%;
    height: auto;
}
.inputs .form-control:focus {
    box-shadow: none;
    border: 2px solid #6F1667
}
</style>
 <div class="content">

    <!-- Start Content-->
    <div class="container-fluid">
        
        <div class="col-lg-10 offset-1 mt-4 " >
            <div class="card">
                <div class="card-header bg-purple py-3 text-white">
                    <h5 class="card-title mb-0 text-white">Add Permission</h5>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3 col-md-9">
                        <input type="text" class="form-control" placeholder="Permission Name" id="permissionName" name="permissionName" aria-label="Permission Name">
                    </div>
                    <div class="input-group mb-3 col-md-9">
                        <input type="text" class="form-control" placeholder="Permission Display Name" id="displayName" name="displayName" aria-label="Permission Display Name">
                    </div>
                    <div class="input-group mb-3 col-md-9">
                        <input type="text" class="form-control" placeholder="Permission Description" id="description" name="description" aria-label="Permission Description">
                    </div>                   
                   
                </div>  <!-- end card-body -->
            </div>  <!-- end card -->
        </div>
    </div>
<div>
<script>
var jsonData = '';
var trails = 1;
function checkEmail(email) {
    if(email!=null && email!= "") {
        $.ajax('checkEmail', {
            type: 'POST',  // http method
            data: { "email": email },  // data to submit
            success: function (data, status, xhr) {
               
                if(data === "yes") {
                    alert("Email Existed")
                    toastr.error("Please Use the different email!!")
                    // $('#your_link_id').click()
                    $("#email").focus();
                    return true;
                }
                
                // alert(data.data.lgnm);
            },   
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
            }
        });
    }
    return false;
}
function saveData() {
    var email = $("#email").val();
    var mobileVerified = $("#isVerifiedMobile").val();
    var gstVerified = $("#isVerifiedGst").val();
    var flag = checkEmail(email);
    var formData = new FormData(); 
    formData.append("phoneNum", $("#mobile").val());
    formData.append("jsonData", jsonData);
    formData.append("email", email);
    if(!flag) {
        $.ajax('addVendor', {
            type: 'POST',  // http method
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            enctype: 'multipart/form-data', 
            data: formData,                        
            success: function (data, status, xhr) {
                //   alert(data+" "+status);
                    if(data === "success") {
                        toastr.success('Vendor Saved ');                  
                        
                    }
                },
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
                toastr.error('Vendor Not Saved '+errorMessage);

            }
        }).done(function(data, status, xhr) { //use this
            // alert(mobile);
            // location.href="{{ url('dashboard')}}";  
        });

    }
}
function checkData(gst) {
    var Exp = /((^[0-9]+[a-z]+)|(^[a-z]+[0-9]+))+[0-9a-z]+$/i;

    if(!gst.match(Exp)) {
       toastr.error('GST is not alphanumeric');
       $("#gstNo").focus();
       return false;
    }
    else if(gst.length < 15) {
        toastr.error('GST Should be 15 chars length');
        $("#gstNo").focus();
       return false;
    }
    return true;
}
function checkGst(gst) {
    if(!checkData(gst)) {
        // toastr.error("GSTIN Entered is invalid");
        return false;
    }
    $.ajax('checkGst', {
            type: 'POST',  // http method
            data: { "gst": gst },  // data to submit
            success: function (data, status, xhr) {
               
                if(data === "yes") {
                    // alert("GST Existed")
                    toastr.error("Please Use the different GSTIN!!")
                    // $('#your_link_id').click()
                    $("#gstNo").focus();
                    return true;
                }
                
                // alert(data.data.lgnm);
            },   
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
            }
        });
}
function verifyGst() {
    var gst = $("#gstNo").val();
    var flag = checkData(gst);
    var flagOne = checkGst(gst);
    if(flag && !flagOne) {
        $.ajax('getGstDetails', {
            type: 'POST',  // http method
            data: { "id": gst },  // data to submit
            success: function (data, status, xhr) {
                // data = JSON.parse(data);
                jsonData = data;
                data = JSON.parse(data);
                // alert(data.flag);
                if(data.flag === false) {
                    // alert("Invalid")
                    toastr.error("Invalid GST Details Found Please Enter Valid One!!!")
                    // $('#your_link_id').click()
                }
                else if(data.flag == true) {
                    toastr.success("Valid GST Details Found Please Enter Remaining Data!!!")
                    $("#isVerifiedGst").val("yes");
                    $("#mobileDiv").show();
                    $("#gstNo").attr("dsiabled","true");
                    $("#gstButton").attr("dsiabled","true");
                }
                // alert(data.data.lgnm);
            },   
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
            }
        });
    }
    else {
        // toastr.error("Invalid GST Details Entered Please Enter Valid One!!!")
    }
}
function checkMobile(mobile) {
    $.ajax('checkMobile', {
        type: 'POST',  // http method
        data: { "mobile": mobile },  // data to submit
        success: function (data, status, xhr) {
            // alert(data);
            
            
            // alert(data.data.lgnm);
        },   
        error: function (jqXhr, textStatus, errorMessage) {
            // alert(data+" "+status);
        }
    }).done(function(data, status, xhr) { //use this
        // alert(mobile);
        if(data === "yes") {
                // alert("Mobile Existed")
                toastr.error("Please Use the different Phone No!!")
                // $('#your_link_id').click()
                $("#mobile").focus();
                return true;
        }
        else {
            sendOtp(mobile);
        }
    });
    // return false;
    
}
function sendOtp(mobile) {
    $.ajax('sendOtp', {
        type: 'POST',  // http method
        data: { "mobile": mobile },  // data to submit
        success: function (data, status, xhr) {
            //   alert(data+" "+status);
            $("#vrfyBtn").attr("disabled","true");
            mobile = mobile.replace(/\d(?=\d{4})/g, "*");
            $("#sendto").html("+91-"+mobile)
            $("#mobile").attr("disabled","true");
            $("#verifyCode").val(data);
            $("#form").show();
            $("#fstDigit").focus();
            $("#resendCode").html("Resend ("+trails+")/3");
            
        },
        error: function (jqXhr, textStatus, errorMessage) {
            alert(errorMessage+" "+status);
        }
    });
}
function verifyMobile() {
    var mobile = $("#mobile").val();
    var phoneno = /^\d{10}$/;
    if(mobile == '' || mobile == null) {
        toastr.error('Please Enter  Mobile!');
        $("#mobile").focus();
        // return false;
    }
    if(!(mobile.match(phoneno))) {
        toastr.error('Please Enter 10 Digit Mobile!');
        $("#mobile").focus();
    }
    
    else if(trails > 3) {
        toastr.error("Trials Exceeded");
        $("#mobile").attr("disabled","false");
        $("#form").hide();
    }
    checkMobile(mobile);
}
function verifyCode() {
    var phoneNum = $("#mobile").val();
        var verificationCode = $("#input1").val()+""+$("#input2").val()+""+$("#input3").val()+""+$("#input4").val();
        // alert(verificationCode)
        var formData = new FormData();    
        formData.append("phoneNum",phoneNum);
        formData.append("verificationCode",verificationCode);
        $.ajax(
        {
            url: "{{url('verifyCode')}}", 
            type: 'POST',
            enctype: 'multipart/form-data',
            data: formData,
            success: function (data) {
            //   data = JSON.parse(data);
                if(data!="" && data != "failed")
                {
                    $("#form").hide();
                    $("#remDiv").show();
                    toastr.success("Mobile Verified");
                    $("#isVerifiedMobile").val("yes");
                }
                else if(data == "" || data != "failed" || data == 'pending'){
                    toastr.error("Mobile not validated, Please Re enter the code");
                    $("#input1").focus();
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });

}

function resendCode() {
    verifyMobile();
    trails += 1;
}
</script>
 @endsection
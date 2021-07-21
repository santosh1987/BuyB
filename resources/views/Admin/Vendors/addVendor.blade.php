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
                    <h5 class="card-title mb-0 text-white">Add Vendor</h5>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3 col-md-9">
                        <input type="hidden" id="isVerifiedMobile" value="no" />
                        <input type="hidden" id="isVerifiedGst" value="no" />
                        <input type="text" class="form-control" placeholder="GST No" id="gstNo" name="gatNo" aria-label="GST NO">
                        <div class="input-group-append">
                            <button class="btn btn-dark waves-effect waves-light" type="button" id="gstButton" onclick="verifyGst()">Verify GSTIN</button>
                        </div>
                    </div>
                    <div style="display:block;" id="mobileDiv">
                        <div class="input-group mb-3 col-md-9">
                            <input type="text" class="form-control" placeholder="Mobile No" id="mobile" name="mobile" aria-label="GST NO">
                            <div class="input-group-append">
                                <button class="btn btn-dark waves-effect waves-light" type="button" id="vrfyBtn" onclick="verifyMobile()">Verify Mobile</button>
                            </div>
                        </div>
                    </div>
                    <div id="form" style="display:block">
                        <div class="position-relative">
                            <div class="card p-2 text-center">
                                <h6>Please enter the one time password <br> </h6>
                                <div> <span> sent to</span> <small id="sendto"></small> </div>
                                <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2"> 
                                    <input class="m-2 text-center form-control rounded" type="text" id="input1" v-on:keyup="inputenter(1)" pattern="[0-9]{1}" maxlength="1" /> 
                                    <input class="m-2 text-center form-control rounded" v-on:keyup="inputenter(2)" pattern="[0-9]{1}" type="text" id="input2" maxlength="1" /> 
                                    <input class="m-2 text-center form-control rounded" v-on:keyup="inputenter(3)" pattern="[0-9]{1}" type="text" id="input3" maxlength="1" /> 
                                    <input class="m-2 text-center form-control rounded" v-on:keyup="inputenter(4)" pattern="[0-9]{1}" type="text" id="input4" maxlength="1" /> 
                                </div>
                                <div class="mt-4"> <button onclick="verifyCode()" class="btn btn-danger px-4 validate">Validate</button> </div>
                                <div class="mt-3 content d-flex justify-content-center align-items-center"> <span>Didn't get the code</span> <a href="#" onclick="resendCode()" class="text-decoration-none ms-3" id="resendCode">Resend(1/3)</a> </div>
                            </div>
                        </div>
                    </div>
                    <div id="remDiv" style="display:block;">
                        <div class="form-group  mb-3">
                            <label for="email" class="col-5 col-form-label">Vendor E-mail</label>
                            <div class="col-9">
                                <input type="email" class="form-control" placeholder="Vendor E-Mail" id="email" name="email" aria-label="Vendor E-mail">
                            </div>
                        </div>   
                        <div class="input-group mb-3 col-md-9">
                            <button class="btn btn-primary" id="saveData" onclick="saveData()"> Save</button>
                        </div>                     
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
                        document.href="viewVendors";  
                    }
                },
            error: function (jqXhr, textStatus, errorMessage) {
                // alert(data+" "+status);
                toastr.error('Vendor Not Saved '+errorMessage);

            }
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
            
            if(data === "yes") {
                alert("Mobile Existed")
                toastr.error("Please Use the different Phone No!!")
                // $('#your_link_id').click()
                $("#mobile").focus();
                return true;
            }
            
            // alert(data.data.lgnm);
        },   
        error: function (jqXhr, textStatus, errorMessage) {
            // alert(data+" "+status);
        }
    });
    return false;
    
}
function verifyMobile() {
    var mobile = $("#mobile").val();
    var flag = checkMobile(mobile);
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
    else if(flag) {
        toastr.error('Existed  Mobile!');
        $("#mobile").focus();  
    }
    
    else if(trails > 3) {
        toastr.error("Trials Exceeded");
        $("#mobile").attr("disabled","false");
        $("#form").hide();
    }
    else {
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
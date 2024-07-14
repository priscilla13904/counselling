<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $msg = $_POST['msg'];

    // Validate inputs (add more validation as needed)
    if (empty($name) || empty($subject) || empty($email) || empty($phone) || empty($msg)) {
        echo json_encode(["status" => 400, "msg" => "All fields are required."]);
        exit;
    }

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'edoc');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO contacts (name, subject, email, phone, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $subject, $email, $phone, $msg);

    if ($stmt->execute()) {
        echo json_encode(["status" => 200, "msg" => "Data submitted successfully."]);
    } else {
        echo json_encode(["status" => 500, "msg" => "Error submitting data."]);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" >
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media-query.css">
    <title>Contact Us</title>
</head>
<body>
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="contact-box">
                    <div class="contact-area">
                        <div class="contact-header">
                            <h4 class="header-text"> Contact Form</h4>
                            <p class="mb-0">Submit your Request or Feedback</p>
                        </div>
                        <div class="contact-body">
                            <a href="../patient/index.php" class="btn btn-primary mb-3">Back</a> <!-- Back Button -->
                            <form method="post" id="contact-form" autocomplete="off">
                                <div class="contact-field">
                                    <div class="contact-field-sub">
                                        <label class="label-text">Name *</label>
                                        <span class="primary-field-icon"><i class="fas fa-user"></i></span>
                                        <input type="text" name="name" id="name" class="primary-field form-control">
                                    </div>
                                    <div class="contact-field-sub">
                                        <label class="label-text">Subject *</label>
                                        <span class="primary-field-icon"><i class="fas fa-clipboard"></i></span>
                                        <input type="text" name="subject" id="subject" class="primary-field form-control">
                                    </div>
                                </div>
                                <div class="contact-field">
                                    <div class="contact-field-sub">
                                        <label class="label-text">Email *</label>
                                        <span class="primary-field-icon"><i class="fas fa-envelope"></i></span>
                                        <input type="text" name="email" id="email" class="primary-field form-control">
                                    </div>
                                    <div class="contact-field-sub">
                                        <label class="label-text">Phone Number *</label>
                                        <span class="primary-field-icon"><i class="fas fa-phone"></i></span>
                                        <input type="text" name="phone" id="phone" class="primary-field form-control">
                                    </div>
                                </div>
                                <div class="contact-field">
                                    <div class="contact-field-msg-sub">
                                        <label class="label-text">Message *</label>
                                        <span class="primary-field-msg-icon"><i class="fas fa-comment"></i></span>
                                        <textarea name="msg" id="msg" class="form-control primary-field-textarea"></textarea>
                                    </div>
                                </div>
                                <div class="contact-field">
                                    <div class="success-msg"> Thank You For Contact Us. </div>
                                </div>    
                                <div class="contact-field">
                                    <input type="submit" value="Send" class="my-btn" id="submit">
                                    <button class="my-btn" id="loader" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function () {
        $('#loader, .success-msg').hide();

        $.validator.addMethod("regex", function(value, element, regexp){
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        }, "Invalid Validation Expression");

        $('#contact-form').validate({
            rules : {
                name : {
                    required : true,
                    normalizer: function(value) {
                        return $.trim(value);
                    },
                    regex : /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/,
                    minlength : 3,
                    maxlength : 100
                },
                subject : {
                    required : true,
                    normalizer: function(value) {
                        return $.trim(value);
                    },
                    regex : /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/,
                    minlength : 3,
                    maxlength : 200
                },
                email : {
                    required : {
                        depends: function () {
                            $(this).val($.trim($(this).val()));
                            return true;
                        }
                    },
                    maxlength : 100,
                    regex : /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                },
                phone : {
                    required : true,
                    normalizer: function(value) {
                        return $.trim(value);
                    },
                    regex : /^(1\s?)?((\([0-9]{3}\))|[0-9]{3})[\s\-]?[\0-9]{3}[\s\-]?[0-9]{4}$/
                },
                msg : {
                    required : true,
                    normalizer: function(value) {
                        return $.trim(value);
                    },
                    minlength : 3,
                    maxlength : 5000
                }
            },
            messages : {
                name : {
                    required : 'Please Enter Your Name',
                    minlength : 'Please Enter Valid Name',
                    maxlength : 'Only 100 Charater Allow',
                    regex : 'Only Number and Letters Allow'
                },
                subject : {
                    required : 'Please Enter Subject',
                    minlength : 'Please Enter Valid Subject Name',
                    maxlength : 'Only 200 Charater Allow',
                    regex : 'Only Number and Letters Allow'
                },
                email : {
                    required : 'Please Enter Email',
                    maxlength : 'Only 100 Charater Allow',
                    regex : 'Please Enter Valid Email Address'
                },
                phone : {
                    required : 'Please Enter Phone number',
                    regex : 'Please Enter Valid Number (US)' 
                },
                msg : {
                    required : 'Please Enter Message',
                    minlength : 'Please Enter Valid Message',
                    maxlength : 'Only 5000 Charater Allow'
                }
            },
            highlight: function (element) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function (element) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            },
            submitHandler: function () {
                $.ajax({
                    type : 'POST',
                    url : '', // The PHP script is in the same file, so no need to specify a URL
                    data : $('#contact-form').serialize(),
                    beforeSend : function(){
                        $('#loader').show();
                        $('#submit').hide();
                    },
                    complete : function(){
                        $('#loader').hide();
                        $('#submit').show();
                    },
                    success : function(response){
                        var get_data = JSON.parse(response);
                        if(get_data.status == 200){
                            $('#contact-form').trigger("reset");
                            $("#name, #subject, #email, #phone, #msg").removeClass("is-valid");
                            $(".success-msg").delay(100).fadeIn("slow", function (){
                                $(this).delay(2000).fadeOut("slow");
                            });
                            console.log(get_data.msg);
                        }
                        else{
                            console.log(get_data.msg);
                        }
                    }
                });
                return false;
            }
        });
    });
    </script>
</body>
</html>

<?php require_once('process.php');

$page = ((empty($_GET['p'])) ? 'step1' : strval($_GET['p']));

if (isset($_SESSION['init']) != true || is_array($_SESSION['init']) != true) {
	$_SESSION['init'] = array();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
	<title>Voice OTP</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Karla">
	<link rel="stylesheet" href="assets/styles.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/css/intlTelInput.css">
    <style>
.hide{
    display:none;
}
#error-msg{
    color :red;
}

    </style>    
</head>

<body style="font-family: Karla, sans-serif;">

<?php if ($page == 'step1'):  ?>
						<?php require_once('assets/content/step1.phtml'); ?>
					<?php elseif($page == 'step2' && isset($_SESSION['init']['status']) && !empty($_SESSION['init']['status'])): ?>
						<?php require_once('assets/content/step2.phtml'); ?>
						<?php else: ?>
						<?php require_once('assets/content/step1.phtml'); ?>
					
					<?php endif; ?>
					
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/intlTelInput-jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script>
    var input = document.querySelector("#phone"),
    errorMsg = document.querySelector("#error-msg"),
    validMsg = document.querySelector("#valid-msg");

    // Error messages based on the code returned from getValidationError
    var errorMap = [ "Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

    // Initialise plugin
    var intl = window.intlTelInput(input, {
        hiddenInput: "tel",
    initialCountry: "auto",
    autoHideDialCode: true, 
    preferredCountries: ['us', 'gb', 'ca', 'ng', 'cn'],
    geoIpLookup: function(success, failure) {
        $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            success(countryCode);
        });
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.15/js/utils.js"
});

    var reset = function() {
        input.classList.remove("error");
    errorMsg.innerHTML = "";
    errorMsg.classList.add("hide");
    validMsg.classList.add("hide");
};

    // Validate on blur event
    input.addEventListener('blur', function() {
        reset();
    if(input.value.trim()){
        if(intl.isValidNumber()){
        validMsg.classList.remove("hide");
        }else{
        input.classList.add("error");
    var errorCode = intl.getValidationError();
    errorMsg.innerHTML = errorMap[errorCode];
    errorMsg.classList.remove("hide");
        }
    }
});

    // Reset on keyup/change event
    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);
</script>
</body>

</html>




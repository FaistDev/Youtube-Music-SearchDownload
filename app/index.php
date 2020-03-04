<!DOCTYPE HTML>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
<form onsubmit="login(event)">
    <input placeholder="Username" type="text" id="username" required/>
    <input placeholder="Passwort" type="password" id="password" required>
    <button type="submit">Login</button>
</form>

</body>
</html>
<script>
    function login(event){
        event.preventDefault();
        //showHideLoading(true);
        const username=document.getElementById("username").value;
        const password=document.getElementById("password").value;
        $.ajax({
            url: "assets/php/login.php",
            datatype: "json",
            data: {username: username, password: password},
            type: "POST",
            success: function (out) {
                //showHideLoading(false);
                console.log("Data: " + out);
                if(out=="success"){
                    window.location.href="search.php";
                }else{
                    alert("Error: "+out);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.error(thrownError);
                //showHideLoading(false);
                //showAjaxErrorMessage(true,thrownError);
            }
        });
    }

</script>
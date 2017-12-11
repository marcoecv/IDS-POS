<!DOCTYPE html>
<html>
<head>
    <script src='/js/jquery-1.11.2.min.js'></script>   
</head>
<body>
    <form id="loginForm" method="POST" action="<?php echo Router::url('/', true); ?>Pages/dologin">
        <input type="hidden" value="<?= $user ?>" name="user"/>
        <input type="hidden" value="<?= $password ?>" name="password"/>
        <input type="submit" value="click" style="display: none"/>
    </form>
    <script>
        $(document).ready(function(){
            $("#loginForm").submit();       
        });
    </script>
</body>
</html>

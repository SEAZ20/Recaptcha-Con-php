<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Autentificacion por formularios</title>
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="css/styles.css">
<script src="https://www.google.com/recaptcha/api.js"></script>
</head>

<body>
<div class="container">
    <h1 align="center">Autentificación por formularios</h1>
    <div class="row">
        <div id="content" class="col-lg-12">
            <?php
            if (isset($_POST['submitForm'])) {
                $captcha_response = true;
                $recaptcha = $_POST['g-recaptcha-response'];

                $url = 'https://www.google.com/recaptcha/api/siteverify';
                $data = array(
                    'secret' => '6LceTl4aAAAAALlT1KjM8adxEl6zL4TDCdR3NGDn',
                    'response' => $recaptcha
                );
                $options = array('http' => array(
                    'method' => "POST",
                    'header' =>
                        "Content-Type: application/x-www-form-urlencoded\r\n",
                        'content' => http_build_query($data)
                ));

                $context  = stream_context_create($options);
                $captcha_success = json_decode(file_get_contents($url, false, $context));
                $captcha_response = $captcha_success->success;
                
                if ($captcha_response) {
                    echo '<p class="alert alert-success">Procesando datos...</p>';
                } else {
                    echo '<p class="alert alert-danger">Debes indicar que no eres un robot.';
                }
            }
            ?>
            <form action="index.php" method="post">
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="g-recaptcha" data-sitekey="6LceTl4aAAAAAE0tub77jiO3WxNnEH6I8r8iOqEp" data-callback="correctCaptcha"></div>
                <input type="submit" name="submitForm" value="Enviar" class="btn btn-primary">
            </form>
        </div>
    </div>
    
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>
<script>
    console.log(<?= json_encode($captcha_success); ?>);
</script>
</body>
</html>

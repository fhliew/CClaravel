<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="styles.css">
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body style="background-color : #12b5331a;">

        <div class="col-sm-12" style="width:100%;height: 70px; position:fixed; top:0; background-color:<?= (!isset($barcolor))? '#12B533':$barcolor?>;z-index:1">
            <div style="font-weight: bold; text-align: center; padding-top: 17px; color: white; font-size: 20px;"> <?= $title;?></div>
            <a href="/" id="exit_request_button"><label id="button_text">&#10005</label></a>
        </div>
        
        <div class="container px-4 py-5" style ="margin-top:80px;z-index:0;">
            <div class="row gy-2" id="content-area">
                @yield('content')
            </div>
        </div>
    </body>
</html>
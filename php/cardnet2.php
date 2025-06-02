<?php

    $datos  = [];
    $datos['nombre'] = "Daniel Espejo Ventura";
    $datos['cargo'] = "Técnico Informático";
    $datos['cedula'] = "001-23456789-0";
    $c = (object)$datos;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnet by Daniel Espejo</title>
    <style>
        .border-carnet {
            background: linear-gradient(to right, #ff3131, #ff914d);
            margin:0;
            width:207.1px;
            height:323.1px;
            border-radius: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .carnet-container {
            background-color: white;
            width:197.1px;
            height:313.1px;
            border-radius: 25px;
            display: flex;
            flex-direction: column;
            align-items: center;
            overflow: hidden;
        }

        .carnet-header {
            width: 190px;
            height:40px;
            background-color: #ff3131;
            margin-top: 10px;
            border-radius: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .photo-frame {
            width: 100px;
            height: 100px;
            background: linear-gradient(to right, #ff3131, #ff914d);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 10px;
        }

        .carnet-photo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
        }

        .cedula-qr {
            width: 70px;
            height: 70px;
            border-radius: 8px;
        }

        .qr-frame {
            width: 85px;
            height: 85px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #ff3131, #ff914d);
            border-radius: 16px;
        }

        h1 {
            font-size: 20px;
            color: white;
        }

        h2 {
            font-size: 18px;
            margin: 0;
            margin-top: 10px;
            color: white;
        }

        p {
            font-size: 14px;
            background-color: #ff3131;
            width: 190px;
            height: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 16px;
            color: white;
        }
    </style>
</head>
<body>
    <div class="border-carnet">
        <div class="carnet-container">
            <div class="carnet-header">
                <h1><b><?=$c->cargo?></b></h1>
            </div>
            <div class="photo-frame">
                <img class="carnet-photo" src="https://preview.redd.it/4utcv426n1la1.jpg?width=640&crop=smart&auto=webp&s=10b15678c008989f38d158430328fe17fd1e6630">
            </div>
            <p class="name-text"><b><?=$c->nombre?></b></p>
            <div class="qr-frame">
                <img class="cedula-qr" src="https://facturan2.com/qr/?qr=<?=$c->cedula?>">
            </div>
        </div>

    </div>
</body>
</html>

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
            background: linear-gradient(to right, #5de0e6, #004aad);
            margin:0;
            width:207.1px;
            height:323.1px;
            border-radius: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .carnet-container {
            background-color: white;
            width:197.1px;
            height:313.1px;
            border-radius: 25px;
            display: flex;
            flex-direction: column;
            align-items: center;

        }

        .carnet-header {
            width: 207.1px;
            height:50px;
            background: linear-gradient(to right, #5de0e6, #004aad);
            align-self: flex-start;
            position: absolute;
            border-radius: 50px;
        }

        .carnet-circle {
            width: 200px;
            height: 200px;
            background: linear-gradient(to right, #5de0e6, #004aad);
            position: absolute;
            align-self: flex-end;
            border-radius: 50%;
            bottom: -75px;
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        .photo-frame {
            width: 100px;
            height: 100px;
            background: linear-gradient(to right, #5de0e6, #004aad);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }

        .carnet-photo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
        }

        .cedula-qr {
            width: 70px;
            height: 70px;
        }

        h1 {
            font-size: 20px;
            text-align: center;
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
        }
    </style>
</head>
<body>
    <div class="border-carnet">
        <div class="carnet-header">
            <h1><b><?=$c->cargo?></b></h1>
        </div>
        <div class="carnet-container">
            <div class="photo-frame">
                <img class="carnet-photo" src="https://preview.redd.it/4utcv426n1la1.jpg?width=640&crop=smart&auto=webp&s=10b15678c008989f38d158430328fe17fd1e6630">
            </div>
            <p class="name-text"><b><?=$c->nombre?></b></p>
        </div>
        <div class="carnet-circle">
            <h2>Cédula</h2>
            <img class="cedula-qr" src="https://facturan2.com/qr/?qr=<?=$c->cedula?>">
        </div>
    </div>
</body>
</html>

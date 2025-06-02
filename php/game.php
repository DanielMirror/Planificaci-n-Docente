<?php
    $array = ['iglesia', 'juego', 'verano', 'pelota', 'calle', 'arena', 'acera'];

    function chooseWord($array) {
        $arraySize = count($array) - 1;
        $random = random_int(0,$arraySize);
        $word = $array[$random];
        return $word; 
    }

    function setSpaces($word) {
        $nSpaces = strlen($word);
        $spaces = str_repeat('<span class="caracter">  _____  </span>',$nSpaces);
        return $spaces;
    }

    function containsCharacter($character) {
        print_r($character);
    }

    $newWord = chooseWord($array);
    $spaces = setSpaces($newWord);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Juego</title>
</head>
<body>
    <form>
    <div class="mb-3">
        <label for="letra" class="form-label">Letra</label>
        <input type="text" name="letra" class="form-control" id="letra" aria-describedby="emailHelp">
        <div id="letraHelp" class="form-text">Coloca la letra a Adivinar</div>
    </div>
    <button id="boton" type="button" class="btn btn-primary">Submit</button>
    </form>
    <div>
        <?php
            echo $spaces;
        ?>
    </div>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }
        form {
            width: 40%;
        }
        span {
            display: ;
        }
    </style>


    <script>
        const CHARACTER = document.getElementById('letra');
        const button = document.getElementById('boton');
        let caracteres = [...document.querySelectorAll('.caracter')];
        const word = '<?php echo $newWord ?>';
        let letrasFaltantes = word.length;

        button.addEventListener('click', () => {
            const letra = CHARACTER.value.toLowerCase();

            for (let i = 0; i < word.length; i++) {
                if (word[i].toLowerCase() === letra && caracteres[i].textContent === '  _____  ') {
                    caracteres[i].textContent = word[i];
                    letrasFaltantes--;
                }
            }

            if (letrasFaltantes === 0) {
                alert('¡Felicidades! Adivinaste la palabra.');
            }

            CHARACTER.value = '';
        });
    </script>
</body>
</html>
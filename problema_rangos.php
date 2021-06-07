<!DOCTYPE html>
<html>
<head>
    <title>Problema de los rangos</title>
</head>
<body>

    <?php   

        /***
         * Los números que aparezcan consecutivos deben de agruparse con el primer número y el último separados por un guión
         * Los números que aparezcan sin ser consecutivos no se deben agrupar
         * Los rangos de números no agrupados y agrupados deben separarse con una coma
         * Los espacios entre el programa son para que puedas analizar el codigo mas comodamente, normalmente
         * solo lo aplico para cuidar la indentación
         */
       
        $numbers = "1 2 3 5 6 8"; // numeros

        $numbers = explode(" ", $numbers); // convertir en array
        
        $numbers = array_filter($numbers, 'ctype_digit'); // eliminar string

        $notConsecutive = -1; // para obtener numeros no consecutivos (fuera del rango)
                                           
        foreach ($numbers as $number) {
            
            if ($consecutive === NULL) { //inciamos la primera iteración y validamos que este vacia para evitar duplicados
                
                $consecutive = $number; // declaramos el inicio (consecutivos)

            } elseif ($number != $notConsecutive + 1) { // obtener no consecutivos en caso de que consecutive ya este declarado                      
                
                $result[] = $consecutive == $notConsecutive ? $notConsecutive : $consecutive."-".$notConsecutive; // guardar rango
                
                $consecutive = $number; // actualizamos numeros consecutivos
            }

            $notConsecutive = $number; // actualizamos numeros no consecutivos
        }

        if (empty($numbers)) $notConsecutive = NULL; // si el array esta vacio, no hay valores fuera de rango
        
        // guardamos los resultados finales (ultima iteración)
        $result[] = $consecutive == $notConsecutive ? $notConsecutive : $consecutive . '-' . $notConsecutive;
        
        echo implode(', ', $result); // convetimos en string y obtenemos resultado separado por ","

    ?>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variable Types</title>
</head>
<body>
    <?php
    $int_var = 12369;
    $another_int = 6 + 9;

    echo $int_var;
    echo "<br>";
    echo $another_int;
    echo "<br>";

    $many = 6.900;
    $many_2 = 6.900;
    $few = $many + $many_2;
    print ("$many + $many_2 = $few<br>");

    if (TRUE)
    print("Pogi si Echo<br>");
    else
    print("Pogi pa rin si Echo<br>");



    /*
    $true_num = 3 + 0.14159;
    $true_str = "Tried and true"
    $true_array[49] = "An array element";
    $false_array = array();
    $false_null = NULL;
    $false_num = 999 - 999;
    $false_str = "";
    */
    
    $my_var = NULL;

    // Evaluates to FALSE in a Boolean context
    if ($my_var) {
        echo "\$my_var is evaluated as true in a Boolean context.<br>";
    } else {
        echo "\$my_var is evaluated as false in a Boolean context.<br>";
    }
    
    $variable = "name";
    $literally = 'My $variable will not print!<br>';
    print($literally);
    $literally = "My $variable will print!<br>";
    print($literally);

    $pogiboii = "Echo";
    $testkapogian = 'Pogi si $pogiboii!<br>';
    print($testkapogian);
    $testkapogian = "Pogi si $pogiboii!<br>";
    print($testkapogian);

    //here document syntax
    $pogiboii = "Echo";
    $pogipercentage = 100;

    $tryHereDox = <<<THD
    Grabe talaga sobrang pogi ni $pogiboii pramis $pogipercentage percent sure nyahahahah<br>

    THD;

    echo $tryHereDox;

    //PHP Local Variables
    $e = 6;
    function assignx () {
    $e = 9;
    print "\$e inside function is $e. 
    ";
    }

    assignx();
    print "\$e outside of function is $e. 
    ";

    echo "<br>";

    // multiply a value by 10 and return it to the caller
    function multiply ($kapogian) {
        $kapogian = $kapogian * 1000;
        return $kapogian;
    }

    $retval = multiply (10);
    Print "Ang kapogian ni echo ay $retval times.<br>";

    // PHP Global variables
    $somevar = 15;
    function addit() {
    GLOBAL $somevar;
    $somevar++;
    print "Somevar is $somevar";
    }
    addit();

    echo "<br>";

    function keep_track() {
        STATIC $kapogian = 1000;
        $kapogian++;
        print $kapogian;
        print "
        ";
    }
    keep_track();
    keep_track();
    keep_track();
       

    ?>





    
</body>
</html>
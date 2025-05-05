<?php
// get post values
$selectedColumn=filter_input(INPUT_POST, "column", FILTER_SANITIZE_NUMBER_INT);
$selectedRow=filter_input(INPUT_POST, "row", FILTER_SANITIZE_NUMBER_INT);
$selectedSymbol=isset($_POST["symbol"]) ? htmlspecialchars($_POST["symbol"]) : null;
$currentState=!empty($_POST["state"]) ? $_POST["state"] : null;

//validating inputs
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors=[];
    if (isset($selectedSymbol, $selectedColumn, $selectedRow)) {
        if (!in_array($selectedSymbol, ["X", "O"])) {
            $errors[]="Invalid symbol";
            $selectedSymbol=null;
        }
        if (!in_array($selectedColumn, [1, 2, 3])) {
            $errors[]="Invalid column";
            $selectedColumn=null;
        }
        if (!in_array($selectedRow, [1, 2, 3])) {
            $errors[]="Invalid row";
            $selectedRow=null;
        }
    } else {$errors[]="Missing input";}
}

// setting current state
if (is_null($currentState)) {
    $grid=[
    [null, null, null,],
    [null, null, null,],
    [null, null, null,]
    ];
} else {
    $grid=json_decode($currentState);
}

$actualRow=$selectedRow-1;
$actualColumn=$selectedColumn-1;

// updating state
if(!is_null($selectedColumn)&&!is_null($selectedRow)&&!is_null($selectedSymbol)) {
    // stop overwriting
    if ($grid[$actualRow][$actualColumn] === null) {
      $grid[$actualRow][$actualColumn]=$selectedSymbol;
    } else {echo "Chosen square is not empty";
    }
    
}

// checking for win
$win=false;
$count=0;
if ($currentState !== null) {
    for ($num=0; $num<=2; $num++) {
        if ($grid[0][$num]=="X" && $grid[1][$num]=="X" && $grid[2][$num]=="X") {
            echo "<h2 class='container' style='color: #ce93d8'>Vertical win for X down column $selectedColumn</h2>";
            $win=true;
        } 
        elseif ($grid[0][$num]=="O" && $grid[1][$num]=="O" && $grid[2][$num]=="O") {
            echo "<h2 class='container' style='color: #f8bbd0'>Vertical win for O down column $selectedColumn</h2>";
            $win=true;
        }
        elseif ($grid[$num][0]=="X" && $grid[$num][1]=="X" && $grid[$num][2]=="X") {
            echo "<h2 class='container' style='color: #ce93d8'>Horizontal win for X on row $selectedRow</h2>";
            $win=true;
        } 
        elseif ($grid[$num][0]=="O" && $grid[$num][1]=="O" && $grid[$num][2]=="O") {
            echo "<h2 class='container' style='color: #f8bbd0'>Horizontal win for O on row $selectedRow</h2>";
            $win=true;
        }
    }
    if ($grid[0][0]=="X" && $grid[1][1]=="X" && $grid[2][2]=="X" || 
            $grid[2][0]=="X" && $grid[1][1]=="X" && $grid[0][2]=="X") {
        echo "<h2 class='container' style='color: #ce93d8'>Diagonal win for X</h2>";
        $win=true;
    }
    elseif ($grid[0][0]=="O" && $grid[1][1]=="O" && $grid[2][2]=="O" || 
            $grid[2][0]=="O" && $grid[1][1]=="O" && $grid[0][2]=="O") {
        echo "<h2 class='container' style='color: #f8bbd0'>Diagonal win for O</h2>";
        $win=true;
    }
    // counting available slots in grid
    $availableCol=[];
    $availableRow=[];
    for ($x=0; $x<=2; $x++) {
        for ($y=0; $y<=2; $y++) {
            if (in_array($grid[$y][$x], ["X", "O"])) {
                $count++;
            }
        }
    }
}

// changing options for selection to available slots only
$availableCol=[];
$availableRow=[];
for ($x=0; $x<=2; $x++) {
    for ($y=0; $y<=2; $y++) {
        if (is_null($grid[$y][$x])) {
            $availableCol[]=$x+1;
            $availableRow[]=$y+1;
        }
    }
}

$availableCol=array_unique($availableCol);
sort($availableCol);
$availableRow=array_unique($availableRow);
sort($availableRow);
?>

<!DOCTYPE html>
<head>
    <style>
    .container {
        display: flex;
        margin-top: 10%;
        flex-flow: row wrap;
        justify-content: space-evenly;
        align-items: center;
    }
    table {
        font-family: tahoma;
    }
    tr, td {
        color: #fff8e2;
        border: 1px solid #fff8e2;
        border-radius: 10px;
        padding: 2px;
        font-size: 40px;
        width: 60px;
        height: 60px;
    }
    .sub {
        background-color: #4db6ac;
        color: white;
        cursor: pointer;
        font-size: 120%;
        border-radius: 30%;
        border: 1px solid #fff8e2;
        transition-duration: 0.4s;
        margin-top: 10%;
        padding: 6px;
    }
    .sub:hover {
        background-color: #00838f;
    }
    input[type=radio] {
        cursor: pointer;
    }
    select {
        cursor: pointer;
    }
    </style>
</head>
    <body style="background-color: #fff8e2">
        <div class="container">
            <?php
            // reset button on win or draw
            if($win==true || $count>=8) {
                echo '<button onclick="location.reload(true)" class="sub">Reset</button><br>'; }
            ?>
        <form method="post">
            <label style="font-size: 150%" for="column">Column:</label>
            <select id="column" name="column" style="font-size: 150%" >
                <?php
                    foreach ($availableCol as $value) {
                        echo "<option>$value</option>";
                }
                ?>
            </select><br>

            <label style="font-size: 150%" for="row">Row:</label>
            <select id="row" name="row" style="font-size: 150%">
                <?php
                    foreach ($availableRow as $value) {
                        echo "<option>$value</option>";
                    }
                ?>
            </select><br>

            <input type="radio" id="x" name="symbol" value="X">
            <label style="font-size: 150%" for="x">X</label><br>

            <input type="radio" id="o" name="symbol" value="O">
            <label style="font-size: 150%" for="o">O</label><br>

            <input type="submit" class="sub" value="Play" />

            <input type="hidden" name="state" 
                value="<?php echo htmlspecialchars(json_encode($grid)) ?>"/><br>
            
        </form>
        <table  style="table-layout:fixed; text-align: center; bg-color: #2f923a">

        <?php
        // table setup and colour change on input
         foreach ($grid as $rowIndex => $row) {
            echo "<tr>";
            foreach ($row as $columnIndex => $column) {
                switch ($column) {
                    case "O":
                        $colour="#f8bbd0";
                        break;
                    case "X":
                        $colour="#ce93d8";
                        break;
                    default:
                        $colour="#4db6ac";
                }
                printf(
                    "<td bgcolor='%s'>%s</td>",
                    $colour,
                    $column
                );
            }
            echo "</tr>";
         }
         // outputting error statements
        if (!empty($errors)) {
            echo implode(", ", $errors);
        }
        ?>
        </table>
        </div>
    </body>
</html>
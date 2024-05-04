<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <link rel="stylesheet" href="calculadoraa.css">
</head>

<body>
    <section>

        <?php
        session_start();


        if (isset($_POST['limpar_historico'])) {

            $_SESSION['historico'] = array();
        }

        $num1 = isset($_POST["num1"]) ? $_POST["num1"] : '';
        $num2 = isset($_POST["num2"]) ? $_POST["num2"] : '';
        $operador = isset($_POST["operador"]) ? $_POST["operador"] : '+';
        $calcular = isset($_POST["calcular"]) ? $_POST["calcular"] : "";
        $resultado = '';
        $historico = isset($_SESSION['historico']) ? $_SESSION['historico'] : array();
        $memoria = isset($_SESSION['memoria']) ? $_SESSION['memoria'] : array();
        $resultado2 = '';

        function fatoracao($num1)
        {
            $fatores = array();

            for ($i = 2; $i <= $num1; $i++) {
                while ($num1 % $i == 0) {
                    $fatores[] = $i;
                    $num1 /= $i;
                }
            }

            return $fatores;
        }

        if (isset($_POST['salvar_memoria'])) {

            $_SESSION['memoria'] = array(
                'num1' => $num1,
                'num2' => $num2,
                'operador' => $operador
            );
        }

        if (isset($_POST['recuperar_memoria'])) {

            $num1 = isset($memoria['num1']) ? $memoria['num1'] : '';
            $num2 = isset($memoria['num2']) ? $memoria['num2'] : '';
            $operador = isset($memoria['operador']) ? $memoria['operador'] : $operador;
        }

        if ($calcular == "sim") {

            switch ($operador) {
                case '+':
                    $resultado = $num1 + $num2;
                    break;

                case '-':
                    $resultado = $num1 - $num2;
                    break;

                case '/':
                    $resultado = $num1 / $num2;
                    break;

                case '*':
                    $resultado = $num1 * $num2;
                    break;

                case '^':
                    $resultado = pow($num1, $num2);
                    break;

                case '!':
                    $resultado2 = fatoracao($num1);
                    $resultado = implode(" * ", $resultado2);
                    break;

                default:
                    $resultado = "Operador inválido";
                    break;
            }

            $historico[] = array(
                'num1' => $num1,
                'num2' => $num2,
                'operador' => $operador,
                'resultado' => $resultado
            );

            $_SESSION['historico'] = $historico;
        }
        ?>

        <div class="divisaoTotal">
            <div class="divisao1">
                <form action="" method="post">
                    <label for="num1"></label>
                    <input type="number" name="num1" class="num1" placeholder="<?= $num1 ?>">

                    <select name="operador" class="operador">
                        <option value="+" <?= $operador == '+' ? 'selected' : '' ?>>+</option>
                        <option value="-" <?= $operador == '-' ? 'selected' : '' ?>>-</option>
                        <option value="/" <?= $operador == '/' ? 'selected' : '' ?>>/</option>
                        <option value="*" <?= $operador == '*' ? 'selected' : '' ?>>*</option>
                        <option value="^" <?= $operador == '^' ? 'selected' : '' ?>>^</option>
                        <option value="!" <?= $operador == '!' ? 'selected' : '' ?>>!</option>
                    </select>

                    <label for="num2"></label>
                    <input type="number" name="num2" class="num2" placeholder="<?= $num2 ?>">

                    <br>

                    <label for="resultado"></label>
                    <input type="text" name="resultado" class="resultado" placeholder="<?= $resultado ?>">

                    <br>

                    <button type="submit" name="calcular" value="sim">Calcular</button>
                    <button type="submit" name="limpar_historico">Limpar Histórico</button>
                    <button type="submit" name="salvar_memoria">M (Salvar)</button>
                    <button type="submit" name="recuperar_memoria">M (Recuperar)</button>
                </form>
            </div>

            <div class="divisao2">
                <ul>
                    <?php foreach ($historico as $op) : ?>
                        <li><?= $op['num1'] . $op['operador'] . $op['num2'] . '=' . $op['resultado'] ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>
</body>

</html>
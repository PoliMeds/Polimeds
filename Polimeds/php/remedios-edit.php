<?php
    include 'autentication.php';
    autentication();

    $erro = $barragem = 0;
    $user_email = $_SESSION["user_email"];
    $conn = OpenCon();

    if (!empty($_POST["dia-semana-input"])) {
        $dia_semana = $_POST["dia-semana-input"];
    } else {
        $erro =1;
    }

    if (!empty($_POST["remedio-input"])) {
        $remedio = $_POST["remedio-input"];
    } else {
        $erro =1;
    }

    if (!empty($_POST["quantidade-input"])) {
        $quantidade = $_POST["quantidade-input"];
    } else {
        $erro =1;
    }

    if (!empty($_POST["horario-input"])) {
        $horario = $_POST["horario-input"];
    } else {
        $erro =1;
    }

    if (!empty($_POST["slot-input"])) {
        $slot = $_POST["slot-input"];
    } else {
        $erro =1;
    }
    
    if ($erro == 0) {
        $barragem = 1;
        if(array_key_exists('adicionar-remedio', $_POST)) {
            $sql = 'INSERT INTO remedio_do_dia (cliente, dia, remedio, quantidade, horario, compartimento) VALUES ("'.$user_email.'", "'.$dia_semana.'", "'.$remedio.'", '.$quantidade.', "'.$horario.'", '.$slot.');';
            $conn->query($sql);
            unset($_POST);
        }
    }

    $sql = "SELECT id FROM remedio_do_dia WHERE cliente='".$user_email."';";
    $result = $conn->query($sql);


    error_reporting(E_ALL ^ E_WARNING);
    if ($barragem == 0) {
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $delete='delete'.$row["id"].'';

                if (!is_null($_POST)){
                    
                    if(array_key_exists($delete, $_POST)) {
                        $sql = 'DELETE FROM remedio_do_dia WHERE id='.$id.';';
                        $conn->query($sql);
                        unset($_POST);
                    }
                }
                

            }
        }
    }







    $erro = $barragem = 0;
    

    if (!empty($_POST["remedio-estoque"])) {
        $remedio_estoque = $_POST["remedio-estoque"];
    } else {
        $erro =1;
    }

    if (!empty($_POST["quantidade-estoque"])) {
        $quantidade_estoque = $_POST["quantidade-estoque"];
    } else {
        $erro =1;
    }

    if (!empty($_POST["vencimento-estoque"])) {
        $vencimento_estoque = $_POST["vencimento-estoque"];
    } else {
        $erro =1;
    }
    
    if ($erro == 0) {
        $barragem = 1;
        if(array_key_exists('adicionar-estoque', $_POST)) {
            $sql = 'INSERT INTO estoque (cliente, remedio, quantidade, vencimento) VALUES ("'.$user_email.'", "'.$remedio_estoque.'", '.$quantidade_estoque.', "'.$vencimento_estoque.'");';
            $conn->query($sql);
            unset($_POST);
        }
    }

    $sql = "SELECT id FROM estoque WHERE cliente='".$user_email."';";
    $result = $conn->query($sql);

    if ($barragem == 0) {
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $delete='delete-estoque'.$row["id"].'';

                if (!is_null($_POST)){
                    
                    if(array_key_exists($delete, $_POST)) {
                        $sql = 'DELETE FROM estoque WHERE id='.$id.';';
                        $conn->query($sql);
                        unset($_POST);
                    }
                }
                

            }
        }
    }



    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>


<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <title>PoliMeds - Remedios Edit</title>
        <link rel="icon" type="imagem/png" href="../imagens/pill.png" />
        <link rel="stylesheet" href="../css/index.css"> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Polimeds Product First Page">
        <meta name="keywords" content="Controle, Consumo, Remedios, Medicamentos, Inteligente">
        <meta name="author" content="Um Idiota Qualquer">
        <script src="../javascript/script.js"></script>
        <script>
            function end_session() {
                alert("Sessão encerrada");
                go_to_page('../index.html');
            }
        </script>
    </head>

    <body>

        <header>
            <button class="botoes-header" id="menu" onclick="open_close_sidebar()" type="button">\\\</button>
            <h3 id="texto-titulo">Polimeds - Edição de dados</h3>
            <button class="botoes-header prosseguir" id="sair" onclick="end_session()" type="button">Sair</button>
            <button class="botoes-header prosseguir" id="home" onclick="go_to_page('../index.html')" type="button">Home</button>
        </header>
        
        <div id="main">
            <aside id="sidebar">
                <div id="sidebar-content">
                    <h2 class="lista-titulo">Consultas</h2>
                    <ul class="lista">
                        <li><a href="consumo.php">Consumo</a></li>
                        <li><a href="estoque.php">Estoque</a></li>
                    </ul>

                    <h2 class="lista-titulo">Nossas páginas</h2>
                    <ul class="lista">
                        <li><a href="../index.html">Home</a></li>
                        <li><a href="../htmls/buy.html">Comprar</a></li>
                        <li><a href="https://theuselessweb.com/" target="_blank">Não me aperte</a></li>
                    </ul>
                </div>
            </aside>
            
            <div id="edit-content">

                <form id="remedios-edit" class="cadastro" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="on">  
                    <fieldset class="get-dados-conteiner">
                        <legend class="form-titulo"> Edição de Remedios: </legend>

                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                            <?php
                                $sql = "SELECT remedio, quantidade, horario, compartimento, dia, id FROM remedio_do_dia WHERE cliente='".$user_email."';";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo "<table><tr><th>Remedio</th><th>Quantidade</th><th>Horario</th><th>Compartimento</th><th>Dia</th></tr>";
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row["remedio"]. "</td><td>" . $row["quantidade"]. "</td><td>" . $row["horario"]. "</td><td>" . $row["compartimento"]. "</td><td>" . $row["dia"]. "</td><td><button type='submit' name='delete".$row["id"]."'>
                                        <img id='trash' src='../imagens/trash.png' alt='excluir remedio'></button></td></tr>";
                                    }
                                    echo '<tr><td> <input type="text" id="remedio-input" name="remedio-input"> </td> <td> <input type="number" id="quantidade-input" name="quantidade-input" min="1"> </td> <td> <input type="time" id="horario-input" name="horario-input"> </td> <td> <input type="number" id="slot-input" name="slot-input" min="1"> </td> <td> <select id="dia-semana-input" name="dia-semana-input">
                                    <option value="domingo">Domingo</option>
                                    <option value="segunda">Segunda</option>
                                    <option value="terca">Terça</option>
                                    <option value="quarta">Quarta</option>
                                    <option value="quinta">Quinta</option>
                                    <option value="sexta">Sexta</option>
                                    <option value="sabado">Sabado</option>
                                  </select> </td>  <td><button type="submit" name="adicionar-remedio" ><img id="certo" src="../imagens/confirmar.png" alt="enviar dados"></button></td> </tr>';
                                    echo "</table>";

                                } else {
                                    echo "<table><tr><th>Remedio</th><th>Quantidade</th><th>Horario</th><th>Compartimento</th><th>Dia</th></tr>";
                                    echo '<tr><td> <input type="text" id="remedio-input" name="remedio-input"> </td> <td> <input type="number" id="quantidade-input" name="quantidade-input" min="1"> </td> <td> <input type="time" id="horario-input" name="horario-input"> </td> <td> <input type="number" id="slot-input" name="slot-input" min="1"> </td> <td> <select id="dia-semana-input" name="dia-semana-input">
                                    <option value="domingo">Domingo</option>
                                    <option value="segunda">Segunda</option>
                                    <option value="terca">Terça</option>
                                    <option value="quarta">Quarta</option>
                                    <option value="quinta">Quinta</option>
                                    <option value="sexta">Sexta</option>
                                    <option value="sabado">Sabado</option>
                                  </select> </td>  <td><button type="submit" name="adicionar-remedio" ><img id="certo" src="../imagens/confirmar.png" alt="enviar dados"></button></td> </tr>';
                                    echo "</table>";
                                }
                            ?>
                        </form>

                        

                    </fieldset>
                </form>


                <form id="estoque-edit" class="cadastro" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="on">  
                    <fieldset class="get-dados-conteiner">
                        <legend class="form-titulo"> Edição do estoque: </legend>
                        
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                            <?php
                                $sql = "SELECT cliente, remedio, quantidade, vencimento, id FROM estoque WHERE cliente='".$user_email."';";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    echo "<table><tr><th>Remedio</th><th>Quantidade</th><th>Vencimento</th></tr>";
                                    // output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr><td>" . $row["remedio"]. "</td><td>" . $row["quantidade"]. "</td><td>" . $row["vencimento"]. "</td><td><button type='submit' name='delete-estoque".$row["id"]."'>
                                        <img id='trash' src='../imagens/trash.png' alt='excluir estoque'></button></td></tr>";
                                    }
                                    echo '<tr><td> <input type="text" id="remedio-estoque" name="remedio-estoque"> </td> <td> <input type="number" id="quantidade-estoque" name="quantidade-estoque" min="1"> </td> <td> <input type="date" id="vencimento-estoque" name="vencimento-estoque"> </td>
                                    <td><button type="submit" name="adicionar-estoque" ><img id="certo" src="../imagens/confirmar.png" alt="enviar dados"></button></td> </tr>';
                                    echo "</table>";

                                } else {
                                    echo "<table><tr><th>Remedio</th><th>Quantidade</th><th>Vencimento</th></tr>";
                                    echo '<tr><td> <input type="text" id="remedio-estoque" name="remedio-estoque"> </td> <td> <input type="number" id="quantidade-estoque" name="quantidade-estoque" min="1"> </td> <td> <input type="date" id="vencimento-estoque" name="vencimento-estoque"> </td>
                                    <td><button type="submit" name="adicionar-estoque" ><img id="certo" src="../imagens/confirmar.png" alt="enviar dados"></button></td> </tr>';
                                    echo "</table>";
                                }
                            ?>
                        </form>
    
                    </fieldset>
                </form>

            </div>
        </div>

        <footer>
            <section id="contato">
                <h2>Contato</h2>
                <ul>
                    <li>Email: polimeds@gmail.com</li>
                    <li>Telefone: (11) 91234-5678</li>
                    <li>Instagram: @polimeds</li>
                </ul>
            </section>
            <div id="aqui-em-baixo">
                <p>alguma outra coisa que venha a aparecer</p>
            </div>
        </footer>
    </body>
</html>
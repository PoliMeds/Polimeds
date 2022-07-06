<?php
    include 'autentication.php';
    autentication();

    $user_email = $_SESSION["user_email"];
    $conn = OpenCon();


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
        <title>PoliMeds - Consulta</title>
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
            <h3 id="texto-titulo">Polimeds - Consulta Consumo</h3>
            <button class="botoes-header prosseguir" id="sair" onclick="end_session()" type="button">Sair</button>
            <button class="botoes-header prosseguir" id="home" onclick="go_to_page('../index.html')" type="button">Home</button>
        </header>
        
        <div id="main">
            <aside id="sidebar">
                <div id="sidebar-content">
                    <h2 class="lista-titulo">Consultas</h2>
                    <ul class="lista">
                        <li><a href="estoque.php">Estoque</a></li>
                        <li><a href="remedios-edit.php">Editar</a></li>
                    </ul>

                    <h2 class="lista-titulo">Nossas páginas</h2>
                    <ul class="lista">
                        <li><a href="../index.html">Home</a></li>
                        <li><a href="../htmls/buy.html">Comprar</a></li>
                        <li><a href="https://theuselessweb.com/" target="_blank">Não me aperte</a></li>
                    </ul>
                </div>
            </aside>
            
            <div id="content">
                <h2 class="consumo-titulo" >Programação de Consumo - Caixinha <?php
                    $sql = "SELECT nome FROM caixinha WHERE dono='".$user_email."';";
                    echo $conn->query($sql)->fetch_assoc()['nome'];
                 ?></h2>
                <div id="remedios-dia">
                    <div class="dia-semana">
                        <h3>Domingo</h3>
                        <?php
                            $sql = "SELECT remedio, quantidade, horario, compartimento FROM remedio_do_dia WHERE cliente='".$user_email."' AND dia='domingo';";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<table><tr><th>Remedio</th><th>Quantidade</th><th>Horario</th><th>Compartimento</th></tr>";
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr><td>" . $row["remedio"]. "</td><td>" . $row["quantidade"]. "</td><td>" . $row["horario"]. "</td><td>" . $row["compartimento"]. "</td></tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "* Sem remedios para esse dia";
                            }
                        ?>
                    </div>
                    
                    <div class="dia-semana">
                        <h3>Segunda</h3>
                        <?php
                            $sql = "SELECT remedio, quantidade, horario, compartimento FROM remedio_do_dia WHERE cliente='".$user_email."' AND dia='segunda';";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<table><tr><th>Remedio</th><th>Quantidade</th><th>Horario</th><th>Compartimento</th></tr>";
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr><td>" . $row["remedio"]. "</td><td>" . $row["quantidade"]. "</td><td>" . $row["horario"]. "</td><td>" . $row["compartimento"]. "</td></tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "* Sem remedios para esse dia";
                            }
                        ?>
                    </div>

                    <div class="dia-semana">
                        <h3>Terça</h3>
                        <?php
                            $sql = "SELECT remedio, quantidade, horario, compartimento FROM remedio_do_dia WHERE cliente='".$user_email."' AND dia='terca';";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<table><tr><th>Remedio</th><th>Quantidade</th><th>Horario</th><th>Compartimento</th></tr>";
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr><td>" . $row["remedio"]. "</td><td>" . $row["quantidade"]. "</td><td>" . $row["horario"]. "</td><td>" . $row["compartimento"]. "</td></tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "* Sem remedios para esse dia";
                            }
                        ?>
                    </div>

                    <div class="dia-semana">
                        <h3>Quarta</h3>
                        <?php
                            $sql = "SELECT remedio, quantidade, horario, compartimento FROM remedio_do_dia WHERE cliente='".$user_email."' AND dia='quarta';";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<table><tr><th>Remedio</th><th>Quantidade</th><th>Horario</th><th>Compartimento</th></tr>";
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr><td>" . $row["remedio"]. "</td><td>" . $row["quantidade"]. "</td><td>" . $row["horario"]. "</td><td>" . $row["compartimento"]. "</td></tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "* Sem remedios para esse dia";
                            }
                        ?>
                    </div>
                    
                    <div class="dia-semana">
                        <h3>Quinta</h3>
                        <?php
                            $sql = "SELECT remedio, quantidade, horario, compartimento FROM remedio_do_dia WHERE cliente='".$user_email."' AND dia='quinta';";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<table><tr><th>Remedio</th><th>Quantidade</th><th>Horario</th><th>Compartimento</th></tr>";
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr><td>" . $row["remedio"]. "</td><td>" . $row["quantidade"]. "</td><td>" . $row["horario"]. "</td><td>" . $row["compartimento"]. "</td></tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "* Sem remedios para esse dia";
                            }
                        ?>
                    </div>

                    <div class="dia-semana">
                        <h3>Sexta</h3>
                        <?php
                            $sql = "SELECT remedio, quantidade, horario, compartimento FROM remedio_do_dia WHERE cliente='".$user_email."' AND dia='sexta';";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<table><tr><th>Remedio</th><th>Quantidade</th><th>Horario</th><th>Compartimento</th></tr>";
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr><td>" . $row["remedio"]. "</td><td>" . $row["quantidade"]. "</td><td>" . $row["horario"]. "</td><td>" . $row["compartimento"]. "</td></tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "* Sem remedios para esse dia";
                            }
                        ?>
                    </div>

                    <div class="dia-semana">
                        <h3>Sábado</h3>
                        <?php
                            $sql = "SELECT remedio, quantidade, horario, compartimento FROM remedio_do_dia WHERE cliente='".$user_email."' AND dia='sabado';";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                echo "<table><tr><th>Remedio</th><th>Quantidade</th><th>Horario</th><th>Compartimento</th></tr>";
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr><td>" . $row["remedio"]. "</td><td>" . $row["quantidade"]. "</td><td>" . $row["horario"]. "</td><td>" . $row["compartimento"]. "</td></tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "* Sem remedios para esse dia";
                            }
                        ?>
                    </div>

                </div>

                <h2 class="consumo-titulo" >Historico de Consumo</h2>
                <div id="historico">
                    <?php
                        $sql = "SELECT remedio, data_hora FROM historico WHERE cliente='".$user_email."' ORDER BY data_hora DESC;";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<table><tr><th>Remedio</th><th>Data e Hora</th></tr>";
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "<tr><td>" . $row["remedio"]. "</td><td>" . $row["data_hora"]. "</td></tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "* Sem histórico disponível";
                        }
                    ?>
                </div>
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
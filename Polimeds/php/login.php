<?php
    // define variables and set to empty values
    $senha = $email = $validation = ""; 
    $emailErr = $senhaErr = "";
    $hasErr = 0;
    $primaryKeyComparisom = $senhaComparisom = "";

    // test if input was recived and if is valid
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (empty($_POST["senha"])) {
            $senhaErr = "* Senha is required";
            $hasErr = 1;
        } else {
            $senha = test_input($_POST["senha"]);
        }
        
        if (empty($_POST["email"])) {
            $emailErr = "* Email is required";
            $hasErr = 1;
        } else {
            $email = test_input($_POST["email"]);
            
            //check if e-mail is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "* Invalid email format";
                $hasErr = 1;
            }
        }

        /* Connection to the database */
        if (!$hasErr) {
            
            include 'db_connnection.php';
            $conn = OpenCon();

            $sql = "SELECT email FROM cliente WHERE email='".$email."';";
            $primaryKeyComparisom = $conn->query($sql);
        
            if ($primaryKeyComparisom->num_rows == 0) {
                // Email não cadastrado
                if ($email == ""){
                
                } else {
                $emailErr = "* Email não cadastrado";
                $conn->close();
                }
            } else {
                $sql = "SELECT senha FROM cliente WHERE email='".$email."';";
                $senhaComparisom = $conn->query($sql)->fetch_assoc()['senha'];


                
                
                if ($senha == "") {

                } elseif ($senha != $senhaComparisom) {
                    $senhaErr = "* Senha incorreta";
                    $conn->close();
                } elseif ($senha == $senhaComparisom) {
                    session_start();
                    $_SESSION["user_email"] = $email;
                    $_SESSION["user_senha"] = $senha;

                    header("Location: consumo.php");
                    $conn->close();
                    exit();
                } else {
                    header("Location: ../htmls/error.html");
                    $conn->close();
                    exit();
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
        <title>PoliMeds - Login</title>
        <link rel="icon" type="imagem/png" href="../imagens/pill.png" />
        <link rel="stylesheet" href="../css/index.css"> 
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Polimeds Product First Page">
        <meta name="keywords" content="Controle, Consumo, Remedios, Medicamentos, Inteligente">
        <meta name="author" content="Um Idiota Qualquer">
        <script src="../javascript/script.js"></script>
    </head>

    <body>

        <header>
            <button class="botoes-header" id="menu" onclick="open_close_sidebar()" type="button">\\\</button>
            <h3 id="texto-titulo">Polimeds - Area de Login</h3>
            <button class="botoes-header prosseguir" id="home" onclick="go_to_page('../index.html')" type="button">Home</button>
        </header>
        
        <div id="main">
            <aside id="sidebar">
                <div id="sidebar-content">
                    <h2 class="lista-titulo">Nossas páginas</h2>
                    <ul class="lista">
                        <li><a href="../index.html">Home</a></li>
                        <li><a href="../htmls/buy.html">Comprar</a></li>
                        <li><a href="https://theuselessweb.com/" target="_blank">Não me aperte</a></li>
                    </ul>
                </div>
            </aside>
            
            <div id="content">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="on">  
                    <fieldset id="login">
                        <legend> Login: </legend>

                        <label for="email">Email: </label><br>
                        <input type="email" id="email" name="email" placeholder="" value="<?php echo $email ?>" autofocus><br>
                        <span class="error"> <?php echo $emailErr;?> </span> <br><br>

                        <label for="senha">Senha:</label><br>
                        <input type="password" id="senha" name="senha"><br>
                        <span class="error"> <?php echo $senhaErr;?> </span> <br><br>

                        <button class="enviar-button" type="submit" >Entrar</button>
    
                        <button class="change-pagebutton" type="button" onclick="go_to_page('cadastro.php')">Primeiro acesso?</button>
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
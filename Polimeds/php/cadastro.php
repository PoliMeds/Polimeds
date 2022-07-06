<?php

    // define variables and set to empty values
    $senha = $email = $nome = $ddd = $telefone = $caixinhaID = $caixinhaName = $totalSlots = "";
    $senhaErr = $emailErr = $nomeErr = $dddErr = $telefoneErr = $caixinhaIDErr = $caixinhaNameErr = $totalSlotsErr = "";
    $primaryKeyComparisom = "";
    $hasErr = 0;


    // test if input was recived and if is valid
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (empty($_POST["senha"])) {
            $senhaErr = "* Senha is required";
            $hasErr = 1;
        } else {
            $senha = test_input($_POST["senha"]);
        }
        
        if (empty($_POST["nome"])) {
            $nomeErr = "* Name is required";
            $hasErr = 1;
        } else {
            $nome = test_input($_POST["nome"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
                $nomeErr = "* Only letters and white space allowed";
                $hasErr = 1;
            }
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
        
        if (empty($_POST["ddd"])) {
            $dddErr = "* DDD is required";
            $hasErr = 1;
        } else {
            $ddd = test_input($_POST["ddd"]);
        }

        if (empty($_POST["telefone"])) {
            $telefoneErr = "* Telefone is required";
            $hasErr = 1;
        } else {
            $telefone = test_input($_POST["telefone"]);
        }

        if (empty($_POST["caixinha-id"])) {
            $caixinhaIDErr = "* Caixinha ID is required";
            $hasErr = 1;
        } else {
            $caixinhaID = test_input($_POST["caixinha-id"]);
        }

        if (empty($_POST["caixinha-name"])) {
            $caixinhaNameErr = "* Caixinha name is required";
            $hasErr = 1;
        } else {
            $caixinhaName = test_input($_POST["caixinha-name"]);
            
            if (!preg_match("/^[a-zA-Z-' ]*$/",$caixinhaName)) {
                $caixinhaNameErr = "* Only letters and white space allowed";
                $hasErr = 1;
            }
        }

        if (empty($_POST["total-slots"])) {
            $totalSlotsErr = "* Total slots is required";
            $hasErr = 1;
        } else {
            $totalSlots = test_input($_POST["total-slots"]);
        }



        if (!$hasErr) {
                
            /* Connection to the database */
            include 'db_connnection.php';
            $conn = OpenCon();
            
            $sql = "SELECT email FROM cliente WHERE email='".$email."'";
            $primaryKeyComparisom = $conn->query($sql);
            
            if ($primaryKeyComparisom->num_rows > 0) {
                // Email alredy used
                if ($email == ""){
                    
                } else {
                    $emailErr = "* Email já cadastrado";
                    $conn->close();
                }

            } else {
                $sql = "SELECT id FROM caixinha WHERE id='".$caixinhaID."'";
                $primaryKeyComparisom = $conn->query($sql);

                if ($primaryKeyComparisom->num_rows > 0) {
                    $caixinhaIDErr = "* Caixinha já cadastrada";
                    $conn->close();

                } else {
                    $sql = 'INSERT INTO cliente (email, senha, nome, ddd, telefone) VALUES ("'.$email.'", "'.$senha.'", "'.$nome.'", '.intval($ddd).', '.intval($telefone).');';
                    $sql .= 'INSERT INTO caixinha (id, nome, total_slots, dono) VALUES ('.intval($caixinhaID).', "'.$caixinhaName.'", '.intval($totalSlots).', "'.$email.'");';
                    
                    if ($conn->multi_query($sql) === TRUE) {
                        header("Location: login.php");
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
        <title>PoliMeds - Cadastro</title>
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
            <h3 id="texto-titulo">Polimeds - Area de Cadastro</h3>
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
                <form class="cadastro" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="on">  
                    <fieldset class="get-dados-conteiner">
                        <legend class="form-titulo"> Cadastro: </legend>
                        
                        <fieldset class="get-dados">
                            <legend>Dados Pessoais:</legend>

                            <label for="nome">Nome:</label><br>
                            <input type="text" id="name" name="nome" value="<?php echo $nome ?>" require autofocus><br>
                            <span class="error"><?php echo $nomeErr;?></span>
                            <span class="info" title="Seu nome completo">&#65533;</span><br><br>

                            <label for="ddd">DDD:</label><br>
                            <input type="text" id="ddd" name="ddd" value="<?php echo $ddd?>" placeholder="11" pattern="[0-9]{2}" require><br>
                            <span class="error"><?php echo $dddErr?></span>
                            <span class="info" title="DDD do seu telefone. Ex: 11">&#65533; </span><br><br>

                            <label for="telefone">Nº Telefone celular:</label><br>
                            <input type="tel" id="telefone" name="telefone" value="<?php echo $telefone?>" placeholder="912345678" pattern="[0-9]{9}" require><br>
                            <span class="error"><?php echo $telefoneErr?></span>
                            <span class="info" title="Seu numero de telefone celular (sem traço). Ex: 912345678">&#65533; </span><br><br>
                              
                        </fieldset>

                        <fieldset class="get-dados">  
                            <legend> Dados da sua caixinha: </legend>

                            <label for="caixinha-id">Caixinha ID:</label><br>
                            <input type="text" id="caixinha-id" name="caixinha-id" value="<?php echo $caixinhaID?>" placeholder="12345" pattern="[0-9]{5}" require><br>
                            <span class="error"><?php echo $caixinhaIDErr?></span>
                            <span class="info" title="Identificação de sua caixinha. São cinco números que podem ser encontrados na sua caixinha">&#65533; </span><br><br>

                            <label for="caixinha-name">Nome personalizado:</label><br>
                            <input type="text" id="caixinha-name" name="caixinha-name" value="<?php echo $caixinhaName?>" placeholder="Meu Precioso"><br>
                            <span class="error"> <?php echo $caixinhaNameErr?></span>
                            <span class="info" title="Nome personalizado para nos referirmos a sua caixinha. Só pode conter letras e espaços">&#65533; </span><br><br>

                            <label for="total-slots">Total de Slots: </label><br>
                            <input type="number" id="total-slots" name="total-slots" value="<?php echo $totalSlots?>" placeholder="7" min="0" require><br>
                            <span class="error"><?php echo $totalSlotsErr?></span>
                            <span class="info" title="Total de compartimentos da sua caixinha">&#65533; </span><br><br>

                        </fieldset>

                        <fieldset class="get-dados">
                            <legend> Ferramenta de Login: </legend>

                            <label for="email">Email: </label><br>
                            <input type="email" id="email" name="email" placeholder="my_email@mail.com" value="<?php echo $email ?>"><br>
                            <span class="error"><?php echo $emailErr;?></span>
                            <span class="info" title="Seu email. Ex: meu_email@mail.com">&#65533;</span> <br><br>
    
                            <label for="senha">Senha:</label><br>
                            <input type="password" id="senha" name="senha"><br>
                            <span class="error"> <?php echo $senhaErr;?></span>
                            <span class="info" title="Senha para login. Não deve conter barras '&#47;', barras invertidas '&#92;' ou espaços (serão automaticamente apagados)">&#65533; </span> <br><br>

                        </fieldset>

                        <div class="submit-buttons"> 
                            <button class="enviar-button" type="submit" >Enviar</button>
                            <span class="empty-space"></span>
                            <button class="change-pagebutton" type="button" onclick="go_to_page('login.php')">Já possui cadastro?</button>
                        </div>
    
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
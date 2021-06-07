<!DOCTYPE html>
<html>
<head>
    <title>Problema de POO</title>
    <link rel="stylesheet" href="css/mail.css">
</head>
<body>

<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';


    /*** Class Mail
     * Metodos sendWelcomeEmail() - sendUnsubscribeEmail - sendRecoveryPasswordMail() 
     * -> Crean el mensaje para ser enviado por sendEmail();
     * Propieades para rellenar el mensaje
     * $mail;
     * $to;
     * $from;
     * $body;
     * $subjet;
     * **/
    class mail {
        /*** Indica si la conexión con el servidor de correo requiere autenticación
        * @var <boolean>*/
        private $authentication = true;
        /*** Indica el host donde se realizará la conexión con el servidor de correo
        * @var <string>*/
        private $host = '192.168.1.33';
        /*** Indica el usuario que se empleará en la autenticación con el servidor de correo
        * @var <string>*/
        private $user = 'usuario';
        /*** Indica el password que se empleará en la autenticación con el servidor de correo
        * @var <string>*/
        private $password = 'pAss12345';

        /** Mail values */
        public $mail;
        private $to;
        private $from;
        private $body;
        private $subjet;

        // server settings
        public function __construct(){

            $mail = new PHPMailer(true);
            
            // site = https://mailtrap.io/
            // mail = patepo9430@edmondpt.com
            // pass = jJnd6DA8mybhbiJ

            try {
                $mail->SMTPDebug = 2; // ver debug STMP salida, si no quieres usarlo comentalo y mira la cuenta
                $mail->isSMTP();   //Send using SMTP
                $mail->Host = 'smtp.mailtrap.io';    //Set the SMTP server to send through
                $mail->SMTPAuth = true;     //Enable SMTP authentication
                $mail->Username = '605c40be53eb4e';   //SMTP username
                $mail->Password = 'bfa59a13b732d6';      //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port = 2525;  //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                $this->mail=$mail; // declaramos $mail para clonarla mas adelante

            }  catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }

        /*** Envia el email* 
        * @param <string> $to Es la dirección de email del destinatario
        * @param <string> $subject Es el asunto del mensaje
        * @param <string> $body Es el cuerpo del mensaje
        * @param <boolean> $is_html Indica si el cuerpo del mensaje está en formato html
        * @param <array> $para_cc Un array de direcciones de email para copia Cc
        * @param <array> $para_bcc Un array de direcciones de email para copia Bcc
        * @return <boolean> Devuelve true si se envia el email y lanza una excepción en caso de fallo*/

        //... Envia el email y devuelve true si todo ha ido bien o lanza una excepción si falla
        private function sendEmail($to, $subject, $body, $from, $is_html=false, Array $para_cc=array(), Array$para_bcc=array()){
            
            $mail = $this->mail;
            $is_html = true;

            // mail = patepo9430@edmondpt.com
            // pass = jJnd6DA8mybhbiJ

            // verificamos que el formulario este vacio
            if (isset($_POST['enviar'])) {

                // evitamos enviar duplicados enviando un correo por cada tipo
                switch ($_POST['action']) {

                    case 'registro':

                        $mail_1 = clone $mail; // clonamos la primera instancia
                        $mail_1->setFrom($from); // fuente
                        $mail_1->addAddress($to); // destino
                        $mail_1->isHTML( $is_html); // es html?
                        $mail_1->CharSet = 'UTF-8'; // tildes etc...
                        $mail_1->Subject = $subject; // asunto
                        $mail_1->Body = $body; // mensaje
                        
                        if(!$mail_1->Send()) { // si el mansaje no es enviado muestra error, en caso contrario lanza mensaje satisfactorio 
                            echo "Mailer Error: " . $mail_1->ErrorInfo;
                        } else {
                            echo "Mensaje enviado!<br>";
                        };

                        break;

                    case 'baja':

                        $mail_2 = clone $mail;
                        $mail_2->setFrom($from);
                        $mail_2->addAddress($to); 
                        $mail_2->isHTML($is_html);
                        $mail_2->CharSet = 'UTF-8';
                        $mail_2->Subject = $subject;
                        $mail_2->Body = $body;

                        if(!$mail_2->Send()) {
                            echo "Mailer Error: " . $mail_2->ErrorInfo;
                        } else {
                            echo "Mensaje enviado!<br>";
                        };
                        break;

                    case 'recuperar':

                        $mail_3 = clone $mail;
                        $mail_3->setFrom($from);
                        $mail_3->addAddress($to); 
                        $mail_3->isHTML($is_html);
                        $mail_3->CharSet = 'UTF-8';
                        $mail_3->Subject = $subject;
                        $mail_3->Body = $body;

                        if(!$mail_3->Send()) {
                            echo "Mailer Error: " . $mail_3->ErrorInfo;
                        } else {
                            echo "Mensaje enviado!<br>";
                        };

                    default:
                        return false;
                        break;
                }
            }
        }

        // creamos los diferentes mensaje y usamos la funcion sendEmail() para enviar el correo.

        public function sendWelcomeEmail(){

            //Recipients
            $from = 'info_1@doctorsender.com';
            $to = 'maruan@doctorsender.comt';
            $subject = 'Bienvenido!';
            $body = '<p>Bienvenido <strong>'.$_POST["user"].'</strong>, su registro se ha realizado con éxito.<p>
            <p>Esperemos que nuestros servicios sean de su agrado</p>
            <p>Un saludo</p>';

            $this->sendEmail($to, $subject, $body, $from);
        }

        public function sendUnsubscribeEmail(){

            $from = 'info_2@doctorsender.com';
            $to = 'maruan@doctorsender.comt';
            $subject = 'Darse de baja';
            $body = '<p><strong>Sentimos</strong> que se haya dado de baja, <strong>'.$_POST["user"].'</strong>, en esta vida todos merecen
                        una segunda <strong>oportunidad</strong>, hemos modificado nuestras alertas para que puedas elegir a tu gusto.<p>
                        <p>Cuentanos.... que noticias te gustaria recibir de nosotros?</p>
                        <table>
                            <tr>
                                <th>Marketing</th>
                                <th>Diseño</th>
                                <th>Asesoramiento</th>
                            </tr>
                            <tr>
                                <td>Noticias sobre marketing</td>
                                <td>Ofertas de diseño</td>
                                <td>Asesoramientos personalizados</td>
                            </tr>
                        </table>
                        <p><strong>Sigue</strong> queriendo darse de baja?.
                        Odiamos decir adios, pero si cambia de opinión estaremos aquí. Haz click en el botón para darte de baja... :(</p><br>
                        <button>Darse de baja</button>
                        '
            ;

            $this->sendEmail($to, $subject, $body, $from);

        }

        public function sendRecoveryPasswordMail(){

            $from = 'info_3@doctorsender.com';
            $to = 'maruan@doctorsender.comt';
            $subject = 'recuperar email'; 
            $body =     '<p>Estimad@ usuario,<br> le recordamos que sus datos de acceso son los siguientes:</p>
                            <p>usuario: '.$_POST["user"].',<br>
                            password: '.$_POST["pass"].'</p><br>
                        Un saludo.'
            ;
            
            $this->sendEmail($to, $subject, $body, $from);
            
        }
    };

    // instanciamos una nueva clase email y llamamos a sus métodos, estos crearán los detalles del correo y los mandarán usando sendEmail.
    $mail = new mail();
    $mail->sendWelcomeEmail();
    $mail->sendUnsubscribeEmail();
    $mail->sendRecoveryPasswordMail();

?>

<div class="grid">

    <form  method="POST" class="form login">

        <!--input ocultos para evitar enviar emails duplicados!-->

        <input type="hidden" name="action" value="registro">
        <input type="hidden" name="action" value="baja" >
        <input type="hidden" name="action" value="recuperar">

        <div class="form__field">
            <label for="login__username"><svg class="icon">
                <use xlink:href="#icon-user"></use> <!--Referencia al svg-->
                </svg><span class="hidden">Username</span></label>
            <input autocomplete="username" id="login__username" type="text" name="user" value="user" class="form__input" placeholder="Username" required>
        </div>

        <div class="form__field">
            <label for="login__password"><svg class="icon">
                <use xlink:href="#icon-lock"></use> <!--Referencia al svg-->
                </svg><span class="hidden">Password</span></label>
            <input id="login__password" type="text" name="pass" value="pass" class="form__input" placeholder="Password" required>
        </div>

        <div class="form__field">
            <input type="submit" name="enviar" value="Enviar">
        </div>

    </form>
      
</div>

<!--Globlal SVG para los iconos-->
<svg xmlns="http://www.w3.org/2000/svg" class="icons">
    <symbol id="icon-arrow-right" viewBox="0 0 1792 1792">
        <path d="M1600 960q0 54-37 91l-651 651q-39 37-91 37-51 0-90-37l-75-75q-38-38-38-91t38-91l293-293H245q-52 0-84.5-37.5T128 1024V896q0-53 32.5-90.5T245 768h704L656 474q-38-36-38-90t38-90l75-75q38-38 90-38 53 0 91 38l651 651q37 35 37 90z" />
    </symbol>
    <symbol id="icon-lock" viewBox="0 0 1792 1792">
        <path d="M640 768h512V576q0-106-75-181t-181-75-181 75-75 181v192zm832 96v576q0 40-28 68t-68 28H416q-40 0-68-28t-28-68V864q0-40 28-68t68-28h32V576q0-184 132-316t316-132 316 132 132 316v192h32q40 0 68 28t28 68z" />
    </symbol>
    <symbol id="icon-user" viewBox="0 0 1792 1792">
        <path d="M1600 1405q0 120-73 189.5t-194 69.5H459q-121 0-194-69.5T192 1405q0-53 3.5-103.5t14-109T236 1084t43-97.5 62-81 85.5-53.5T538 832q9 0 42 21.5t74.5 48 108 48T896 971t133.5-21.5 108-48 74.5-48 42-21.5q61 0 111.5 20t85.5 53.5 62 81 43 97.5 26.5 108.5 14 109 3.5 103.5zm-320-893q0 159-112.5 271.5T896 896 624.5 783.5 512 512t112.5-271.5T896 128t271.5 112.5T1280 512z" />
    </symbol>
</svg>

</body>
</html>

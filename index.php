<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            @import url('https://fonts.googleapis.com/css?family=Yantramanav:100,300');
            * {
                box-sizing: border-box;
            }

            body {
                background: #3952a3;
                color: #485e74;
                line-height: 1.6;
                font-family: 'Yantramanav', sans-serif;
                padding: 1em;
            }

            .container {
                max-width: 1170px;
                margin-left: auto;
                margin-right: auto;
                padding: 1em;
            }

            ul {list-style: none; padding: 0;}
            .brand {
                text-align: center;
                font-weight: 300;
                text-transform: uppercase;
                letter-spacing: 0.1em;
            }

            .brand span {color: #ffffff;}
            .wrapper {box-shadow: 0 0 20px 0 rgba(57, 82, 163, 0.7);}
            .wrapper > * {padding: 1em;}
            .company-info {
                background: #C3C9DD;
                border-top-left-radius: 4px;
                border-top-right-radius: 4px;
            }

            .company-info h3,
            .company-info ul {
                text-align: center;
                margin: 0 0 1rem 0;
            }

            .contact {
                background: #dcdfea;
                border-bottom-left-radius: 4px;
                border-bottom-right-radius: 4px;
            }

            .contact form {
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-gap: 20px;
            }

            .contact form label {display: block;}
            .contact form p {margin: 0;}
            .contact form .full {grid-column: 1 / 3;}
            .contact form button,
            .contact form input,
            .contact form textarea {
                width: 100%;
                padding: 1em;
                border: solid 1px #627EDC;
                border-radius: 4px;
            }

            .contact form textarea {resize: none;}
            .contact form button {
                background: #627EDC;
                border: 0;
                color: #e4e4e4;
                text-transform: uppercase;
                font-size: 14px;
                font-weight: bold;
                cursor: pointer;
            }

            .contact form button:hover,
            .contact form button:focus {
                background: #3952a3;
                color: #ffffff;
                outline: 0;
                transition: background-color 2s ease-out;
            }

            @media only screen and (min-width: 700px) {
                .wrapper {
                    display: grid;
                    grid-template-columns: 1fr 2fr;
                }

                .wrapper > * {padding: 2em;}
                .company-info {border-radius: 4px 0 0 4px;}
                .contact {border-radius: 0 4px 4px 0;}
                .company-info h3, .company-info ul, .brand {text-align: left;}
            }
        </style>
        <title>Send Mail | Ahmet Şakar</title>
    </head>
    <body>
        <?php
            require './class/PHPMailer.php';
            require './class/SMTP.php';
            require './class/Exception.php';
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\Exception;

            // If Posted
            if (isset($_POST['newsletter'])) { 
                // If not empty
                if (!empty($_POST['firstname']) && !empty($_POST['lastname']) && !empty($_POST['email']) && !empty($_POST['message']) && !empty($_POST['subject'])) {      
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $email = $_POST['email'];
                    $subject = $_POST['subject'];
                    $message = $_POST['message'];
                    
                    $mail = new PHPMailer();            // Class call

                    $mail->IsSMTP();                    // SMTP Use
                    $mail->SMTPAuth = true;             // SMTP Auth
                    $mail->SMTPSecure = 'tls';          // SMTP SSL
                    
                    $mail->Host = 'smtp.gmail.com';     // SMTP host
                    $mail->Port = 587;                  // SMTP port

                    $mail->Username = 'Your email'; 
                    $mail->Password = 'Your password'; 

                    $mail->setFrom('Your Email', 'Your name'); 
                    $mail->addAddress($_POST['email'], 'Account Activation');   // Member
                    
                    $mail->isHTML(true);                                        // HTML Use true
                    $mail->CharSet = 'UTF-8';                                   // Character
                    $mail->Subject = $subject;                                  // Email subject
                    $mail->Body = '
                        <div style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: center; flex-direction: column;">
                            <p>'.$message.'</p>
                            <small style="margin-top: 10px">'.$firstname.' '.$lastname.'</small>
                        </div>
                    ';
                    
                    if ($mail->Send()) { // If email sended 
                        echo '<script>alert("Email sending successful");</script>';
                    } else { // If not send
                        echo '<script>alert("Email sending failed!");</script>';
                    }
                } else { // If empty
                    echo '<script>alert("Email cannot be left blank");</script>';
                }
            }
        ?>

        <div class="container">
            <h1 class="brand">
                <span>Ahmet Şakar</span>
            </h1>

            <div class="wrapper">
                <div class="company-info">
                    <h3>www.example.com</h3>

                    <ul>
                        <li><i class="fa fa-road"></i> Location : Country/City</li>
                        <li><i class="fa fa-envelope"></i> Email : mail@mail.com</li>
                    </ul>
                </div>

                <div class="contact">
                    <h3>Send Mail</h3>

                    <form id="contact-form" method="POST" action="mail.php">
                        <p>
                            <label>FirstName <font color="red">*</font></label>
                            <input type="text" name="firstname" placeholder="FirstName" autocomplete="off" required>
                        </p>

                        <p>
                            <label>LastName <font color="red">*</font></label>
                            <input type="text" name="lastname" placeholder="LastName" autocomplete="off" required>
                        </p>

                        <p>
                            <label>Email <font color="red">*</font></label>
                            <input type="email" name="email" placeholder="Email" autocomplete="off" required>
                        </p>

                        <p>
                            <label>Web URL (Optional)</label>
                            <input type="email" name="website" placeholder="URL" autocomplete="off">
                        </p>

                        <p class="full">
                            <label>Subject <font color="red">*</font></label>
                            <input type="text" name="subject" placeholder="Subject" autocomplete="off" required>
                        </p>

                        <p class="full">
                            <label>Message <font color="red">*</font></label>
                            <textarea name="message" rows="5" placeholder="Message" autocomplete="off" required></textarea>
                        </p>

                        <p class="full">
                            <button type="submit" name="newsletter">Submit</button>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
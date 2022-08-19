<?php require_once('header.php') ?>
<?php
    $statement = $pdo->prepare("SELECT * FROM tbl_page WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $contact_title = $row['contact_title'];
        $contact_banner = $row['contact_banner'];
    }
    $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $contact_map_iframe = $row['contact_map_iframe'];
        $contact_email = $row['contact_email'];
        $contact_phone = $row['contact_phone'];
        $contact_address = $row['contact_address'];
        $banner_contact  = $row['banner_home'];
    }
?>
<?php
    // After form submit checking everything for email sending
    if(isset($_POST['form_contact']))
    {
        $error_message = '';
        $success_message = '';
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row)
        {
            $receive_email = $row['receive_email'];
            $receive_email_subject = $row['receive_email_subject'];
            $receive_email_thank_you_message = $row['receive_email_thank_you_message'];
        }
        $valid = 1;
        if(empty($_POST['visitor_name']))
        {
            $valid = 0;
            $error_message .= 'Please enter your name.\n';
        }

        if(empty($_POST['visitor_phone']))
        {
            $valid = 0;
            $error_message .= 'Please enter your phone number.\n';
        }
        if(empty($_POST['visitor_email']))
        {
            $valid = 0;
            $error_message .= 'Please enter your email address.\n';
        }
        else
        {
            // Email validation check
            if(!filter_var($_POST['visitor_email'], FILTER_VALIDATE_EMAIL))
            {
                $valid = 0;
                $error_message .= 'Please enter a valid email address.\n';
            }
        }
        if(empty($_POST['visitor_message']))
        {
            $valid = 0;
            $error_message .= 'Please enter your message.\n';
        }
        if($valid == 1)
        {
            $visitor_name = strip_tags($_POST['visitor_name']);
            $visitor_email = strip_tags($_POST['visitor_email']);
            $visitor_phone = strip_tags($_POST['visitor_phone']);
            $visitor_message = strip_tags($_POST['visitor_message']);
            // sending email
            $to_admin = $receive_email;
            $subject = $receive_email_subject;
            $message = '
                <html><body>
                <table>
                <tr>
                <td>Name</td>
                <td>'.$visitor_name.'</td>
                </tr>
                <tr>
                <td>Email</td>
                <td>'.$visitor_email.'</td>
                </tr>
                <tr>
                <td>Phone</td>
                <td>'.$visitor_phone.'</td>
                </tr>
                <tr>
                <td>Comment</td>
                <td>'.nl2br($visitor_message).'</td>
                </tr>
                </table>
                </body></html>
                ';
            $headers = 'From: ' . $visitor_email . "\r\n" .
                        'Reply-To: ' . $visitor_email . "\r\n" .
                        'X-Mailer: PHP/' . phpversion() . "\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/html; charset=ISO-8859-1\r\n";

            // Sending email to admin
            mail($to_admin, $subject, $message, $headers);
            $success_message = $receive_email_thank_you_message;
        }
    }
?>
<?php
    if($error_message != '') {
        echo "<script>alert('".$error_message."')</script>";
    }
    if($success_message != '') {
        echo "<script>alert('".$success_message."')</script>";
    }
?>
<section>
    <img src="images/mugdhBnr2.jpg" alt="" class="img-fluid">
    <div class="contact-sec my-sec">
        <div class="container">
            <div class="row align-items-center mt-3 mt-sm-5">
                <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7 contact-left">
                    <form action="" method="post">
                        <?php $csrf->echoInputField(); ?>
                        <div class="block mb-2 mb-sm-5">
                            <h2>CONTACT US</h2>
                            <label>
                                Name
                                <input type="text" class="form-control" name="visitor_name" placeholder="Enter name">
                            </label>
                            <label>
                                Phone Number
                                <input type="text" class="form-control" name="visitor_phone"
                                    placeholder="Enter phone number">
                            </label>
                            <label>
                                Email
                                <input type="email" class="form-control" name="visitor_email"
                                    placeholder="Enter email address">
                            </label>
                            <label>
                                Message
                                <textarea name="visitor_message" class="form-control" rows="5" cols=""
                                    placeholder="Enter message"></textarea>
                            </label>
                            <div>
                                <input type="submit" value="Send Message" class="my-btn"
                                    name="form_contact">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5 contact-right">
                    <div class="block">
                        <ul>
                            <li>
                                Address <img src="latest/images/contact/address-icon.png" alt=""> <br>
                                <?php echo nl2br($contact_address); ?>
                            </li>
                            <li>
                                Phone <img src="latest/images/contact/phoe-icon.png.png" alt=""> <br>
                                <a href="tel:<?=$contact_phone;?>">
                                    <?php echo $contact_phone; ?>
                                </a>
                            </li>
                            <li>
                                Email <img src="latest/images/contact/email-icon.png" alt=""> <br>
                                <a href="mailto:<?=$contact_email; ?>">
                                    <?php echo $contact_email; ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="catle-sec">
        <img src="latest/images/catle-img.png" class="img-responsive">
    </div>
</section>
<?php require_once('footer.php') ?>
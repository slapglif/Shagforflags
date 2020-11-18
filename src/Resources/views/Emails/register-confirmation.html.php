<?php $view->extend("Emails/layout.html.php");?>

<tr style="background-color: #ffffff;">
    <td style="padding: 20px; line-height: 22px; color: #646363; font-size: 15px;">
        <br />
        <p><strong>Hello,</strong></p>
        <br />
        <p>Thank you for getting started with Shag For Flags! You are just one step away. Please click on the link below to activate your account.</p>
    </td>
</tr>

<tr style="background-color: #ffffff;">
    <td style="padding: 10px 20px 20px 20px; text-align: center;">
        <a class="custom_btn" href="http://<?php echo $_SERVER['HTTP_HOST'].$view['router']->path('fos_user_registration_confirm', array('token' => $conftoken)); ?>" target="_blank">Activate Account</a>
    </td>
</tr>

<tr style="background-color: #ffffff;">
    <td style="padding: 20px; line-height: 22px; color: #646363; font-size: 15px;">
        <p>Cheers,</p>
        <p><b>The Shag For Flags Team</b></p>
    </td>
</tr>
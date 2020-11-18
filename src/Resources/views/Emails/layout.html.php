<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shag For Flags</title>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,greek,greek-ext,latin-ext' rel='stylesheet' type='text/css'>
    <style>
        @font-face {
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: 400;
            src: local('Open Sans'), local('OpenSans'), url(http://themes.googleusercontent.com/static/fonts/opensans/v6/cJZKeOuBrn4kERxqtaUH3bO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
        }

        * {
            padding: 0px;
        }
        img, p{
            border: none !important;
            margin: 0px;
        }
        body{
            background-color: #ededed;
            margin: 0px;
            padding: 0px;
            font-family: "Open Sans", arial, sans-serif;
            color: #646363;
            font-size: 12px;
        }
        .custom_btn{
            display: block;
            width: 570px;
            padding: 10px 5px;
            background-color: #ffffff;
            border: 2px solid #cccccc;
            color: #ffaa00;
            font-size: 16px;
            text-align: center;
            font-weight: bold;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
<table border="0" cellpadding="0" cellspacing="0" width="630" align="center">
    <tr style="background-color: #ffffff;">
        <td align="center" style="padding: 10px 0px 10px 0px;">&nbsp;</td>
    </tr>

    <tr>
        <td style="padding: 0px;">
            <table border="0" cellpadding="0" cellspacing="0" width="630" align="center">
                <?php $view['slots']->output('_content');?>
            </table>
        </td>
    </tr>

    <tr style="background-color: #cccccc;">
        <td style="padding: 10px 20px 10px 20px; color: #000000;">
            <p><b>Have you encountered a problem?</b></p>
            <p>You can contact us by sending an e-mail to support@shagforflags.com</p>
        </td>
    </tr>
</table>
</body>
</html>
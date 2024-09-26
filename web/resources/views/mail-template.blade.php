<!doctype html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>{{ $details['subject'] }}</title>
    <style media="all" type="text/css">
        body {
            font-family: Helvetica, sans-serif;
            font-size: 16px;
            line-height: 1.3;
            background-color: #f4f5f6;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: separate;
            width: 100%;
        }

        table td {
            font-family: Helvetica, sans-serif;
            font-size: 16px;
            vertical-align: top;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding-top: 24px;
        }

        .main {
            background: #ffffff;
            border: 1px solid #eaebed;
            border-radius: 16px;
            width: 100%;
        }

        .wrapper {
            padding: 24px;
        }

        .footer {
            padding-top: 24px;
            text-align: center;
            color: #9a9ea6;
            font-size: 16px;
        }

        a {
            color: #0867ec;
            text-decoration: underline;
        }

        .btn {
            min-width: 100%;
        }

        .btn-primary a {
            background-color: #0867ec;
            color: #ffffff;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 4px;
        }

        @media only screen and (max-width: 640px) {
            .container {
                width: 100% !important;
                padding-top: 8px !important;
            }

            .wrapper {
                padding: 8px !important;
            }

            .btn-primary a {
                width: 100% !important;
                display: block;
            }
        }
    </style>
</head>
<body>
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
    <tr>
        <td>&nbsp;</td>
        <td class="container">
            <div class="content">

                <!-- START CENTERED WHITE CONTAINER -->
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="main">
                    <!-- LOGO SECTION -->
                    <tr>
                        <td class="wrapper" align="center">
                            <img src="https://a8fcb0-2.myshopify.com/cdn/shop/files/dun-logo-navigation.png?v=1726672797&width=140" alt="Your Company Logo" style="max-width: 150px;">
                        </td>
                    </tr>

                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class="wrapper">
                            <p>Hi there</p>
                            <p>By Clicking the button you can see the details of your recent configuration</p>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                                <tbody>
                                <tr>
                                    <td align="left">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                            <tr>
                                                <td> <a href="https://a8fcb0-2.myshopify.com/pages/builder?preview={{ $details['unique_id'] }}" target="_blank">Preview</a> </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <p>Good luck! Hope it works.</p>
                        </td>
                    </tr>

                    <!-- END MAIN CONTENT AREA -->
                </table>



            </div>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
</body>
</html>

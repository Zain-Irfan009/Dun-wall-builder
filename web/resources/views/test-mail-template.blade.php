<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design Saved Email</title>
    <style>
        /* Reset and base styles */
        body, table, td, a { font-family: Arial, sans-serif; color: #333; text-decoration: none; }
        img { display: block; max-width: 100%; height: auto; }
        table { border-collapse: collapse; width: 100%; }
        .header_template_logo, .content_template_details .content_template_details-inner {
            background: #FCFAF8;
            border-radius: 10px;
        }
        /* Layout and appearance */
        .content_template_details{border-top:2px solid #FFFFFF}
        .email-container { max-width: 600px; margin: auto;  }
        .header-logo { text-align: center;    text-align: -webkit-center; padding: 20px 0; }
        .content { padding: 20px;border-top:2px solid #FFFFFF}
        .center-text { text-align: center; }
        .button { background-color: #78866B; color: #FFFFFF; padding: 12px 24px; border-radius: 20px; display: inline-flex; margin: 20px 0; font-size: 16px; font-weight: bold; }
        .button img {
            margin-left: 38px; /* Space between text and icon */
            vertical-align: middle;
        }
        .section { padding: 20px 0; }
        .section h2 { color: #333333; font-size: 24px; font-weight: bold; }
        .section p { color: #555555; font-size: 16px; line-height: 1.6; }

        /* Responsive adjustments */
        @media screen and (max-width: 600px) {
            .email-container { padding: 10px; }
            .button { width: 100%; text-align: center; }
        }

        .check_mark{
            text-align: -webkit-center;
        }
        .next_div{
            text-align: -webkit-center;
        }

        .headings{
            font-weight: 700;
            font-size: 32px;
            line-height: 36.8px;
            font-family: Helvetica;
        }
        .paragraphs{
            font-size: 20px;
            color: #000000;
            line-height: 30px;
            font-weight:400;
            font-family: Helvetica;

        }
        .container-small{
            max-width: 360px;
            margin: 0 auto;

        }

        .btn_link{
            text-decoration:underline;background-color: transparent;font-weight: 700;font-size: 16px;line-height: 20.48px; color: #66805E;
        }

    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #FFFFFF;">

<div role="presentation" class="email-container">
    <!-- Logo Section -->
    <div class="header_template_logo">
        <div class="header-logo">
            <img src="https://a8fcb0-2.myshopify.com/cdn/shop/files/dun-logo-navigation.png?v=1726672797&width=140" alt="Your Company Logo" style="max-width: 150px;">
        </div>
    </div>

    <!-- Main Content Section -->
    <div class="content_template_details ">
    <div class="content_template_details-inner ">
        <div class="content">
            <div class="container-small">
            <!-- Header Text -->
            <div class="center-text">
               <div class="check_mark">
                <img src="{{asset('icon_circle.png')}}" alt="Checkmark" width="40" style="margin-bottom: 20px;">
               </div>
                <h1 style="font-size: 48px; color: #333333; font-weight: 700;line-height:55.2px">Hi, your design has been saved</h1>
                <p class="paragraphs">
                    Click the link below to view, modify, or reference the approximate installation measurements for your custom Dūn wallscape.
                </p>
                <a href="https://a8fcb0-2.myshopify.com/pages/builder?preview=22" target="_blank" class="button">View Now <img src="{{asset('Vector2.png')}}"></a>
            </div>
            </div>
        </div>
            <!-- Divider -->


            <!-- "What's Next?" Section -->
            <div class="content">
                <div class="container-small">
                <h2 class="center-text" style="font-size: 16px;font-weight: 700;line-height:
18.4px; color: #B96F48;">WHAT'S NEXT?</h2>
                <!-- Continue Shopping -->
                <div class="center-text">
                    <div class="next_div">
                    <img src="{{asset('icon_cart.png')}}" alt="Cart Icon" width="40" style="margin: 10px 0;">
                    </div>
                        <h2 class="headings"> Continue Shopping</h2>
                    <p class="paragraphs">Dūn empowers you to add texture, color, and light play to any room. Shop our dynamic layouts or create a new custom wallscape in Dūn Studio.</p>
                    <a href="https://a8fcb0-2.myshopify.com/" target="_blank" class="button btn_link" >SHOP NOW</a>
                </div>

                </div>

            </div>

                <!-- Learn More -->
                <div class="content">
                    <div class="container-small">
                <div class="center-text" style="margin-top: 40px;">
                    <div class="next_div">
                        <img src="{{asset('icon_question_mark.png')}}" alt="Cart Icon" width="40" style="margin: 10px 0;">
                    </div>
                    <h2 class="headings">Learn More</h2>
                    <p class="paragraphs">Slide into our Frequently Asked Questions page for more information. If you have any unanswered questions, please reach out to us directly.</p>
                    <a href="https://a8fcb0-2.myshopify.com/" target="_blank" class="button btn_link">GO NOW</a>
                </div>
                    </div>
                </div>
                <!-- Follow Us -->
                <div class="content">
                    <div class="container-small">
                <div class="center-text" style="margin-top: 40px;">
                    <div class="next_div">
                        <img src="{{asset('icon_image.png')}}" alt="Cart Icon" width="40" style="margin: 10px 0;">
                    </div>
                    <h2 class="headings">Follow Us</h2>
                    <p class="paragraphs">Looking for inspiration or want to see how others use Dūn in their space?</p>
                    <a href="https://a8fcb0-2.myshopify.com/" target="_blank" class="button btn_link" >LET'S CONNECT</a>
                </div>
            </div>
            </div>
    </div>
    </div>
</div>

</body>
</html>

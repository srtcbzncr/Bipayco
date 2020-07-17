<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{asset('/images/Bipayco.ico')}}">
    <title>Şifreni Sıfırla</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        /**

         * Google webfonts. Recommended to include the .woff version for cross-client compatibility.
         */
        @import url('https://fonts.googleapis.com/css2?family=Kodchasan&display=swap');
        /**
         * Avoid browser level font resizing.
         * 1. Windows Mobile
         * 2. iOS / OSX
         */
        body,
        table,
        td,
        a {
            -ms-text-size-adjust: 100%; /* 1 */
            -webkit-text-size-adjust: 100%; /* 2 */
        }

        /**
         * Remove extra space added to tables and cells in Outlook.
         */
        table,
        td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
        }

        /**
         * Better fluid images in Internet Explorer.
         */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /**
         * Remove blue links for iOS devices.
         */
        a[x-apple-data-detectors] {
            font-family: 'Kodchasan', sans-serif;
        }

        /**
         * Fix centering issues in Android 4.4.
         */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }

        body {
            font-family: 'Kodchasan', sans-serif;

            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /**
         * Collapse table borders to avoid space between cells.
         */
        table {
            border-collapse: collapse !important;
        }

        a {
            color: #1a82e2;
        }

        img {
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
        }
    </style>

</head>
<body style="background-color: #e9ecef;">

<!-- start preheader -->
<div class="preheader" style="display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;">
    Şifreni sıfırlamak için talep aldık.
</div>
<!-- end preheader -->

<!-- start body -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">

    <!-- start logo -->
    <tr>
        <td align="center" bgcolor="#e9ecef">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                <tr>
                    <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td align="center" valign="top" style="padding: 36px 24px;">
                        <a href="https://bipayco.com" target="_blank" style="display: inline-block;">
                            <img src="https://bipayco.com/images/logo2.png" alt="Bipayco" border="0" width="48" style="display: block; width: 250px; max-width: 500px; min-width: 125px;">
                        </a>
                    </td>
                </tr>
            </table>
{{--            <!--[if (gte mso 9)|(IE)]>--}}
{{--            </td>--}}
{{--            </tr>--}}
{{--            </table>--}}
{{--            <![endif]-->--}}
        </td>
    </tr>
    <!-- end logo -->

    <!-- start hero -->
    <tr>
        <td align="center" bgcolor="#e9ecef">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                <tr>
                    <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <tr>
                    <td align="left" bgcolor="#ffffff" style="padding: 36px 24px 0; border-top: 3px solid #d4dadf;">
                        <h1 style="margin: 0; font-size: 32px; font-weight: 700; letter-spacing: -1px; line-height: 48px;">Canlı Yayın Başladı</h1>
                    </td>
                </tr>
            </table>
{{--            <!--[if (gte mso 9)|(IE)]>--}}
{{--            </td>--}}
{{--            </tr>--}}
{{--            </table>--}}
{{--            <![endif]-->--}}
        </td>
    </tr>
    <!-- end hero -->

    <!-- start copy block -->
    <tr>
        <td align="center" bgcolor="#e9ecef">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                <tr>
                    <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

                <!-- start copy -->
                <tr>
                    <td align="left" bgcolor="#ffffff" style="padding: 24px; font-size: 16px; line-height: 24px;">
                        <p style="margin: 0;">Sahip olduğun {{$course->name}} adlı canlı yayın başladı. Hadi canlı yayını kaçırma! Aşağıdaki butona tıklayarak canlı yayına katılabilirsin.</p>
                    </td>
                </tr>
                <!-- end copy -->

                <!-- start button -->
                <tr>
                    <td align="left" bgcolor="#ffffff">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td align="center" bgcolor="#ffffff" style="padding: 12px;">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center" bgcolor="#1a82e2" style="border-radius: 6px;">
                                                <a href="{{route('live_course', $course->id)}}" target="_blank" style="display: inline-block; padding: 16px 36px;  font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;">Canlı Yayını Aç</a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <!-- end button -->

                <!-- start copy -->
                <tr>
                    <td align="left" bgcolor="#ffffff" style="padding: 24px; font-size: 16px; line-height: 24px;">
                        <p style="margin: 0;">Eğer butonu görmüyorsan, aşağıdaki linki kullanabilirsin.</p>
                        <p style="margin: 0;"><a href="{{route('live_course', $course->id)}}" target="_blank">"{{url('live_course', $course->id)}}"</a></p>
                    </td>
                </tr>
                <!-- end copy -->

            </table>
{{--            <!--[if (gte mso 9)|(IE)]>--}}
{{--            </td>--}}
{{--            </tr>--}}
{{--            </table>--}}
{{--            <![endif]-->--}}
        </td>
    </tr>
    <!-- end copy block -->

    <!-- start footer -->
    <tr>
        <td align="center" bgcolor="#e9ecef" style="padding: 24px;">
            <!--[if (gte mso 9)|(IE)]>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                <tr>
                    <td align="center" valign="top" width="600">
            <![endif]-->
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                <!-- start permission -->
                <tr>
                    <td align="center" bgcolor="#e9ecef" style="padding: 12px 24px; font-size: 14px; line-height: 20px; color: #666;">
                        <p style="margin: 0;">Bu emaili, Satın aldığın {{$course->name}} adlı canlı yayın eğitmen tarafından başlatıldığı için aldın.</p>
                    </td>
                </tr>
                <!-- end permission -->

                <!-- start unsubscribe -->
                <tr>
                    <td align="center" bgcolor="#e9ecef" style="padding: 12px 24px; font-size: 14px; line-height: 20px; color: #666;">
                        <p style="margin: 0;">© 2020 Bipayco</p>
                    </td>
                </tr>
                <!-- end unsubscribe -->

            </table>
{{--            <!--[if (gte mso 9)|(IE)]>--}}
{{--                </td>--}}
{{--                </tr>--}}
{{--                </table>--}}
{{--            <![endif]-->--}}
        </td>
    </tr>
    <!-- end footer -->

</table>
<!-- end body -->

</body>
</html>

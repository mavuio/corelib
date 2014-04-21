<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.=
w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>error-notice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=3Dutf-8">
    <style type="text/css">
    .ExternalClass {
        display:block !important;
    }
    * {
        -webkit-text-size-adjust: none;
        -webkit-text-resize: 100%;
        text-resize: 100%;
    }
    a {
        text-decoration: none;
        color: inherit;
    }
    a img {
        border: 0 !important;
    }
    @media only screen and (max-width:480px) {
        table[class=3D"wrapper"] {
            min-width:320px !important;
        }
        table[class=3D"flexible"] {
            width:100% !important;
        }
        *[class].img-flex img {
            width:100% !important;
            height:auto !important;
        }
        *[class].stacking.text {
            display: block;
            text-align: center !important;
            padd=ing: 12px 12px 0 !important
        }
        *[class].stacking {
            display: block;
            text-align: center !important;
        }
        *[class].inventor.cells {
            display:block;
            margin: 0 auto;
            padding-bottom: 24p=x;
        }
        ;
    }
    </style>
</head>

<body style="margin:0;padding:0;" bgcolor="#EEEEEE" link="#666666">
    <style type="text/css">
    * {
        -webkit-text-size-adjust: none;
        -webkit-text-resize: 100%;
        text-resize: 100%;
    }
    </style>
    <table class="wrapper" width="100%" cellspacing="0" cellpadding="0"=b gcolor="#EEEEEE">
        <tr>
            <td style="padding:0px 10px 40px;">
                <table class="flexible" width="600px" align="center" cellpadding="0=
" cellspacing="0">

                    <tr>
                        <td style="border-radius: 3px">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding: 32px 16px; border-top-left-radius: 3px; border-top-ri=
ght-radius: 3px" bgcolor="#FFFFFF">
                                        <table class="flexible" align="left" cellpadding="0" cellspacing="0=
" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace=
:0pt;">
                                            <tr>
                                                <td class="stacking text" align="left" style="font:18px Helvetica, Ar=
ial, sans-serif; line-height:28px; color:#5E6367; padding: 0px 24px 0px">
                                                    <p style="margin: 0px; font: 24px Helvetica, Arial, sans-serif; padding:0 0px 8px">An Error occured</p>

                                                    <div>&nbsp;</div>
                                                        {{$msg}}
                                                    <div>&nbsp;</div>
                                                    Error-details:
                                                    <div>&nbsp;</div>
                                                        <pre>{{print_r($data)}}</pre>
                                                    <div>&nbsp;</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>

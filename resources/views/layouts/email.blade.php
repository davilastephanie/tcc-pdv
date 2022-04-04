<html>
<head>
    <meta charset="utf-8">
    <style>
        a {
            color: #321fdb;
            text-decoration: none;
        }
    </style>
</head>
<body style="background-color: #f4f4f4; color: #9b9b9b; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 16px; margin: 0; padding: 0;">
<div align="center">
    <table width="650" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td width="650" height="30"></td>
        </tr>
        <tr>
            <td width="650">
                <table width="650" cellpadding="0" cellspacing="0" border="0" bgcolor="#321fdb" style="border-radius: 5px; box-shadow: 2px 2px 2px 2px rgba(0,0,0,0.1);">
                    <tr>
                        <td width="650" height="80" align="center">
                            <a class="navbar-brand" href="{{ env('SITE_URL') }}" target="_blank">
                                <img src="{{ asset('/img/logo.png') }}"
                                     alt="{{ env('SITE_FULL_NAME') }}"
                                     border="0"
                                     height="46"
                                >
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td width="650" height="30"></td>
        </tr>
    </table>
    <table width="650" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="border-radius: 5px; box-shadow: 2px 2px 2px 2px rgba(0,0,0,0.1);">
        <tr>
            <td width="25"></td>
            <td width="600">
                <table width="600" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td width="600" height="20"></td>
                    </tr>
                    <tr>
                        <td width="600" style="color: #212529; font-size: 16px;">
                            @yield('content')
                        </td>
                    </tr>
                    <tr>
                        <td width="600" height="20"></td>
                    </tr>
                    @hasSection('signature')
                        <tr>
                            <td width="600" style="color: #3875dc; font-size: 16px;">
                                Atenciosamente,
                                <br>{{ env('SITE_FULL_NAME') }}.
                            </td>
                        </tr>
                        <tr>
                            <td width="600" height="20"></td>
                        </tr>
                    @endif
                </table>
            </td>
            <td width="25"></td>
        </tr>
    </table>
    <table width="650" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td width="650" height="30"></td>
        </tr>
    </table>
</div>
</body>
</html>
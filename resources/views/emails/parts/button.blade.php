<table cellpadding="0" cellspacing="0" border="0" bgcolor="#321fdb" style="border-radius: 5px;">
    <tr>
        <td height="10"></td>
    </tr>
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0" bgcolor="#321fdb" style="border-radius: 5px;">
                <tr>
                    <td width="25"></td>
                    <td style="border-radius: 5px; color: #ffffff;">
                        <a href="{{ $link }}" target="_blank" style="color: #ffffff; text-decoration: none;">
                            {{ $label }}
                        </a>
                    </td>
                    <td width="25"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td height="10"></td>
    </tr>
</table>

<p style="color: #212529; font-size: 12px;">
    Caso não consiga clicar no botão, utilize o link abaixo:
    <br>
    <a href="{{ $link }}" target="_blank" style="color: #321fdb; text-decoration: none;">{{ $link }}</a>
</p>
{auth}
{role(%role)}
{guest}
{extends(%file)}
{include(%file)}
{section(%name)}
{content(%name)}


{include(%file)}


{for(%loop)}
{include(%file)}
{endfor}
{foreach(%loop)}
{endforeach}
{{$var->irgendwas}}

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        {include('')}
        <title></title>
    </head>
    <body>
        {if()}
            {if()}
            {else}
            {endif}
        {elif()}
        {else}
        {endif}
    </body>
</html>

<?php
//header('Content-Type: text/html; charset=utf-8');
function getConfiguracao($key)
{
    if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') //WINDOWS
    {
        $ini_array = parse_ini_file("E:/xampp/notificacoes.properties");
    }
    elseif(strtoupper(substr(PHP_OS, 0, 3)) === 'DAR') //MAC OS
    {
        $ini_array = parse_ini_file("/Applications/MAMP/htdocs/notificacoes.properties");
    }
    else //LINUX
    {
        $ini_array = parse_ini_file("/etc/vanportal/notificacoes.properties");
    } 
    
    $value =  $ini_array[$key];
    return $value;
}

<?php

try
{
    $root = dirname(__FILE__);
    require_once $root . '/Class/notificacoes.php';
    $notificacoes           = new Notificacoes();

    $tipo = filter_input(INPUT_POST,'tipo');
    $numero = filter_input(INPUT_POST,'numero');

    if (!$tipo)
    {        
        throw new Exception('Parâmetro tipo não informado. Por favor, informe-o.');
    }
    else
    {
        switch ($tipo)
        {
            case 'enviar-mensagem':
                $enviarSMS = $notificacoes->enviarMensagemSMS($numero);
                var_dump($enviarSMS);
                die;
            default:
                throw new Exception('Parâmetro informado incorreto.');
        }
    }
}
catch(Exception $e)
{
    echo json_encode(array('controle'=>false, 'resposta'=>$e->getMessage()));
}

?>
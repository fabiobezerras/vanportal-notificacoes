<?php

try
{
    $root = dirname(dirname(dirname(dirname(__FILE__))));
    require_once $root . '/dao/cobranca/dao_notificacoes.php';
    require_once $root . '/dao/portal/dao_pixcob_log.php';
    require_once $root . '/dao/portal/dao_logportal_novo.php';
    $notificacoes           = new dao_notificacoes();

    $tipo = filter_input(INPUT_POST,'tipo');

    if (!$tipo)
    {        
        throw new Exception('Parâmetro tipo não informado. Por favor, informe-o.');
    }
    else
    {
        switch ($tipo)
        {
            case 'enviar-mensagem':
                $enviarSMS = $notificacoes->enviarMensagemSMS();
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
<?php

$root = dirname(__FILE__);
require_once $root . '/configuracoes.php';

class Notificacoes
{
    public function enviarMensagemSMS($numeroTelefone = '5561982338180', $stringMensagem = 'PORTAL VANPIX - Seu número de TOKEN é 094700. POR FAVOR, NÃO INFORME ESSE NÚMERO À NINGUÉM.')
    {
        //Uma%20nova%20cobranca%20foi%20gerada%20pelo%20convenio%20PIX%20INFORMATICA%20NOSSO%20NUMERO%20232003685%20VALOR%2029%2000%20VENCIMENTO%2021%2008%202023
        try
        {
            if(is_null($stringMensagem) || empty($stringMensagem))
            {
                throw new Exception('Por favor, informe um texto de mensagem para envio da SMS.');
            }
            if(is_null($numeroTelefone) || empty($numeroTelefone))
            {
                throw new Exception('Por favor, informe um número de telefone para envio da SMS.');
            }
            if(strlen($numeroTelefone) > 13 || strlen($numeroTelefone) < 13)
            {
                throw new Exception('Por favor, informe um número de telefone válido (Formato 5561988888888 - 2 dígitos(55), 2 dígitos DDD e o restante do número com o 9 no início).');
            }

            $chaveSMS = getConfiguracao('chave_sms');

            $curl = curl_init();

            //10834952

            // var_dump('https://sistema81.smsbarato.com.br/send?chave=' . $chaveSMS . '&dest=' . $numeroTelefone . '&text=' . substr($stringMensagem, 0, 160));
            // die;

            curl_setopt_array($curl, [
                CURLOPT_URL => getConfiguracao('chave_url'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "",
                CURLOPT_HTTPHEADER => [
                  "Content-Type: application/json",
                  "X-API-TOKEN: ".$chaveSMS
                ],
                CURLOPT_POSTFIELDS =>'{
                    "from": "'.getConfiguracao('chave_identificacao').'",
                    "to": "'.$numeroTelefone.'",
                    "contents": [
                        {
                            "type": "text",                            
                            "text": "'.$stringMensagem.'"
                        }
                    ]
                }'
              ]);

            $response = curl_exec($curl);
            $erros = curl_error($curl);

            curl_close($curl);
            
            if(!empty($erros))
            {
                throw new Exception($erros);
            }
            if(!$response)
            {
                throw new Exception('Não foi possível enviar a mensagem SMS para o número informado ('.$numeroTelefone.').');
            }
            var_dump($response);die;
            $resposta = json_decode($response);
            if(isset($resposta->errors))
            {
                throw new Exception($resposta->errors->mensagem);
            }
            var_dump($resposta);die;
        }
        catch(Exception $e)
        {
            return array('controle'=>false, 'resposta'=>$e->getMessage());
        }
    }

}

?>
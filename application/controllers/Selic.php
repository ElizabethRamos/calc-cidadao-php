<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Selic extends CI_Controller {

  public function index()
  {
    $dataInicial = $this->input->post('dataInicial');
    $dataFinal = $this->input->post('dataFinal');
    $valorCorrecao = $this->input->post('valorCorrecao');

    $valorCorrigido = $this->_get_valor_corrigido($dataInicial, $dataFinal, $valorCorrecao);

    $response = array('dataInicial' => $dataInicial,
                      'dataFinal'=> $dataFinal,
                      'valorCorrecao' => $valorCorrecao,
                      'valorCorrigido' => $valorCorrigido);
    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
	}

  private function _get_valor_corrigido($dataInicial, $dataFinal, $valorCorrecao)
  {
    //Chama endpoint do Bacen
    $url = 'https://www3.bcb.gov.br/CALCIDADAO/publico/corrigirPelaSelic.do?method=corrigirPelaSelic';
    $values = array('dataInicial' => $dataInicial,
                      'dataFinal'=> $dataFinal,
                      'valorCorrecao' => $valorCorrecao);

    // https://stackoverflow.com/questions/5647461/how-do-i-send-a-post-request-with-php
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($values)
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { var_dump($result); }

    $valorCorrigido = $this->_parse_bacen_response($result);
    return $valorCorrigido;
  }

  private function _parse_bacen_response($html)
  {
    $doc = new DOMDocument();
    libxml_use_internal_errors(true);
    $doc->loadHTML($html);

    $xpath = new DOMXpath($doc);
    $path = '//form/div[2]/table/tbody/tr[8]/td[2]';

    $valorCorrigido = $xpath->query($path)->item(0)->nodeValue;
    return $valorCorrigido;
  }

}

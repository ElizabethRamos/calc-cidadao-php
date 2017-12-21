<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Selic extends CI_Controller {

  public function index()
  {
    $dataInicial = "30/09/2015";
    $dataFinal = "30/09/2016";
    $valorCorrecao = "2000,00";

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
    return "R$ 2000,00";

  }

}

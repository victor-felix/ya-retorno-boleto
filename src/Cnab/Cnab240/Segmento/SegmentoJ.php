<?php

namespace Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Segmento;

use Stringy\Stringy;
use Umbrella\Ya\RetornoBoleto\Cnab\Cnab240\Detail;
use Umbrella\Ya\RetornoBoleto\Model\Banco;
use Umbrella\Ya\RetornoBoleto\Model\Cedente;

class SegmentoJ extends AbstractSegmento
{

    public function buildDetail(Stringy $linha)
    {
        $detail = new Detail();
        $cedente = new Cedente();
        $banco = new Banco();

        $banco->setCod($linha->substr(1, 3));

        $detail
            ->setLote($linha->substr(4, 4))
            ->setRegistro($linha->substr(8, 1))
            ->setNumRegistroLote($linha->substr(9, 5))
            ->setSegmento($linha->substr(14, 1))
            ->setTipoMovimento($linha->substr(15, 1))
            ->setCodMovimento($linha->substr(16, 2))
            ->setCodBarras($linha->substr(18, 44))
            ->setDataVencimento($this->createDate($linha->substr(92, 8)))
            ->setValorTitulo($this->convertToFloat($linha->substr(100, 15)))
            ->setDesconto($this->convertToFloat($linha->substr(115, 15)))
            ->setAcrescimos($this->convertToFloat($linha->substr(130, 15)))
            ->setDataPagamento($this->createDate($linha->substr(145, 8)))
            ->setValorPagamento($this->convertToFloat($linha->substr(153, 15)))
            ->setQuantidadeMoeda($this->convertToFloat($linha->substr(168, 15), 5))
            ->setReferenciaSacado($linha->substr(183, 20))
            ->setNossoNumero($linha->substr(203, 20))
            ->setCodMoeda($linha->substr(223, 2))
            ->addCnab($linha->substr(225, 6))
            ->addOcorrencia($linha->substr(231, 10));


        $cedente
            ->setNome($linha->substr(62, 30))
            ->setBanco($banco);

        $detail
            ->setCedente($cedente);

        return $detail;
    }
}

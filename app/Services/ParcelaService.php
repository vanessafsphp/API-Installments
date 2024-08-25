<?php

namespace App\Services;

use App\Models\Carne;
use App\Models\Parcela;

class ParcelaService
{
    public function gerarParcelas(Carne $carne): array
    {
        $valorEntrada = $carne->valor_entrada ?? 0;
        $valorParcela = $this->calcularParcela($carne->valor_total, $carne->qtd_parcelas, $valorEntrada);
        $parcelas = [];
        $somaParcelas = 0;
        $dataVencimento = new \DateTime($carne->data_primeiro_vencimento);

        for ($i = 1; $i <= $carne->qtd_parcelas; $i++) {
            $entrada = ($valorEntrada > 0 && $i === 1) ?? false;
            $valor = $entrada ? $valorEntrada : $valorParcela;
            $somaParcelas += $valor;

            $parcelas[] = Parcela::create([
                'carne_id' => $carne->id,
                'valor' => $valor,
                'data_vencimento' => $dataVencimento->format('Y-m-d'),
                'numero' => $i,
                'entrada' => $entrada,
            ]);

            $this->calculatarProximaDataVencimento($dataVencimento, $carne->periodicidade);
        }

        $parcelas = $this->corrigirDiferencaValorParcela($parcelas, $carne->valor_total, $somaParcelas);

        return $this->formatarDadosParcela($parcelas);
    }

    public function calcularParcela(float $totalCarne, int $qtdParcelas, float $valorEntrada): float
    {
        $valorTotal = $totalCarne - $valorEntrada;
        $qtdParcelasRestantes = $valorEntrada > 0 ? $qtdParcelas - 1 : $qtdParcelas;
        $valorParcela = $qtdParcelasRestantes > 0 ? $valorTotal / $qtdParcelasRestantes : 0;
        return number_format($valorParcela, 2, '.', '');
    }

    private function calculatarProximaDataVencimento(\DateTime $dataVencimento, string $periodicidade): void
    {
        $interval = $periodicidade === 'mensal' ? 'P1M' : 'P1W';
        $dataVencimento->add(new \DateInterval($interval));
    }

    private function corrigirDiferencaValorParcela(array $parcelas, float $valorTotal, float $somaParcelas): array
    {
        $diferenca = $valorTotal - $somaParcelas;

        if ($diferenca > 0.001) {
            $ultimaParcela = count($parcelas) - 1; // Pegar índice da última parcela
            $valorAtualizadoUltimaParcela = $parcelas[$ultimaParcela]->valor + $diferenca;
            $parcelas[$ultimaParcela]->valor = number_format($valorAtualizadoUltimaParcela, 2, '.', '');
            $parcelas[$ultimaParcela]->save();
        }

        return $parcelas;
    }

    public function formatarDadosParcela(array $parcelas): array
    {
        return array_map(function ($parcela) {
            return [
                'data_vencimento' => $parcela['data_vencimento'],
                'valor' => number_format($parcela['valor'], 2, '.', ''),
                'numero' => $parcela['numero'],
                'entrada' => $parcela['entrada'] ? true : false
            ];
        }, $parcelas);
    }
}

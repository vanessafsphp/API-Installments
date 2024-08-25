<?php

namespace App\Http\Controllers;

use App\Models\Carne;
use Illuminate\Http\Request;
use App\Services\ParcelaService;
use Illuminate\Http\JsonResponse;

class CarneController extends Controller
{
    protected $parcelaService;

    public function __construct(ParcelaService $parcelService)
    {
        $this->parcelaService = $parcelService;
    }

    public function store(Request $request): JsonResponse
    {
        $validado = $this->validarDados($request);

        $carne = Carne::create($validado);

        $parcelas = $this->parcelaService->gerarParcelas($carne);

        return response()->json([
            'total' => number_format($carne->valor_total, 2, '.', ''),
            'valor_entrada' => number_format(($carne->valor_entrada ?? 0.00), 2, '.', ''),
            'parcelas' => $parcelas
        ], 201);
    }

    private function validarDados(Request $request): array
    {
        return $request->validate([
            'valor_total' => 'required|numeric',
            'qtd_parcelas' => 'required|integer',
            'data_primeiro_vencimento' => 'required|date',
            'periodicidade' => 'required|in:mensal,semanal',
            'valor_entrada' => 'nullable|numeric',
        ]);
    }
}

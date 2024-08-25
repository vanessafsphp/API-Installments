<?php

namespace App\Http\Controllers;

use App\Models\Carne;
use App\Models\Parcela;
use App\Services\ParcelaService;
use Illuminate\Http\JsonResponse;

class ParcelaController extends Controller
{
    protected $parcelaService;

    public function __construct(ParcelaService $parcelService)
    {
        $this->parcelaService = $parcelService;
    }

    public function buscarParcelas(string $idCarne): JsonResponse
    {
        $carne = Carne::findOrFail($idCarne);

        if (!$carne) {
            return response()->json(['message' => 'Carne não encontrado'], 404);
        }

        $parcelas = Parcela::where('carne_id', $idCarne)->get();

        $parcelasFormatadas = $this->parcelaService->formatarDadosParcela($parcelas->toArray());

        return response()->json(["parcelas" => $parcelasFormatadas], 200);
    }
}

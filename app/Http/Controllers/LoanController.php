<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\JsonResponse;

class LoanController extends Controller
{
    public function history(): JsonResponse
    {
        $loans = Loan::with('book')->get()->map(function ($loan) {
            return [
                'id'                 => $loan->id,
                'nombre_solicitante' => $loan->nombre_solicitante,
                'fecha_prestamo'     => $loan->fecha_prestamo,
                'fecha_devolucion'   => $loan->fecha_devolucion,
                'estado_prestamo'    => is_null($loan->fecha_devolucion) ? 'Activo' : 'Devuelto',
                'libro'              => [
                    'id'     => $loan->book->id,
                    'titulo' => $loan->book->titulo,
                    'isbn'   => $loan->book->isbn,
                ],
            ];
        });

        return response()->json(['data' => $loans], 200);
    }
}
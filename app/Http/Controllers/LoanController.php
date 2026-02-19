<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Http\Requests\StoreLoanRequest;
use Illuminate\Http\JsonResponse;

class LoanController extends Controller
{
    public function store(StoreLoanRequest $request): JsonResponse
    {
        $book = Book::findOrFail($request->book_id);

        if ($book->copias_disponibles <= 0) {
            return response()->json([
                'message' => 'No hay existencias disponibles para este libro.'
            ], 422);
        }

        $loan = Loan::create([
            'nombre_solicitante' => $request->nombre_solicitante,
            'fecha_prestamo'     => now(),
            'book_id'            => $book->id,
        ]);

        // Reducir copias disponibles
        $book->decrement('copias_disponibles');

        // Si llegan a 0, estado pasa a false (no disponible)
        if ($book->copias_disponibles === 0) {
            $book->update(['estado' => false]); // ← corregido
        }

        return response()->json([
            'message' => 'Préstamo registrado exitosamente.',
            'data'    => $loan->load('book')
        ], 201);
    }

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
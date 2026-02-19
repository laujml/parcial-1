<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // 10 clásicos desde el CSV
        $csvPath = database_path('data/books_classics.csv');
        $lines = array_filter(explode("\n", File::get($csvPath)));
        array_shift($lines);

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            [$titulo, $descripcion, $isbn, $copiasTotales, $copiasDisponibles, $estado]
                = str_getcsv($line);

            Book::create([
                'titulo'             => $titulo,
                'descripcion'        => $descripcion,
                'isbn'               => $isbn,
                'copias_totales'     => (int) $copiasTotales,
                'copias_disponibles' => (int) $copiasDisponibles,
                'estado'             => (bool) $estado,
            ]);
        }

        // 90 libros automáticos
        Book::factory()->count(90)->create();
    }
}
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        $copiasTotales = $this->faker->numberBetween(1, 10);
        $copiasDisponibles = $this->faker->numberBetween(0, $copiasTotales);

        return [
            'titulo'             => $this->faker->sentence(3),
            'descripcion'        => $this->faker->paragraph(2),
            'isbn'               => $this->faker->unique()->isbn13(),
            'copias_totales'     => $copiasTotales,
            'copias_disponibles' => $copiasDisponibles,
            'estado'             => $copiasDisponibles > 0,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\InformationRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InformationRequestFactory extends Factory
{
    protected $model = InformationRequest::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement([
            InformationRequest::STATUS_PENDING,
            InformationRequest::STATUS_ANSWERED,
            InformationRequest::STATUS_CLOSED,
        ]);

        $isAnswered = $status !== InformationRequest::STATUS_PENDING;

        return [
            'user_id'      => User::factory(),
            'subject'      => $this->faker->randomElement([
                'Jam operasional hari libur',
                'Apakah tersedia area parkir bus?',
                'Harga tiket rombongan',
                'Fasilitas penyewaan ban pelampung',
                'Apakah boleh membawa makanan dari luar?',
            ]),
            'message'      => $this->faker->paragraph(3),
            'response'     => $isAnswered ? $this->faker->paragraph(2) : null,
            'status'       => $status,
            'responded_at' => $isAnswered ? $this->faker->dateTimeBetween('-1 month', 'now') : null,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\ProfessorInvitationToken;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ProfessorInvitationToken>
 */
class ProfessorInvitationTokenFactory extends Factory
{
    protected $model = ProfessorInvitationToken::class;

    public function definition(): array
    {
        return [
            'token' => Str::random(32),
            'note' => $this->faker->optional()->sentence(3),
            'expires_at' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'used_at' => null,
            'used_by' => null,
        ];
    }
}

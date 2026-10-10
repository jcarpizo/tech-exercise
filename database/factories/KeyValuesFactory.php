<?php declare(strict_types = 1);

namespace Database\Factories;

use App\Models\KeyValues;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KeyValues>
 */
class KeyValuesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key_name'  => $this->faker->name(),
            'key_value' => $this->faker->name(),
            'timestamp_reference' => $this->faker->dateTime()->getTimestamp(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hospitals>
 */
class HospitalsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'address' => $this->faker->address,
            'body' => $this->faker->paragraphs(3, true),
            'info' => $this->faker->sentence,
            'cover_image' => $this->faker->imageUrl(),
            'user_id' => function() {
                return \App\Models\User::factory()->create()->id;
            },
        ];
        
    }
}

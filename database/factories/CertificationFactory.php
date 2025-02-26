<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Certification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certification>
 */
class CertificationFactory extends Factory
{
    protected $model = Certification::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->word() . ' Certification',
            'url' => $this->faker->url(),
            'description' => $this->faker->sentence(),
        ];
    }
}

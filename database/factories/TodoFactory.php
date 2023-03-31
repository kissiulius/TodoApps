<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        #디비구조
        #할일:
        #제목 : string required
        #내용 : longtext optional
        #마감기한 : date optional
        #완료여부 : boolean default false
        return [
            'title' => $this->faker->text(15),
            'content' => $this->faker->text(100),
        ];
    }
}

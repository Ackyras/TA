<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RequestAttachment>
 */
class RequestAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'name'  =>  $this->faker->word(),
            'url'   =>  'https://drive.google.com/drive/folders/1QMxiRpL12wbQZtiejqcLUolgYOVOSSB_'
        ];
    }
}

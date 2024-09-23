<?php

namespace Database\Factories;

use App\Models\Task; // Ensure this import is present
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'due_date' => $this->faker->date,
            'assigned_user' => \App\Models\User::factory(), // Assuming you have a User factory
        ];
    }
}

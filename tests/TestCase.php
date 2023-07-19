<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory as Faker;
use App\Models\{Player,Item};

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
    }
    
    public function getAttackTypeRandom()
    {
        return $this->faker->randomElement(['melee', 'ranged']);
    }

    public function createUserFaker()
    {
        return Player::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'type' => $this->faker->randomElement(['human', 'zombie']),
            'health' => 100
        ]);
    }

    public function createItemFaker()
    {
        return Item::create([
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(['weapon', 'armor', 'boot']),
            'defense_points' => $this->faker->numberBetween(0, 10),
            'attack_points' => $this->faker->numberBetween(0, 10)
        ]);
    }
}

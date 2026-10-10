<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\KeyValueTrait;

class KeyValueApiTest extends TestCase
{
    use RefreshDatabase;
    use KeyValueTrait;

    public function test_to_create_key_and_return_a_value(): void
    {
        $this->createFirstKeyValue();
        $request = ['4bb6b591' => '4bb6b591',];
        $response = $this->postJson(route('store_key_value'), $request);

        $response->assertCreated()->assertJsonStructure(['message', 'timestamp'])->assertStatus(201);

        $this->assertDatabaseHas('key_values', [
            'key_name' => '4bb6b591',
            'key_value' => '4bb6b591',
        ]);
    }

    public function test_to_get_key_value(): void
    {
        $this->createFirstKeyValue();

        $response = $this->get(
            route('get_key_value', [
                'key_name' => '4bb6b59',
            ])
        );

        $response->assertOk()->assertJsonPath('value', '4bb6b59');
    }

    public function test_to_get_key_value_with_timestamp(): void
    {
        $this->createKeyValueWithTimestamp();

//        $response = $this->withHeaders([
//            'xsecret' => '123456',
//        ])->get(
//            route('get_key_value', [
//                'key_name' => '4930943',
//            ]) . '?timestamp=1649577800'
//        );

        $response = $this->get(
            route('get_key_value', [
                'key_name' => '4930943',
            ]) . '?timestamp=1649577800'
        );

        $response->assertOk()->assertJsonPath('value', '4930943');
    }

    public function test_to_get_all_key_values(): void
    {
        $this->createKeyValuesRecords();

        $response = $this->get(
            route('get_key_value', [
                'key_name' => 'get_all_records',
            ])
        );

        $response->assertOk()->assertJsonStructure([]);
        $this->assertJson($response->getContent());
        $this->assertNotEmpty($response->json());
    }

    public function test_to_get_key_value_with_wrong_timestamp(): void
    {
        $this->createKeyValueWithTimestamp();

        $response = $this->get(
            route('get_key_value', [
                'key_name' => '4930943',
            ]) . '?timestamp=2312123'
        );

        $response->assertNotFound()
            ->assertJson([
                'error_message' => 'Key not found.',
            ]);
    }

    public function test_to_create_key_value_with_no_parameter(): void
    {
        $response = $this->postJson(
            route('store_key_value'),
            []
        );

        $response->assertStatus(422)
            ->assertJson([
                'message' => 'Exactly one key-value pair is required.',
                'errors' => [
                    'payload' => [
                        'Exactly one key-value pair is required.',
                    ],
                ],
            ]);
    }

    public function test_to_create_key_with_empty_value(): void
    {
        $response = $this->postJson(
            route('store_key_value'),
            ['4bb6b591' => '']
        );

        $response->assertUnprocessable()->assertJsonValidationErrors(['payload']);
    }
}

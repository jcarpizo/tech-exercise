<?php

namespace Tests\Traits;

use App\Models\KeyValues;

trait KeyValueTrait
{
    public function createFirstKeyValue(): KeyValues
    {
        return KeyValues::factory()->create(['key_name' => '4bb6b59', 'key_value' => '4bb6b59']);
    }

    public function createSecondKeyValue(): KeyValues
    {
        return KeyValues::factory()->create(['key_name' => '123456', 'key_value' => '123456']);
    }

    public function createKeyValueWithTimestamp(): KeyValues
    {
        return KeyValues::factory()->create([
            'key_name' => '4930943',
            'key_value' => '4930943',
            'timestamp_reference' => '1649577800'
        ]);
    }

    public function createKeyValuesRecords()
    {
        KeyValues::factory()->create();
        return KeyValues::factory()->count(10)->make();
    }
}

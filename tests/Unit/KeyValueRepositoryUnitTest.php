<?php

namespace Tests\Unit;

use App\Services\KeyValue\KeyValueRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\KeyValueTrait;

class KeyValueRepositoryUnitTest extends TestCase
{
    use RefreshDatabase;
    use KeyValueTrait;

    private KeyValueRepository $keyValueRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->keyValueRepository = new KeyValueRepository();
    }

    public function test_is_store_first_key_value(): void
    {
        $this->createFirstKeyValue();
        $keyValue = $this->keyValueRepository->storeKeyValue('4bb6b59','4bb6b59');
        $this->assertSame('4bb6b59', $keyValue->key_name);
        $this->assertSame('4bb6b59', $keyValue->key_value);
    }

    public function test_to_get_first_key_value(): void
    {
        $this->createFirstKeyValue();
        $keyValue = $this->keyValueRepository->getKeyValue('4bb6b59');
        $this->assertSame('4bb6b59', $keyValue->key_name);
        $this->assertSame('4bb6b59', $keyValue->key_value);
    }

    public function test_is_store_second_key_value(): void
    {
        $this->createSecondKeyValue();
        $keyValue = $this->keyValueRepository->storeKeyValue('123456', '123456');
        $this->assertSame('123456', $keyValue->key_name);
        $this->assertSame('123456', $keyValue->key_value);
    }

    public function test_to_get_second_key_value(): void
    {
        $this->createSecondKeyValue();
        $keyValue = $this->keyValueRepository->getKeyValue('123456');
        $this->assertSame('123456', $keyValue->key_name);
        $this->assertSame('123456', $keyValue->key_value);
    }

    public function test_to_get_latest_key_value_with_timestamp(): void
    {
        $this->createKeyValueWithTimestamp();
        $keyValue = $this->keyValueRepository->getKeyValue('4930943', '1649577800');
        $this->assertSame('4930943', $keyValue->key_name);
        $this->assertSame('4930943', $keyValue->key_value);
        $this->assertSame(1649577800, $keyValue->timestamp_reference);
    }

    public function test_to_get_all_records(): void
    {
        $this->createKeyValuesRecords();
        $keyValues = $this->keyValueRepository->getAllKeyValues();
        $this->assertNotEmpty($keyValues);
    }

    public function test_with_no_key_values(): void
    {
        $keyValue = $this->keyValueRepository->getKeyValue('');
        $this->assertEmpty($keyValue);
    }

    public function test_to_get_key_values_with_no_records(): void
    {
        $keyValues = $this->keyValueRepository->getAllKeyValues();
        $this->assertEmpty($keyValues);
    }
}

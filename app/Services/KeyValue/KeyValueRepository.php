<?php declare(strict_types = 1);

namespace App\Services\KeyValue;

use App\Models\KeyValues;
use Illuminate\Database\Eloquent\Collection;

class KeyValueRepository implements KeyValueInterface
{
    /**
     * @param string $keyName
     * @param string $keyValue
     * @return KeyValues
     */
    public function storeKeyValue(string $keyName, string $keyValue): KeyValues
    {
        return KeyValues::create(
            [
                'key_name'            => $keyName,
                'key_value'           => $keyValue,
                'timestamp_reference' => now('UTC')->timestamp,
            ]
        );
    }

    /**
     * @param string $keyName
     * @param string $timestamp
     * @return KeyValues|null
     */
    public function getKeyValue(string $keyName, string $timestamp = ''): ?KeyValues
    {
        $keyValue = KeyValues::where('key_name', $keyName)->latest('id');
        if (!empty($timestamp)) {
            $keyValue->where('timestamp_reference', $timestamp);
        }
        return $keyValue->first();
    }

    public function getAllKeyValues(): Collection
    {
        return KeyValues::all();
    }
}

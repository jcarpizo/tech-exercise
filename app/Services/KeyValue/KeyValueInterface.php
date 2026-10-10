<?php declare(strict_types = 1);

namespace App\Services\KeyValue;

use App\Models\KeyValues;
use Illuminate\Database\Eloquent\Collection;

interface KeyValueInterface
{
    /**
     * @param string $keyName
     * @param string $keyValue
     * @return KeyValues
     */
    public function storeKeyValue(string $keyName, string $keyValue): KeyValues;

    /**
     * @param string $keyName
     * @param string $timestamp
     * @return KeyValues|null
     */
    public function getKeyValue(string $keyName, string $timestamp = ''): ?KeyValues;

    /**
     * @return Collection
     */
    public function getAllKeyValues(): Collection;
}

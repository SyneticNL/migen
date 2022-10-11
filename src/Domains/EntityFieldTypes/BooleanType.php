<?php

declare(strict_types=1);

namespace Synetic\Migator\Domains\EntityFieldTypes;

use Synetic\Migator\Domains\EntityTypeInterface;

class BooleanType implements EntityTypeInterface
{
    public function toMigrationString(string $column): string
    {
        return sprintf('$table->boolean(\'%s\')', $column);
    }
}

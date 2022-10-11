<?php

declare(strict_types=1);

namespace Synetic\Migator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Synetic\Migator\Domains\Entity;
use Synetic\Migator\Domains\EntityField;
use Synetic\Migator\Domains\EntityFieldTypes\BooleanType;
use Synetic\Migator\Domains\EntityFieldTypes\DateTimeType;
use Synetic\Migator\Domains\EntityFieldTypes\DateType;
use Synetic\Migator\Domains\EntityFieldTypes\IdType;
use Synetic\Migator\Domains\EntityFieldTypes\IntegerType;
use Synetic\Migator\Domains\EntityFieldTypes\JsonType;
use Synetic\Migator\Domains\EntityFieldTypes\StringType;
use Synetic\Migator\Domains\EntityFieldTypes\TextType;
use Synetic\Migator\Domains\EntityFieldTypes\UuidType;
use Synetic\Migator\Service\Migration;

class CreateCommand extends Command
{
    protected $signature = 'migator:create {model? : The model your going to generate a migration for}';

    protected $description = 'Create entity';

    public function handle(): int
    {
        $entities = collect();
        do {
            $entities->push($this->handleEntity(new Entity($this->argument('model') ?? $this->ask('Model'))));
        } while ($this->confirm('Would you like to work on another entity?'));

        $success = (new Migration())->create($entities);
        if ($success) {
            $this->info('Migration created');

            return self::SUCCESS;
        }
        $this->error('Arnold wasnt able to generate your migration. Get to the choppa!');

        return self::FAILURE;
    }

    private function handleEntity(Entity $model): Entity
    {
        $existMessage = $model->exists() ? 'Entity already exists' : 'Entity does not exist yet';
        $this->info($existMessage);

        $this->info('Lets configure fields for '.$model->tableName.'!');

        do {
            $fieldName = $this->ask('Field name');

            if ($model->columnExists($fieldName)) {
                $this->warn('This field already exists.');

                continue;
            }

            $fieldTypeName = $this->choice('Field types', $this->getFieldTypes()->keys()->toArray());
            $fieldType = new ($this->getFieldTypes()->get($fieldTypeName))();
            $model->addEntityField(new EntityField($fieldName, $fieldType));
        } while ($this->confirm('Would you like to add another field?'));

        $this->info('The following fields will be created for '.$model->tableName);
        $this->table(
            ['name', 'type'],
            $model->fields->map(function ($field) {
                return [$field->fieldName, class_basename($field->entityType)];
            })
        );

        if (! $this->confirm('Build entity?')) {
            $this->warn('Cancelled entity build');
        }

        return $model;
    }

    private function getFieldTypes(): Collection
    {
        // TODO: Automatically find all the different field types
        return collect([
            'id' => IdType::class,
            'string' => StringType::class,
            'integer' => IntegerType::class,
            'date-time' => DateTimeType::class,
            'text' => TextType::class,
            'boolean' => BooleanType::class,
            'date' => DateType::class,
            'json' => JsonType::class,
            'uuid' => UuidType::class,
        ]);
    }
}

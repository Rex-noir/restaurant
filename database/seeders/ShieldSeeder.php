<?php

namespace Database\Seeders;

use File;
use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionPrefixes = config('filament-shield.permission_prefixes.resource');

        $models = $this->getModels();

        $rolesWithPermissions = '[{"name":"admin","guard_name":"web","permissions":[]}]';
        $directPermissions = [];

        foreach ($models as $model) {
            foreach ($permissionPrefixes as $permissionPrefix) {
                $directPermissions[] = "{$permissionPrefix}_{$model}";
            }
        }

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        // $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var \Illuminate\Database\Eloquent\Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var \Illuminate\Database\Eloquent\Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    /**
     * Scan app/Models directory and get model names
     */
    protected function getModels(): array
    {
        $modelsPath = app_path('Models');
        $models = [];

        if (File::exists($modelsPath)) {
            foreach (File::files($modelsPath) as $file) {
                $model = pathinfo($file->getFilename(), PATHINFO_FILENAME);
                // $this->command->info("Found model: {$model}");
                $models[] = strtolower($model); // Convert to lowercase for consistency
            }
        }

        // $this->command->info('Found ' . count($models) . ' models.');

        return $models;
    }


    /**
     * Create direct permissions
     */
    protected function makeDirectPermissions(array $permissions): void
    {
        if (!empty($permissions)) {
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission,
                        'guard_name' => 'web',
                    ]);
                }
            }
        }
    }
}

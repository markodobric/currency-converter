<?php declare(strict_types=1);

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function find($id): ?Model;

     public function findOrFail($id): Model;

    public function all(): Collection;

    public function create(array $data): Model;

    public function createMany(array $data): bool;

    public function update(array $data, $id): bool;

    public function updateOrCreate(array $attributes, array $data): Model;

    public function delete($id): int;
}

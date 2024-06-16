<?php

namespace Modules\Core\Repositories;

use Illuminate\Support\Arr;
use Modules\Core\Models\Position;
use Modules\Account\Models\User;

trait OrganizationPositionRepository
{
    /**
     * Define the form keys for resource
     */
    private $keys = [
        'kd', 'name', 'description', 'level', 'dept_id', 'is_visible'
    ];

    /**
     * Store newly created resource.
     */
    public function storeCompanyPosition(array $data, User $user)
    {
        $position = new Position(Arr::only($data, $this->keys));
        if ($position->save()) {
            if (isset($data['children'])) {
                $position->parents()->sync($data['parents']);
            }
            if (isset($data['children'])) {
                $position->children()->sync($data['children']);
            }
            $user->log('membuat jabatan baru dengan nama ' . $position->name . ' <strong>[ID: ' . $position->id . ']</strong>', Position::class, $position->id);
            return $position;
        }
        return false;
    }

    /**
     * Update the current resource.
     */
    public function updateCompanyPosition(Position $position, array $data, User $user)
    {
        $position = $position->fill(Arr::only($data, $this->keys));
        if ($position->save()) {
            $position->parents()->sync($data['parents'] ?? []);
            $position->children()->sync($data['children'] ?? []);

            $user->log('memperbarui jabatan ' . $position->name . ' <strong>[ID: ' . $position->id . ']</strong>', Position::class, $position->id);
            return $position;
        }
        return false;
    }

    /**
     * Remove the current resource.
     */
    public function destroyCompanyPosition(Position $position, User $user)
    {
        if (!$position->trashed() && $position->delete()) {
            $user->log('menghapus jabatan ' . $position->name . ' <strong>[ID: ' . $position->id . ']</strong>', Position::class, $position->id);
            return $position;
        }
        return false;
    }

    /**
     * Restore the current resource.
     */
    public function restoreCompanyPosition(Position $position, User $user)
    {
        if ($position->trashed() && $position->restore()) {
            $user->log('memulihkan jabatan ' . $position->name . ' <strong>[ID: ' . $position->id . ']</strong>', Position::class, $position->id);
            return $position;
        }
        return false;
    }
}

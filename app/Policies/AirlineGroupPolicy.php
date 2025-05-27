<?php

namespace App\Policies;

use App\Models\AirlineGroup;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AirlineGroupPolicy {
    public function airlineGroups(User $user): bool {
        $permissions = $user->permissions();
        return in_array('airlineGroups', $permissions);
    }

    public function allAirlineGroups(User $user): bool {
        $permissions = $user->permissions();
        return in_array('all-airline-groups', $permissions);
    }

    public function inactiveAirlineGroups(User $user): bool {
        $permissions = $user->permissions();
        return in_array('inactive-airline-groups', $permissions);
    }

    public function addAirlineGroups(User $user): bool {
        $permissions = $user->permissions();
        return in_array('add-airline-groups', $permissions);
    }

    public function edit(User $user, AirlineGroup $airlineGroup): bool {
        $permissions = $user->permissions();
        return in_array('edit-airline-groups', $permissions);
    }

    public function update(User $user, AirlineGroup $airlineGroup): bool {
        $permissions = $user->permissions();
        return in_array('edit-airline-groups', $permissions);
    }

    public function delete(User $user, AirlineGroup $airlineGroup): bool {
        $permissions = $user->permissions();
        return in_array('delete-airline-groups', $permissions);
    }


}

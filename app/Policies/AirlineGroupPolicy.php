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

    // All Airline Groups
    public function editAllAirlineGroups(User $user): bool {
        $permissions = $user->permissions();
        return in_array('edit-all-airline-groups', $permissions);
    }
    public function statusAllAirlineGroups(User $user): bool {
        $permissions = $user->permissions();
        return in_array('status-all-airline-groups', $permissions);
    }
    public function deleteAllAirlineGroups(User $user): bool {
        $permissions = $user->permissions();
        return in_array('delete-all-airline-groups', $permissions);
    }

    // Inactive Airline Groups
    public function editInactiveAirlineGroups(User $user): bool {
        $permissions = $user->permissions();
        return in_array('edit-inactive-airline-groups', $permissions);
    }
    public function statusInactiveAirlineGroups(User $user): bool {
        $permissions = $user->permissions();
        return in_array('status-inactive-airline-groups', $permissions);
    }
    public function deleteInactiveAirlineGroups(User $user): bool {
        $permissions = $user->permissions();
        return in_array('delete-inactive-airline-groups', $permissions);
    }

    // Flown Airline Groups
    public function flownAirlineGroups(User $user): bool {
        $permissions = $user->permissions();
        return in_array('flown-airline-groups', $permissions);
    }

    public function editFlownAirlineGroups(User $user): bool {
        $permissions = $user->permissions();
        return in_array('edit-flown-airline-groups', $permissions);
    }
    public function statusFlownAirlineGroups(User $user): bool {
        $permissions = $user->permissions();
        return in_array('status-flown-airline-groups', $permissions);
    }
    public function deleteFlownAirlineGroups(User $user): bool {
        $permissions = $user->permissions();
        return in_array('delete-flown-airline-groups', $permissions);
    }
}

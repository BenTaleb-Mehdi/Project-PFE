<?php

namespace App\Services;

use App\Models\Specialty;

class SpecialtyService
{
    public function getAllSpecialties()
    {
        return Specialty::orderBy('name')->get();
    }

    public function addSpecialty(string $name)
    {
        return Specialty::create(['name' => $name]);
    }

    public function updateSpecialty(int $id, string $name)
    {
        $specialty = Specialty::findOrFail($id);
        return $specialty->update(['name' => $name]);
    }

    public function deleteSpecialty(int $id)
    {
        $specialty = Specialty::findOrFail($id);
        return $specialty->delete();
    }
}

<?php

namespace App\Repositories\Person;

use App\Models\Person;

class PersonRepo
{
    /**
     * NIC Unique Validation
     */
    public static function nicUnique($request)
    {
        // Returns true if NIC is unique, false if it already exists
        $query = Person::where('national_id', $request->national_id);
        // If updating, exclude current record by id (but only if id is not 0/null/empty)
        if (!empty($request->id) && $request->id != 0 && $request->id !== '0') {
            $query->where('id', '!=', $request->id);
        }
        return !$query->exists(); // true if unique, false if exists


    }

    /**
     * Store a newly created resource in storage.
     */
    public static function store($person)
    {
        try {
            $person->save();
            // Get all persons with relationships for table
            $allPersons = Person::with(['gender', 'religion'])->orderByDesc('id')->paginate(5);
            return [
                'status' => true,
                'message' => 'Person saved successfully!',
                'data' => $allPersons
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => 'Person save failed!'
            ];
        }
    }

    /**
     * Update an existing person by id
     */
    public static function updateById($id, $data)
    {
        try {
            $person = Person::findOrFail($id);
            $person->fill($data);
            $person->save();
            // Get all persons with relationships for table
            $allPersons = Person::with(['gender', 'religion'])->orderByDesc('id')->paginate(5);
            return [
                'status' => true,
                'message' => 'Person updated successfully!',
                'data' => $allPersons
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => 'Person update failed!'
            ];
        }
    }

    /**
     * Delete a person by id
     */
    public static function deleteById($id)
    {
        try {
            $person = Person::findOrFail($id);
            $person->delete();
            return [
                'status' => true,
                'message' => 'Person deleted successfully!'
            ];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'message' => 'Person delete failed!'
            ];
        }
    }
}

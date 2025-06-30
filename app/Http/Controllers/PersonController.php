<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Person\PersonRepo;
use App\Http\Requests\Person\CreatePersonRequest;
use App\Models\Person;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genders = \App\Models\Gender::all();
        $religions = \App\Models\Religion::all();

        // Load all persons with relationships for the table
        $persons = Person::with(['gender', 'religion'])->orderByDesc('id')->paginate(5);
        return view('Person.create_person', [
            'genders' => \App\Models\Gender::all(),
            'religions' => \App\Models\Religion::all(),
            'persons' => $persons
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePersonRequest $request)
    {
        try {
            $person = new Person($request->validated());
            $repoResult = PersonRepo::store($person);

            if ($repoResult['status']) {
                // Render all rows as HTML
                $rowsHtml = '';
                foreach ($repoResult['data'] as $p) {
                    $rowsHtml .= view('Person.partials.person_row', ['person' => $p])->render();
                }
                return response()->json([
                    'status' => true,
                    'message' => $repoResult['message'],
                    'rows_html' => $rowsHtml
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => $repoResult['message']
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Person save failed!'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Validate (reuse CreatePersonRequest rules, but allow for update)
        $rules = [
            'id' => 'required|exists:person,id',
            'full_name' => 'required|string|min:2|max:100|regex:/^[A-Za-z .\'-]{2,100}$/',
            'date_of_birth' => 'required|date|before:-18 years',
            'gender_id' => 'required|exists:genders,id',
            'religion_id' => 'required|exists:religions,id',
            'address' => 'required|string|min:5|max:255',
            'contact_number' => 'required|string|regex:/^\+?\d{10,15}$/',
            'email_address' => 'required|email',
        ];

        $validated = $request->validate($rules);

        $repoResult = PersonRepo::updateById($request->id, $validated);

        if ($repoResult['status']) {
            // Render all rows as HTML
            $rowsHtml = '';
            foreach ($repoResult['data'] as $p) {
                $rowsHtml .= view('Person.partials.person_row', ['person' => $p])->render();
            }
            return response()->json([
                'status' => true,
                'message' => $repoResult['message'],
                'rows_html' => $rowsHtml
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => $repoResult['message']
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $result = PersonRepo::deleteById($id);
        return response()->json($result);
    }

    /**
     * NIC Unique Validation
     */
    public function nicUnique(Request $request)
    {
        try {
            $isUnique = PersonRepo::nicUnique($request);
            return response()->json(['unique' => $isUnique]);
        } catch (\Throwable $th) {
            return response()->json(['unique' => false]);
        }
    }
}

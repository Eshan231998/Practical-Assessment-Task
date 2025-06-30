@php
    $user = Auth::user();
    $id = $user?->id;
    $role = $user?->role;
@endphp

<tr>
    <td>{{ $person->full_name }}</td>
    <td>{{ $person->national_id }}</td>
    <td>{{ $person->contact_number }}</td>
    <td>{{ $person->email_address }}</td>
    <td>{{ $person->dob ?? $person->date_of_birth }}</td>
    <td>{{ $person->gender->name ?? '' }}</td>
    <td>{{ $person->religion->name ?? '' }}</td>
    <td>{{ $person->address }}</td>
    <td>
        {{-- Actions: Edit/Delete buttons can be added here --}}
        @if ($role === 'Admin' || $role === 'Data Entry' || $role === 'Viewer')
            <button class="btn btn-sm btn-success view-person-btn" 
                data-id="{{ $person->id }}"
                data-full_name="{{ $person->full_name }}"
                data-national_id="{{ $person->national_id }}"
                data-contact_number="{{ $person->contact_number }}"
                data-email_address="{{ $person->email_address }}"
                data-dob="{{ $person->dob ?? $person->date_of_birth }}"
                data-gender="{{ $person->gender->name ?? '' }}"
                data-religion="{{ $person->religion->name ?? '' }}"
                data-address="{{ $person->address }}"
                >View</button>
        @endif
        @if ($role === 'Admin' || $role === 'Data Entry')
            <button class="btn btn-sm btn-primary edit-person-btn"
                data-id="{{ $person->id }}"
                data-full_name="{{ $person->full_name }}"
                data-national_id="{{ $person->national_id }}"
                data-dob="{{ $person->dob ?? $person->date_of_birth }}"
                data-gender_id="{{ $person->gender_id }}"
                data-religion_id="{{ $person->religion_id }}"
                data-address="{{ $person->address }}"
                data-contact_number="{{ $person->contact_number }}"
                data-email_address="{{ $person->email_address }}"
            >Edit</button>
            <button class="btn btn-sm btn-danger delete-person-btn" data-id="{{ $person->id }}">Delete</button>
        @endif

    </td>
</tr>

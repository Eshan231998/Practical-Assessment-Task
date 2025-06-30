@php
    $user = Auth::user();
    $id = $user?->id;
    $role = $user?->role;
@endphp

@if ($id)
    @if ((Auth::id() == $id && $role === 'Admin') || $role === 'Data Entry' || $role === 'Viewer')
        {{-- HTML Document --}}
        <!doctype html>
        <html lang="en">

        <head>
            @include('Layouts.appStyles')
        </head>

        <body data-sidebar="dark">

            <div id="layout-wrapper">

                {{-- Header --}}
                @include('Layouts.header')

                {{-- Sidebar --}}
                @include('Layouts.sidebar')

                <div class="main-content">
                    <div class="page-content">
                        <div class="container-fluid">

                            {{-- Page Title --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h4 class="mb-sm-0 font-size-18">Persons</h4>
                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item active"></li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Add User Button --}}
                            @if ($role === 'Admin' || $role === 'Data Entry')
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <button class="btn btn-secondary waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#personAddModal">
                                            Add New Person
                                        </button>
                                    </div>
                                </div>
                            @endif


                            {{-- Session Messages --}}
                            @if (session('message'))
                                <div class="col-md-4">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('message') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif

                            {{-- Validation Errors --}}
                            @foreach ($errors->all() as $error)
                                <div class="col-md-4">
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $error }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Users Table --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive"
                                                style="overflow-x:auto; overflow-y:auto; max-height:500px;">
                                                <table id="datatable-buttons"
                                                    class="table table-bordered table-striped table-hover w-100 align-middle"
                                                    style="white-space:nowrap;">
                                                    <thead>
                                                        <tr>
                                                            <th>Full Name</th>
                                                            <th>National ID Number</th>
                                                            <th>Contact Number</th>
                                                            <th>Email Address </th>
                                                            <th>Date of Birth</th>
                                                            <th>Gender</th>
                                                            <th>Religion</th>
                                                            <th>Address</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="persons-table-body">
                                                        @if (isset($persons))
                                                            @foreach ($persons as $person)
                                                                @include('Person.partials.person_row', [
                                                                    'person' => $person,
                                                                ])
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                {{-- Pagination --}}
                                                <div class="d-flex justify-content-center mt-3">
                                                    @if (isset($persons))
                                                        {!! $persons->links('pagination::bootstrap-5') !!}
                                                    @endif
                                                </div>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Footer --}}
                    @include('Layouts.footer')

                </div>
            </div>

            {{-- Right Sidebar --}}
            @include('Layouts.rightSideBar')

            <div class="rightbar-overlay"></div>

            @include('Layouts.appJs')

            <script src="{{ asset('assets/js/persone/persone_common.js') }}"></script>
        </body>

        </html>
    @else
        @include('Layouts.notValidateUser')
    @endif
@else
    @include('Layouts.noUser')
@endif


{{-- Add User Modal --}}
<div id="personAddModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="" enctype="multipart/form-data" id="addUserForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Person</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control form-control-sm" type="text" id="person_id" name="id"
                        value="0" hidden>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="national_id" class="form-label">National ID Number</label>
                            <input type="text" class="form-control" id="national_id" name="national_id" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender_id" required>
                                <option value="" disabled selected>Select Gender</option>
                                @foreach ($genders as $gender)
                                    <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="religion" class="form-label">Religion</label>
                            <select class="form-select" id="religion" name="religion_id" required>
                                <option value="" disabled selected>Select Religion</option>
                                @foreach ($religions as $religion)
                                    <option value="{{ $religion->id }}">{{ $religion->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email_address" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email_address" name="email_address"
                                required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Person Modal -->
<div id="personViewModal" class="modal fade" tabindex="-1" aria-labelledby="personViewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Person Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="view_full_name" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">National ID Number</label>
                        <input type="text" class="form-control" id="view_national_id" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Date of Birth</label>
                        <input type="text" class="form-control" id="view_dob" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gender</label>
                        <input type="text" class="form-control" id="view_gender" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Religion</label>
                        <input type="text" class="form-control" id="view_religion" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" id="view_address" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="view_contact_number" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="text" class="form-control" id="view_email_address" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Person Modal -->
<div id="personEditModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="" method="" enctype="multipart/form-data" id="editUserForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Update Person</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input class="form-control form-control-sm" type="text" id="person_id" name="id"
                        value="" hidden>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="national_id" class="form-label">National ID Number</label>
                            <input type="text" class="form-control" id="national_id" name="national_id" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender_id" required>
                                <option value="" disabled selected>Select Gender</option>
                                @foreach ($genders as $gender)
                                    <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="religion" class="form-label">Religion</label>
                            <select class="form-select" id="religion" name="religion_id" required>
                                <option value="" disabled selected>Select Religion</option>
                                @foreach ($religions as $religion)
                                    <option value="{{ $religion->id }}">{{ $religion->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact_number"
                                required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email_address" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email_address" name="email_address"
                                required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Update</button>
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

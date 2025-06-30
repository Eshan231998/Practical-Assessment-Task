//save person data via AJAX with validation
$(document).ready(function () {
    $('#addUserForm').on('submit', function (e) {
        e.preventDefault(); // Always prevent default form submission!
        let valid = true;
        let errors = [];

        // Helper regex
        const nameRegex = /^[A-Za-z .'-]{2,100}$/;
        const nationalIdRegex = /^[0-9]{9}[vVxX]$|^[0-9]{12}$/; // Sri Lankan NIC or 12 digit
        const contactRegex = /^\+?\d{10,15}$/;
        const emailRegex = /^[\w-.]+@([\w-]+\.)+[\w-]{2,}$/;

        // Get values
        let personId = $('#person_id').val().trim();
        // If personId is empty or not a number, default to 0
        if (!personId || isNaN(personId)) {
            personId = '0';
        }
        const fullName = $('#full_name').val().trim();
        const nationalId = $('#national_id').val().trim();
        const date_of_birth = $('#date_of_birth').val();
        const gender = $('#gender').val();
        const religion = $('#religion').val();
        const address = $('#address').val().trim();
        const contactNumber = $('#contact_number').val().trim();
        const emailAddress = $('#email_address').val().trim();

        // Full Name
        if (!nameRegex.test(fullName)) {
            valid = false;
            errors.push('Full Name must be 2-100 alphabetic characters and may include spaces, dots, hyphens, and apostrophes.');
        }

        // National ID
        if (!nationalIdRegex.test(nationalId)) {
            valid = false;
            errors.push('National ID Number must be valid (e.g., 123456789V or 200012345678).');
        }

        // National ID uniqueness (AJAX, async for validation)
        let nicUniquePromise = $.ajax({
            url: '/check-national-id',
            type: 'POST',
            data: {
                national_id: nationalId,
                id: personId,
                _token: $('input[name="_token"]').val()
            }
        });

        // Date of Birth: must be in the past and age >= 18
        if (!date_of_birth) {
            valid = false;
            errors.push('Date of Birth is required.');
        } else {
            const dobDate = new Date(date_of_birth);
            const today = new Date();
            if (dobDate >= today) {
                valid = false;
                errors.push('Date of Birth must be in the past.');
            } else {
                let age = today.getFullYear() - dobDate.getFullYear();
                const m = today.getMonth() - dobDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) {
                    age--;
                }
                if (age < 18) {
                    valid = false;
                    errors.push('Person must be at least 18 years old.');
                }
            }
        }

        // Gender
        if (!gender) {
            valid = false;
            errors.push('Gender is required.');
        }

        // Religion
        if (!religion) {
            valid = false;
            errors.push('Religion is required.');
        }

        // Address
        if (address.length < 5 || address.length > 255) {
            valid = false;
            errors.push('Address must be 5-255 characters.');
        }

        // Contact Number
        if (!contactRegex.test(contactNumber)) {
            valid = false;
            errors.push('Contact Number must be 10-15 digits and may start with +.');
        }

        // Email Address
        if (!emailRegex.test(emailAddress)) {
            valid = false;
            errors.push('Email Address must be a valid email.');
        }

        // Only proceed to NIC uniqueness check if all other validations pass
        if (!valid) {
            let errorHtml = '<div class="alert alert-danger"><ul>';
            errors.forEach(function (err) {
                errorHtml += '<li>' + err + '</li>';
            });
            errorHtml += '</ul></div>';
            // Remove previous errors
            $('#addUserForm .alert-danger').remove();
            // Show errors at the top of the modal
            $('#addUserForm .modal-body').prepend(errorHtml);
            return false;
        }

        // Now check NIC uniqueness async
        nicUniquePromise.then(function(response) {
            if (!response.unique) {
                let errorHtml = '<div class="alert alert-danger"><ul><li>National ID Number already exists.</li></ul></div>';
                $('#addUserForm .alert-danger').remove();
                $('#addUserForm .modal-body').prepend(errorHtml);
                return;
            }
            // Remove previous errors
            $('#addUserForm .alert-danger').remove();
            // Show page loader
            $('body').append('<div id="page-loader" style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(255,255,255,0.7);z-index:9999;display:flex;align-items:center;justify-content:center;"><div class="spinner-border text-primary" role="status" style="width:4rem;height:4rem;"><span class="visually-hidden">Loading...</span></div></div>');
            // Submit the form via AJAX
            $.ajax({
                url: '/persons',
                type: 'POST',
                data: {
                    full_name: fullName,
                    national_id: nationalId,
                    date_of_birth: date_of_birth,
                    gender_id: gender,
                    religion_id: religion,
                    address: address,
                    contact_number: contactNumber,
                    email_address: emailAddress,
                    _token: $('input[name="_token"]').val()
                },
                dataType: 'json',
                success: function (response) {
                    // Remove loader
                    $('#page-loader').remove();
                    if (response.status) {
                        // Update the table body with all rows
                        $('#persons-table-body').html(response.rows_html);
                        // Hide modal and reset form
                        $('#personAddModal').modal('hide');
                        $('#addUserForm')[0].reset();
                        // Optionally show a success message
                        alert(response.message);
                    } else {
                        let errorHtml = '<div class="alert alert-danger">' + response.message + '</div>';
                        $('#addUserForm .modal-body').prepend(errorHtml);
                    }
                },
                error: function (xhr) {
                    // Remove loader
                    $('#page-loader').remove();
                    let errorHtml = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
                    $('#addUserForm .modal-body').prepend(errorHtml);
                }
            });
        }).catch(function() {
            $('#page-loader').remove();
            let errorHtml = '<div class="alert alert-danger">Could not validate National ID uniqueness.</div>';
            $('#addUserForm .alert-danger').remove();
            $('#addUserForm .modal-body').prepend(errorHtml);
        });
        // Prevent default always, form is handled via AJAX
        return false;
    });
});

// View person details in modal
$(document).on('click', '.view-person-btn', function() {
    $('#view_full_name').val($(this).data('full_name'));
    $('#view_national_id').val($(this).data('national_id'));
    $('#view_contact_number').val($(this).data('contact_number'));
    $('#view_email_address').val($(this).data('email_address'));
    $('#view_dob').val($(this).data('dob'));
    $('#view_gender').val($(this).data('gender'));
    $('#view_religion').val($(this).data('religion'));
    $('#view_address').val($(this).data('address'));
    $('#personViewModal').modal('show');
});

// Delete person via AJAX
$(document).on('click', '.delete-person-btn', function() {
    if (!confirm('Are you sure you want to delete this person?')) return;
    var personId = $(this).data('id');
    // Show loader
    $('body').append('<div id="page-loader" style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(255,255,255,0.7);z-index:9999;display:flex;align-items:center;justify-content:center;"><div class="spinner-border text-danger" role="status" style="width:4rem;height:4rem;"><span class="visually-hidden">Loading...</span></div></div>');
    $.ajax({
        url: '/personsDelete',
        type: 'DELETE',
        data: {
            id: personId,
            _token: $('input[name="_token"]').val()
        },
        dataType: 'json',
        success: function(response) {
            $('#page-loader').remove();
            if (response.status) {
                // Remove the row from the table
                $("button.delete-person-btn[data-id='"+personId+"']").closest('tr').remove();
                alert(response.message);
            } else {
                alert(response.message || 'Delete failed.');
            }
        },
        error: function() {
            $('#page-loader').remove();
            alert('An error occurred while deleting.');
        }
    });
});

// Edit person: fill modal fields with data
$(document).on('click', '.edit-person-btn', function() {
    // Set values in the edit modal
    $('#personEditModal #person_id').val($(this).data('id'));
    $('#personEditModal #full_name').val($(this).data('full_name'));
    $('#personEditModal #national_id').val($(this).data('national_id')).prop('readonly', true);
    $('#personEditModal #date_of_birth').val($(this).data('dob'));
    $('#personEditModal #gender').val($(this).data('gender_id'));
    $('#personEditModal #religion').val($(this).data('religion_id'));
    $('#personEditModal #address').val($(this).data('address'));
    $('#personEditModal #contact_number').val($(this).data('contact_number'));
    $('#personEditModal #email_address').val($(this).data('email_address'));
    // Remove previous errors
    $('#editUserForm .alert-danger').remove();
    $('#personEditModal').modal('show');
});

// Update person via AJAX with validation
$(document).ready(function () {
    $('#editUserForm').on('submit', function (e) {
        e.preventDefault();
        let valid = true;
        let errors = [];

        // Helper regex
        const nameRegex = /^[A-Za-z .'-]{2,100}$/;
        const contactRegex = /^\+?\d{10,15}$/;
        const emailRegex = /^[\w-.]+@([\w-]+\.)+[\w-]{2,}$/;

        // Get values
        let personId = $('#personEditModal #person_id').val().trim();
        const fullName = $('#personEditModal #full_name').val().trim();
        const nationalId = $('#personEditModal #national_id').val().trim();
        const date_of_birth = $('#personEditModal #date_of_birth').val();
        const gender = $('#personEditModal #gender').val();
        const religion = $('#personEditModal #religion').val();
        const address = $('#personEditModal #address').val().trim();
        const contactNumber = $('#personEditModal #contact_number').val().trim();
        const emailAddress = $('#personEditModal #email_address').val().trim();

        // Full Name
        if (!nameRegex.test(fullName)) {
            valid = false;
            errors.push('Full Name must be 2-100 alphabetic characters and may include spaces, dots, hyphens, and apostrophes.');
        }

        // Date of Birth: must be in the past and age >= 18
        if (!date_of_birth) {
            valid = false;
            errors.push('Date of Birth is required.');
        } else {
            const dobDate = new Date(date_of_birth);
            const today = new Date();
            if (dobDate >= today) {
                valid = false;
                errors.push('Date of Birth must be in the past.');
            } else {
                let age = today.getFullYear() - dobDate.getFullYear();
                const m = today.getMonth() - dobDate.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < dobDate.getDate())) {
                    age--;
                }
                if (age < 18) {
                    valid = false;
                    errors.push('Person must be at least 18 years old.');
                }
            }
        }

        // Gender
        if (!gender) {
            valid = false;
            errors.push('Gender is required.');
        }

        // Religion
        if (!religion) {
            valid = false;
            errors.push('Religion is required.');
        }

        // Address
        if (address.length < 5 || address.length > 255) {
            valid = false;
            errors.push('Address must be 5-255 characters.');
        }

        // Contact Number
        if (!contactRegex.test(contactNumber)) {
            valid = false;
            errors.push('Contact Number must be 10-15 digits and may start with +.');
        }

        // Email Address
        if (!emailRegex.test(emailAddress)) {
            valid = false;
            errors.push('Email Address must be a valid email.');
        }

        // Only proceed if all other validations pass
        if (!valid) {
            let errorHtml = '<div class="alert alert-danger"><ul>';
            errors.forEach(function (err) { errorHtml += '<li>' + err + '</li>'; });
            errorHtml += '</ul></div>';
            // Remove previous errors
            $('#editUserForm .alert-danger').remove();
            // Show errors at the top of the modal
            $('#editUserForm .modal-body').prepend(errorHtml);
            return false;
        }

        // Show page loader
        $('body').append('<div id="page-loader" style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(255,255,255,0.7);z-index:9999;display:flex;align-items:center;justify-content:center;"><div class="spinner-border text-primary" role="status" style="width:4rem;height:4rem;"><span class="visually-hidden">Loading...</span></div></div>');

        // Submit the form via AJAX
        $.ajax({
            url: '/personsUpdate',
            type: 'PUT',
            data: {
                id: personId,
                full_name: fullName,
                date_of_birth: date_of_birth,
                gender_id: gender,
                religion_id: religion,
                address: address,
                contact_number: contactNumber,
                email_address: emailAddress,
                _token: $('input[name="_token"]').val()
            },
            dataType: 'json',
            success: function(response) {
                $('#page-loader').remove();
                if (response.status) {
                    console.log(response.rows_html);
                    // Update the table rows
                    $('#persons-table-body').html(response.rows_html);
                    $('#personEditModal').modal('hide');
                    // Reset form
                    $('#editUserForm')[0].reset();
                } else {
                    let errorHtml = '<div class="alert alert-danger">' + response.message + '</div>';
                    $('#editUserForm .alert-danger').remove();
                    $('#editUserForm .modal-body').prepend(errorHtml);
                }
            },
            error: function(xhr) {
                $('#page-loader').remove();
                let errorHtml = '<div class="alert alert-danger">';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorHtml += '<ul>';
                    $.each(xhr.responseJSON.errors, function(key, val) {
                        errorHtml += '<li>' + val[0] + '</li>';
                    });
                    errorHtml += '</ul>';
                } else {
                    errorHtml += 'An error occurred while updating.';
                }
                errorHtml += '</div>';
                $('#editUserForm .alert-danger').remove();
                $('#editUserForm .modal-body').prepend(errorHtml);
            }
        });
        return false;
    });
});

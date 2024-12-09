// START: Faculty Management Section
document.addEventListener('DOMContentLoaded', function () {
    // Function to fetch faculty members based on filters
    function fetchFacultyMembers(page = 1) {
        console.log(`Fetching faculty members for page: ${page}`);
        const searchInput = document.getElementById('searchInput');
        const departmentFilter = document.getElementById('departmentFilter');
        const facultyRankFilter = document.getElementById('facultyRankFilter');

        const search = searchInput ? searchInput.value : '';
        const department = departmentFilter ? departmentFilter.value : '';
        const faculty_rank = facultyRankFilter ? facultyRankFilter.value : '';

        const params = new URLSearchParams({
            search: search,
            department: department,
            faculty_rank: faculty_rank,
            page: page
        });

        fetch('faculty_management/get_faculty_members.php?' + params.toString())
            .then(response => {
                console.log('Received response:', response);
                return response.text();
            })
            .then(text => {
                console.log('Response text:', text);
                try {
                    const data = JSON.parse(text);
                    if (data.error) {
                        console.error('Backend Error:', data.error);
                        alert(`Error: ${data.error}`);
                        return;
                    }

                    // Update the faculty members table
                    const tableBody = document.querySelector('#facultyMembersTable tbody');
                    if (tableBody) {
                        tableBody.innerHTML = data.table_data;
                    } else {
                        console.error('Table body not found!');
                    }

                    // Update the pagination
                    const paginationContainer = document.getElementById('facultyPagination');
                    if (paginationContainer) {
                        paginationContainer.innerHTML = data.pagination;
                    } else {
                        console.error('Pagination container not found!');
                    }

                    // Re-attach event listeners for "View Profile" buttons
                    attachViewProfileButtons();
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                }
            })
            .catch(error => {
                console.error('Error fetching faculty members:', error);
            });
    }

    // Function to attach event listeners to "View Profile" buttons
    function attachViewProfileButtons() {
        document.querySelectorAll('.view-profile-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                const facultyId = this.getAttribute('data-faculty-id');
                console.log(`View Profile clicked for Faculty ID: ${facultyId}`);
                // Fetch faculty data from backend
                fetch(`faculty_management/get_faculty_details.php?faculty_id=${facultyId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            return;
                        }

                        // Populate faculty details in Profile Modal
                        const faculty = data.faculty;
                        document.getElementById('facultyId').value = faculty.id; // Hidden input
                        document.getElementById('facultyFirstName').value = faculty.first_name;
                        document.getElementById('facultyMiddleName').value = faculty.middle_name || '';
                        document.getElementById('facultyLastName').value = faculty.last_name;
                        document.getElementById('facultyEmail').value = faculty.email;
                        document.getElementById('facultyEmployeeId').value = faculty.employee_id;
                        document.getElementById('facultyEmployeeIdText').textContent = faculty.employee_id; // Display in modal
                        document.getElementById('facultyPhone').value = faculty.phone_number || '';
                        document.getElementById('facultyAltEmail').value = faculty.alt_email || '';
                        document.getElementById('facultyDepartment').value = faculty.department;
                        document.getElementById('facultyPosition').value = faculty.faculty_rank;
                        document.getElementById('facultyRole').value = faculty.role || '';
                        document.getElementById('facultyLastUpdated').textContent = faculty.last_updated || 'N/A';
                        document.getElementById('facultyCreatedAt').textContent = faculty.created_at || 'N/A';

                        // Handle profile picture
                        const profilePic = document.getElementById('facultyProfilePicture');
                        if (faculty.profile_picture && faculty.profile_picture.trim() !== '') {
                            // Construct the correct path to the profile picture
                            profilePic.src = '../../uploads/' + faculty.profile_picture;
                        } else {
                            profilePic.src = '../../img/cropped-SLSU_Logo-1.png'; // Placeholder image path
                        }

                        // Reset form validation states
                        const editFacultyForm = document.getElementById('editFacultyForm');
                        editFacultyForm.classList.remove('was-validated');

                        // Show the modal
                        $('#profileModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error fetching faculty data:', error);
                        alert('Failed to load faculty profile.');
                    });
            });
        });
    }

    // Attach event listeners to filters
    const searchInput = document.getElementById('searchInput');
    const departmentFilter = document.getElementById('departmentFilter');
    const facultyRankFilter = document.getElementById('facultyRankFilter');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            fetchFacultyMembers(1);
        });
    }

    if (departmentFilter) {
        departmentFilter.addEventListener('change', function () {
            fetchFacultyMembers(1);
        });
    }

    if (facultyRankFilter) {
        facultyRankFilter.addEventListener('change', function () {
            fetchFacultyMembers(1);
        });
    }

    // Handle pagination clicks using event delegation
    document.addEventListener('click', function (e) {
        const link = e.target.closest('.faculty-pagination a');
        if (link) {
            e.preventDefault();
            const page = link.getAttribute('data-page');
            if (page) {
                console.log(`Pagination link clicked. Navigating to page: ${page}`);
                fetchFacultyMembers(page);
            }
        }
    });

    // Fetch initial faculty members
    fetchFacultyMembers();

    // Attach initial event listeners to "View Profile" buttons
    attachViewProfileButtons();

    // Handle Edit Faculty Form Submission
    document.getElementById('editFacultyForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const form = this;

        if (!form.checkValidity()) {
            e.stopPropagation();
            form.classList.add('was-validated');
            return;
        }

        const formData = new FormData(form);

        fetch('faculty_management/edit_faculty_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.success);
                // Refresh the faculty list
                fetchFacultyMembers();
                // Close the modal
                $('#profileModal').modal('hide');
            } else {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error editing faculty profile:', error);
            alert('Failed to edit faculty profile.');
        });
    });
});
// END: Faculty Management Section




// START: Profile Change Requests
$(document).ready(function() {
    // Fetch initial data with default sorting by oldest
    fetchProfileChangeRequests(1);

    // Event handlers for filters and search
    $('#nameSearch, #requestDepartmentFilter, #requestFacultyRankFilter, #statusFilter, #dateSortFilter').on('input change', function() {
        fetchProfileChangeRequests(1);
    });

    // Handle pagination clicks using event delegation
    $(document).on('click', '.pagination a.page-link', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        fetchProfileChangeRequests(page);
    });

    // Function to fetch data
    function fetchProfileChangeRequests(page) {
        var name = $('#nameSearch').val();
        var department = $('#requestDepartmentFilter').val();
        var faculty_rank = $('#requestFacultyRankFilter').val();
        var status = $('#statusFilter').val();
        var date_sort = $('#dateSortFilter').val(); // Get the date_sort value

        $.ajax({
            url: 'faculty_management/get_profile_change_requests.php',
            type: 'GET',
            data: {
                name: name,
                department: department,
                faculty_rank: faculty_rank,
                status: status,
                date_sort: date_sort,
                page: page
            },
            dataType: 'json',
            success: function(response) {
                // Update table
                $('#profileChangeRequestsTable tbody').html(response.table_data);
                // Update pagination
                $('#pagination').html(response.pagination);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Event handler for table row click
    $(document).on('click', '#profileChangeRequestsTable tbody tr', function() {
        var requestId = $(this).data('request-id');
        // Fetch request details and show modal
        fetchRequestDetails(requestId);
    });

    // Function to fetch request details
    function fetchRequestDetails(requestId) {
        $.ajax({
            url: 'faculty_management/get_request_details.php',
            type: 'GET',
            data: {
                request_id: requestId
            },
            dataType: 'json',
            success: function(response) {
                if (!response.success) {
                    alert(response.message);
                    return;
                }
                // Populate modal fields
                $('#modalRequestId').text(response.request_id);
                $('#modalFacultyName').text(response.faculty_name);
                $('#modalDepartment').text(response.department);
                $('#modalRank').text(response.rank);
                $('#modalSubmittedAt').text(response.submitted_at);
                $('#modalStatus').text(response.status);
                $('#modalAdminMessage').val(response.admin_message);

                // Display requested changes
                var requestedChangesHtml = '';
                $.each(response.requested_changes, function(field, values) {
                    requestedChangesHtml += '<p><strong>' + field.replace('_', ' ') + ':</strong> ' + values.old_value + ' &rarr; ' + values.new_value + '</p>';
                });
                $('#modalRequestedChanges').html(requestedChangesHtml);

                // Disable buttons and textarea if request is processed
                if (response.status != 'Pending') {
                    $('#approveRequestBtn').prop('disabled', true);
                    $('#denyRequestBtn').prop('disabled', true);
                    $('#modalAdminMessage').prop('disabled', true);
                } else {
                    $('#approveRequestBtn').prop('disabled', false);
                    $('#denyRequestBtn').prop('disabled', false);
                    $('#modalAdminMessage').prop('disabled', false);
                }

                // Show modal
                $('#requestModal').modal('show');

                // Set data attribute for approve/deny buttons
                $('#approveRequestBtn').data('request-id', requestId);
                $('#denyRequestBtn').data('request-id', requestId);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Event handler for Approve button
    $('#approveRequestBtn').click(function() {
        var requestId = $(this).data('request-id');
        processRequest(requestId, 'Approved');
    });

    // Event handler for Deny button
    $('#denyRequestBtn').click(function() {
        var requestId = $(this).data('request-id');
        processRequest(requestId, 'Denied');
    });

    // Function to process request (approve/deny)
    function processRequest(requestId, action) {
        var adminMessage = $('#modalAdminMessage').val();

        $.ajax({
            url: 'faculty_management/process_change_request.php',
            type: 'POST',
            data: {
                request_id: requestId,
                action: action,
                admin_message: adminMessage
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Request ' + action.toLowerCase() + ' successfully.');
                    $('#requestModal').modal('hide');
                    // Refresh data
                    fetchProfileChangeRequests(1);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
});
// END: Profile Change Requests
// careerpath/php/includes/career_progress_tracking/teaching/js/criterion_a.js

$(document).ready(function() {
    // Save Criterion A
    $('#save-criterion-a').click(function(e) {
        e.preventDefault();

        let formData = $('#criterion-a-form').serialize();

        ajaxPost('save_criterion_a.php', formData)
            .done(function(response) {
                if (response.status === 'success') {
                    $('#saveConfirmationModal').modal('show');
                } else {
                    $('#saveErrorModal .modal-body').text(response.message);
                    $('#saveErrorModal').modal('show');
                }
            })
            .fail(function() {
                $('#saveErrorModal .modal-body').text('An unexpected error occurred.');
                $('#saveErrorModal').modal('show');
            });
    });

    // Fetch Criterion A Data (if editing)
    function fetchCriterionA(request_id) {
        ajaxGet('fetch_criterion_a.php', { request_id: request_id })
            .done(function(response) {
                if (response.status === 'success') {
                    // Populate the form with fetched data
                    // Implement as needed
                } else {
                    $('#saveErrorModal .modal-body').text(response.message);
                    $('#saveErrorModal').modal('show');
                }
            })
            .fail(function() {
                $('#saveErrorModal .modal-body').text('Failed to fetch data.');
                $('#saveErrorModal').modal('show');
            });
    }

    // Example: Initialize fetch if request_id is available
    // let request_id = $('#hidden-request-id').val();
    // if(request_id) fetchCriterionA(request_id);

    // Handle Delete Row
    let rowToDelete;
    $(document).on('click', '.delete-row', function() {
        rowToDelete = $(this).closest('tr');
        $('#deleteRowModal').modal('show');
    });

    $('#confirm-delete-row').click(function() {
        rowToDelete.remove();
        $('#deleteRowModal').modal('hide');
    });

    // Handle Remarks Modal
    $(document).on('click', '.view-remarks', function() {
        let firstRemark = $(this).data('first-remark') || 'No remarks.';
        let secondRemark = $(this).data('second-remark') || 'No remarks.';
        $('#first-semester-remark').text(firstRemark);
        $('#second-semester-remark').text(secondRemark);
        $('#remarksModal').modal('show');
    });

    // Add Row Functionality
    $('.add-row').click(function() {
        let tableId = $(this).data('table-id');
        let table = $('#' + tableId + ' tbody');
        let newRow = `<tr>
            <td><input type="text" class="form-control" name="${tableId === 'student-evaluation-table' ? 'student_evaluation_period[]' : 'supervisor_evaluation_period[]'}" value=""></td>
            <td><input type="number" class="form-control rating-input" name="${tableId === 'student-evaluation-table' ? 'student_rating_1[]' : 'supervisor_rating_1[]'}" placeholder="0.00" step="0.01" min="0" max="5" required></td>
            <td><input type="number" class="form-control rating-input" name="${tableId === 'student-evaluation-table' ? 'student_rating_2[]' : 'supervisor_rating_2[]'}" placeholder="0.00" step="0.01" min="0" max="5" required></td>
            <td><input type="url" class="form-control" name="${tableId === 'student-evaluation-table' ? 'student_evidence_link[]' : 'supervisor_evidence_link[]'}" placeholder="https://example.com/evidence" pattern="https?://.+" required></td>
            <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
        </tr>`;
        table.append(newRow);
    });

    // Calculate Overall Scores (Implement as needed)
    // You can add event listeners to input fields to calculate and update the overall scores
});

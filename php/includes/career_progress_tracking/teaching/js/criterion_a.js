// /php/includes/career_progress_tracking/teaching/js/criterion_a.js

document.addEventListener('DOMContentLoaded', function () {
    // Save Criterion A Handler
    document.getElementById('save-criterion-a').addEventListener('click', function () {
        const form = document.getElementById('criterion-a-form');
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        calculateOverallScores();

        const requestId = document.getElementById('request_id').value;

        // Gather Student Evaluations
        const studentEvaluations = [];
        const studentRows = document.querySelectorAll('#student-evaluation-table tbody tr');
        studentRows.forEach(row => {
            const evaluation_id = row.getAttribute('data-evaluation-id') || 0;
            const evaluation_period = row.querySelector('input[name="student_evaluation_period[]"]').value;
            const rating1Input = row.querySelector('input[name="student_rating_1[]"]');
            const rating2Input = row.querySelector('input[name="student_rating_2[]"]');
            const evidence_link_first = row.querySelector('input[name="student_evidence_link[]"]').value;
            const evidence_link_second = evidence_link_first; // Assuming same link for both semesters
            const remarks_first = ''; // Handle as needed
            const remarks_second = ''; // Handle as needed
            const overall_average_rating = parseFloat(document.getElementById('student_overall_score').value) || 0;
            const faculty_rating = parseFloat(document.getElementById('student_faculty_overall_score').value) || 0;

            studentEvaluations.push({
                evaluation_id,
                evaluation_period,
                first_semester_rating: parseFloat(rating1Input.value) || 0,
                second_semester_rating: parseFloat(rating2Input.value) || 0,
                evidence_link_first,
                evidence_link_second,
                remarks_first,
                remarks_second,
                overall_average_rating,
                faculty_rating
            });
        });

        // Gather Supervisor Evaluations
        const supervisorEvaluations = [];
        const supervisorRows = document.querySelectorAll('#supervisor-evaluation-table tbody tr');
        supervisorRows.forEach(row => {
            const evaluation_id = row.getAttribute('data-evaluation-id') || 0;
            const evaluation_period = row.querySelector('input[name="supervisor_evaluation_period[]"]').value;
            const rating1Input = row.querySelector('input[name="supervisor_rating_1[]"]');
            const rating2Input = row.querySelector('input[name="supervisor_rating_2[]"]');
            const evidence_link_first = row.querySelector('input[name="supervisor_evidence_link[]"]').value;
            const evidence_link_second = evidence_link_first; // Assuming same link for both semesters
            const remarks_first = ''; // Handle as needed
            const remarks_second = ''; // Handle as needed
            const overall_average_rating = parseFloat(document.getElementById('supervisor-overall-score').value) || 0;
            const faculty_rating = parseFloat(document.getElementById('supervisor-faculty-overall-score').value) || 0;

            supervisorEvaluations.push({
                evaluation_id,
                evaluation_period,
                first_semester_rating: parseFloat(rating1Input.value) || 0,
                second_semester_rating: parseFloat(rating2Input.value) || 0,
                evidence_link_first,
                evidence_link_second,
                remarks_first,
                remarks_second,
                overall_average_rating,
                faculty_rating
            });
        });

        const payload = {
            request_id: parseInt(requestId),
            student_divisor: parseInt(document.getElementById('student-divisor').value),
            student_reason: document.getElementById('student-reason').value,
            student_evidence_link: document.getElementById('student-evidence-link').value,
            supervisor_divisor: parseInt(document.getElementById('supervisor-divisor').value),
            supervisor_reason: document.getElementById('supervisor-reason').value,
            supervisor_evidence_link: document.getElementById('supervisor-evidence-link').value,
            student_evaluations: studentEvaluations,
            supervisor_evaluations: supervisorEvaluations
        };

        console.log('Payload:', payload); // Debugging

        fetch('../../includes/career_progress_tracking/teaching/save_criterion_a.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const saveModal = new bootstrap.Modal(document.getElementById('saveConfirmationModal'));
                saveModal.show();
            } else {
                const errorModal = new bootstrap.Modal(document.getElementById('saveErrorModal'));
                document.querySelector('#saveErrorModal .modal-body').textContent = data.error || 'An error occurred.';
                errorModal.show();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            const errorModal = new bootstrap.Modal(document.getElementById('saveErrorModal'));
            document.querySelector('#saveErrorModal .modal-body').textContent = 'Failed to save data.';
            errorModal.show();
        });
    });

    // Calculate Overall Scores for Criterion A
    const calculateOverallScores = () => {
        // Student Evaluation Calculations
        let studentTotalRating = 0;
        let studentRatingCount = 0;

        const studentReason = document.getElementById('student-reason').value;
        const studentDeductSemesters = parseInt(document.getElementById('student-divisor').value) || 0;
        const studentTotalSemesters = 8 - studentDeductSemesters;

        const studentRows = document.querySelectorAll('#student-evaluation-table tbody tr');
        console.log(`Calculating Student Evaluations: ${studentRows.length} rows found.`);
        
        studentRows.forEach((row, index) => {
            const rating1Input = row.querySelector('input[name="student_rating_1[]"]');
            const rating2Input = row.querySelector('input[name="student_rating_2[]"]');
            
            const rating1 = parseFloat(rating1Input.value) || 0;
            const rating2 = parseFloat(rating2Input.value) || 0;

            console.log(`Row ${index + 1}: Rating 1 = ${rating1}, Rating 2 = ${rating2}`);

            studentTotalRating += rating1 + rating2;
            studentRatingCount += 2;
        });

        const studentOverallAverageRating = (studentReason === "Not Applicable" || studentReason === "") ?
            (studentRatingCount ? (studentTotalRating / studentRatingCount) : 0) :
            (studentTotalSemesters ? (studentTotalRating / studentTotalSemesters) : 0);

        const studentFacultyRating = (studentOverallAverageRating * 0.36).toFixed(2);

        console.log(`Student Overall Average Rating: ${studentOverallAverageRating}`);
        console.log(`Student Faculty Rating: ${studentFacultyRating}`);

        document.getElementById('student_overall_score').value = studentOverallAverageRating.toFixed(2);
        document.getElementById('student_faculty_overall_score').value = studentFacultyRating;


        // Supervisor Evaluation Calculations
        let supervisorTotalRating = 0;
        let supervisorRatingCount = 0;

        const supervisorReason = document.getElementById('supervisor-reason').value;
        const supervisorDeductSemesters = parseInt(document.getElementById('supervisor-divisor').value) || 0;
        const supervisorTotalSemesters = 8 - supervisorDeductSemesters;

        const supervisorRows = document.querySelectorAll('#supervisor-evaluation-table tbody tr');
        console.log(`Calculating Supervisor Evaluations: ${supervisorRows.length} rows found.`);
        
        supervisorRows.forEach((row, index) => {
            const rating1Input = row.querySelector('input[name="supervisor_rating_1[]"]');
            const rating2Input = row.querySelector('input[name="supervisor_rating_2[]"]');
            
            const rating1 = parseFloat(rating1Input.value) || 0;
            const rating2 = parseFloat(rating2Input.value) || 0;

            console.log(`Row ${index + 1}: Rating 1 = ${rating1}, Rating 2 = ${rating2}`);

            supervisorTotalRating += rating1 + rating2;
            supervisorRatingCount += 2;
        });

        const supervisorOverallAverageRating = (supervisorReason === "Not Applicable" || supervisorReason === "") ?
            (supervisorRatingCount ? (supervisorTotalRating / supervisorRatingCount) : 0) :
            (supervisorTotalSemesters ? (supervisorTotalRating / supervisorTotalSemesters) : 0);

        const supervisorFacultyRating = (supervisorOverallAverageRating * 0.24).toFixed(2);

        console.log(`Supervisor Overall Average Rating: ${supervisorOverallAverageRating}`);
        console.log(`Supervisor Faculty Rating: ${supervisorFacultyRating}`);

        document.getElementById('supervisor-overall-score').value = supervisorOverallAverageRating.toFixed(2);
        document.getElementById('supervisor-faculty-overall-score').value = supervisorFacultyRating;
    };

    // Event Delegation for Rating Inputs
    document.addEventListener('input', function (e) {
        if (e.target.matches('.rating-input')) {
            calculateOverallScores();
        }
    });

    // Event Delegation for Select Inputs
    document.addEventListener('change', function (e) {
        if (e.target.matches('select[name*="divisor"], select[name*="reason"]')) {
            calculateOverallScores();
        }
    });

    // Add Row Functionality
    document.querySelectorAll('.add-row').forEach(button => {
        button.addEventListener('click', function () {
            const tableId = this.getAttribute('data-table-id');
            console.log(`Adding row to table: ${tableId}`);
            const tableBody = document.querySelector(`#${tableId} tbody`);
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-evaluation-id', '0'); // Assign '0' to new rows

            const periodName = tableId.includes('student') ? 'student_evaluation_period[]' : 'supervisor_evaluation_period[]';
            const rating1Name = tableId.includes('student') ? 'student_rating_1[]' : 'supervisor_rating_1[]';
            const rating2Name = tableId.includes('student') ? 'student_rating_2[]' : 'supervisor_rating_2[]';
            const evidenceLinkName = tableId.includes('student') ? 'student_evidence_link[]' : 'supervisor_evidence_link[]';

            console.log(`Input Names: ${periodName}, ${rating1Name}, ${rating2Name}, ${evidenceLinkName}`);

            newRow.innerHTML = `
                <td>
                    <input type="text" class="form-control" name="${periodName}" value="AY 2020 - 2021" required>
                </td>
                <td>
                    <input type="number" class="form-control rating-input" name="${rating1Name}" placeholder="0.00" required>
                </td>
                <td>
                    <input type="number" class="form-control rating-input" name="${rating2Name}" placeholder="0.00" required>
                </td>
                <td>
                    <input type="url" class="form-control" name="${evidenceLinkName}" placeholder="https://example.com/evidence" pattern="https?://.+" required>
                </td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">
                        View Remarks
                    </button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                </td>
            `;
            tableBody.appendChild(newRow);

            // Optionally, trigger calculation if default values are set
            // calculateOverallScores(); // Uncomment if you want to include default values in calculations
        });
    });

    // Delete Row Functionality
    let rowToDelete;
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-row')) {
            rowToDelete = e.target.closest('tr');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteRowModal'));
            deleteModal.show();
        }

        if (e.target.id === 'confirm-delete-row') {
            if (rowToDelete) {
                rowToDelete.remove();
                rowToDelete = null;
                const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteRowModal'));
                deleteModal.hide();
                calculateOverallScores();
            }
        }
    });

    // View Remarks Functionality
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('view-remarks')) {
            const remarksFirst = e.target.getAttribute('data-first-remark') || 'No remarks.';
            const remarksSecond = e.target.getAttribute('data-second-remark') || 'No remarks.';
            document.getElementById('first-semester-remark').textContent = remarksFirst;
            document.getElementById('second-semester-remark').textContent = remarksSecond;
            const remarksModal = new bootstrap.Modal(document.getElementById('remarksModal'));
            remarksModal.show();
        }
    });

    // Expose fetchCriterionA and populateForm to global scope
    window.fetchCriterionA = function(requestId) {
        fetch(`../../includes/career_progress_tracking/teaching/fetch_criterion_a.php?request_id=${requestId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) { // Ensure your PHP returns a 'success' key
                    populateForm(data);
                } else {
                    console.error(data.error || 'Failed to fetch Criterion A data.');
                }
            })
            .catch(error => console.error('Error fetching Criterion A:', error));
    };

    function populateForm(data) {
        // Populate Metadata
        if (data.metadata) {
            document.getElementById('student-divisor').value = data.metadata.student_divisor || 0;
            document.getElementById('student-reason').value = data.metadata.student_reason || '';
            document.getElementById('student-evidence-link').value = data.metadata.student_evidence_link || '';
            document.getElementById('supervisor-divisor').value = data.metadata.supervisor_divisor || 0;
            document.getElementById('supervisor-reason').value = data.metadata.supervisor_reason || '';
            document.getElementById('supervisor-evidence-link').value = data.metadata.supervisor_evidence_link || '';
        }

        // Populate Student Evaluations
        if (data.student_evaluations) {
            const studentTableBody = document.querySelector('#student-evaluation-table tbody');
            studentTableBody.innerHTML = ''; // Clear existing rows
            data.student_evaluations.forEach(evalItem => {
                const row = document.createElement('tr');
                row.setAttribute('data-evaluation-id', evalItem.evaluation_id);
                row.innerHTML = `
                    <td>
                        <input type="text" class="form-control" name="student_evaluation_period[]" value="${escapeHTML(evalItem.evaluation_period)}" required>
                    </td>
                    <td>
                        <input type="number" class="form-control rating-input" name="student_rating_1[]" value="${evalItem.first_semester_rating}" placeholder="0.00" required>
                    </td>
                    <td>
                        <input type="number" class="form-control rating-input" name="student_rating_2[]" value="${evalItem.second_semester_rating}" placeholder="0.00" required>
                    </td>
                    <td>
                        <input type="url" class="form-control" name="student_evidence_link[]" value="${escapeHTML(evalItem.evidence_link_first)}" placeholder="https://example.com/evidence" pattern="https?://.+" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="${escapeHTML(evalItem.remarks_first)}" data-second-remark="${escapeHTML(evalItem.remarks_second)}">
                            View Remarks
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                    </td>
                `;
                studentTableBody.appendChild(row);
            });
        }

        // Populate Supervisor Evaluations
        if (data.supervisor_evaluations) {
            const supervisorTableBody = document.querySelector('#supervisor-evaluation-table tbody');
            supervisorTableBody.innerHTML = ''; // Clear existing rows
            data.supervisor_evaluations.forEach(evalItem => {
                const row = document.createElement('tr');
                row.setAttribute('data-evaluation-id', evalItem.evaluation_id);
                row.innerHTML = `
                    <td>
                        <input type="text" class="form-control" name="supervisor_evaluation_period[]" value="${escapeHTML(evalItem.evaluation_period)}" required>
                    </td>
                    <td>
                        <input type="number" class="form-control rating-input" name="supervisor_rating_1[]" value="${evalItem.first_semester_rating}" placeholder="0.00" required>
                    </td>
                    <td>
                        <input type="number" class="form-control rating-input" name="supervisor_rating_2[]" value="${evalItem.second_semester_rating}" placeholder="0.00" required>
                    </td>
                    <td>
                        <input type="url" class="form-control" name="supervisor_evidence_link[]" value="${escapeHTML(evalItem.evidence_link_first)}" placeholder="https://example.com/evidence" pattern="https?://.+" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="${escapeHTML(evalItem.remarks_first)}" data-second-remark="${escapeHTML(evalItem.remarks_second)}">
                            View Remarks
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                    </td>
                `;
                supervisorTableBody.appendChild(row);
            });
        }

        calculateOverallScores();
    }

    // Escape HTML to prevent XSS
    function escapeHTML(str) {
        if (!str) return '';
        return str.replace(/&/g, "&amp;")
                  .replace(/</g, "&lt;")
                  .replace(/>/g, "&gt;")
                  .replace(/"/g, "&quot;")
                  .replace(/'/g, "&#039;");
    }
});

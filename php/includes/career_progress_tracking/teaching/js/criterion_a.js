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
        /**
         * Calculates the overall and faculty scores for a given section.
         * @param {string} divisorId - The ID of the divisor select element.
         * @param {string} reasonId - The ID of the reason select element.
         * @param {string} overallScoreId - The ID of the overall score input element.
         * @param {string} facultyScoreId - The ID of the faculty score input element.
         * @param {number} multiplier - The multiplier for calculating the faculty score.
         */
        const calculateSectionScores = (divisorId, reasonId, overallScoreId, facultyScoreId, multiplier) => {
            // Get the divisor value
            const divisorSelect = document.getElementById(divisorId);
            let divisor = parseInt(divisorSelect.value, 10);

            // Validate the divisor
            if (isNaN(divisor) || divisor < 0 || divisor > 8) {
                console.warn(`Invalid divisor value "${divisorSelect.value}" in "${divisorId}". Defaulting to 0.`);
                divisor = 0; // Default to 0 if invalid
            }

            // Get the reason value
            const reasonSelect = document.getElementById(reasonId);
            const reason = reasonSelect.value;

            // Select the appropriate evaluation table
            const sectionPrefix = divisorId.includes('student') ? 'student' : 'supervisor';
            const evaluationTable = document.getElementById(`${sectionPrefix}-evaluation-table`);
            const ratingInputs = evaluationTable.querySelectorAll('input[name*="_rating_1[]"], input[name*="_rating_2[]"]');

            // Sum all the ratings
            let totalRating = 0;
            let ratingCount = 0;
            ratingInputs.forEach(input => {
                const rating = parseFloat(input.value);
                if (!isNaN(rating)) {
                    totalRating += rating;
                    ratingCount += 1;
                }
            });

            let overallAverageRating = 0;

            // Apply calculation rules based on reason and divisor
            if ((reason === '' || reason === 'not_applicable') || divisor === 0) {
                // Simple average: average of all ratings
                if (ratingCount > 0) {
                    overallAverageRating = totalRating / ratingCount;
                } else {
                    overallAverageRating = 0;
                }
            } else if ((reason !== '' && reason !== 'not_applicable') && divisor > 0) {
                // Adjusted average: sum of ratings / (8 - divisor)
                const denominator = 8 - divisor;
                if (denominator > 0) {
                    overallAverageRating = totalRating / denominator;
                } else {
                    overallAverageRating = 0;
                }
            } else {
                // Fallback to simple average
                if (ratingCount > 0) {
                    overallAverageRating = totalRating / ratingCount;
                } else {
                    overallAverageRating = 0;
                }
            }

            // Calculate the faculty score
            const facultyScore = overallAverageRating * multiplier;

            // Update the DOM with the calculated scores
            document.getElementById(overallScoreId).value = overallAverageRating.toFixed(2);
            document.getElementById(facultyScoreId).value = facultyScore.toFixed(2);

            // Debugging Logs
            console.log(`${sectionPrefix.charAt(0).toUpperCase() + sectionPrefix.slice(1)} Calculation:`);
            console.log(`Divisor: ${divisor}`);
            console.log(`Reason: ${reason}`);
            console.log(`Total Rating: ${totalRating}`);
            console.log(`Rating Count: ${ratingCount}`);
            console.log(`Overall Average Rating: ${overallAverageRating.toFixed(2)}`);
            console.log(`Faculty Score: ${facultyScore.toFixed(2)}`);
        };

        // Calculate scores for Student Evaluation
        calculateSectionScores(
            'student-divisor',
            'student-reason',
            'student_overall_score',
            'student_faculty_overall_score',
            0.36
        );

        // Calculate scores for Supervisor's Evaluation
        calculateSectionScores(
            'supervisor-divisor',
            'supervisor-reason',
            'supervisor-overall-score',
            'supervisor-faculty-overall-score',
            0.24
        );
    };

    // Recalculate scores when any rating input changes
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('rating-input')) {
            calculateOverallScores();
        }
    });

    // Recalculate scores when divisor or reason selects change
    document.addEventListener('change', function (e) {
        if (e.target.matches('select[name*="divisor"], select[name*="reason"]')) {
            calculateOverallScores();
        }
    });

    // Initial calculation on page load
    calculateOverallScores();


    // Add Row Functionality
    document.querySelectorAll('.add-row').forEach(button => {
        button.addEventListener('click', function () {
            const tableId = this.getAttribute('data-table-id');
            console.log(`Adding row to table: ${tableId}`);
            const tableBody = document.querySelector(`#${tableId} tbody`);
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-evaluation-id', '0'); // Assign '0' to new rows

            const isStudent = tableId.includes('student');
            const periodName = isStudent ? 'student_evaluation_period[]' : 'supervisor_evaluation_period[]';
            const rating1Name = isStudent ? 'student_rating_1[]' : 'supervisor_rating_1[]';
            const rating2Name = isStudent ? 'student_rating_2[]' : 'supervisor_rating_2[]';
            const evidenceLinkName = isStudent ? 'student_evidence_link[]' : 'supervisor_evidence_link[]';

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
            calculateOverallScores();
        });
    });

    // Delete Row Functionality
    let rowToDelete;
    let evaluationIdToDelete;

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-row')) {
            rowToDelete = e.target.closest('tr');
            evaluationIdToDelete = rowToDelete.getAttribute('data-evaluation-id') || '0';
    
            // Determine which table the row belongs to
            const tableId = e.target.closest('table').id;
            if (tableId === 'student-evaluation-table') {
                tableToDeleteFrom = 'student';
            } else if (tableId === 'supervisor-evaluation-table') {
                tableToDeleteFrom = 'supervisor';
            } else {
                tableToDeleteFrom = null;
            }
    
            // Show confirmation modal
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteRowModal'));
            deleteModal.show();
        }
    
        if (e.target.id === 'confirm-delete-row') {
            if (rowToDelete) {
                if (evaluationIdToDelete !== '0') {
                    // Prepare the payload with table information
                    const payload = {
                        evaluation_id: evaluationIdToDelete,
                        table: tableToDeleteFrom
                    };
    
                    // Send delete request to server
                    fetch('../../includes/career_progress_tracking/teaching/delete_criterion_a.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the row from the table
                            rowToDelete.remove();
    
                            // Optionally, show a success message
                            const successModal = new bootstrap.Modal(document.getElementById('deleteSuccessModal'));
                            successModal.show();
    
                            // Recalculate overall scores
                            calculateOverallScores();
                        } else {
                            // Show error message
                            const errorModal = new bootstrap.Modal(document.getElementById('deleteErrorModal'));
                            document.querySelector('#deleteErrorModal .modal-body').textContent = data.error || 'Failed to delete evaluation.';
                            errorModal.show();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        const errorModal = new bootstrap.Modal(document.getElementById('deleteErrorModal'));
                        document.querySelector('#deleteErrorModal .modal-body').textContent = 'An unexpected error occurred.';
                        errorModal.show();
                    })
                    .finally(() => {
                        // Reset variables and hide confirmation modal
                        rowToDelete = null;
                        evaluationIdToDelete = null;
                        tableToDeleteFrom = null;
                        const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteRowModal'));
                        deleteModal.hide();
                    });
                } else {
                    // For new rows that haven't been saved yet, simply remove the row without server interaction
                    rowToDelete.remove();
                    calculateOverallScores();
                    rowToDelete = null;
                    evaluationIdToDelete = null;
                    tableToDeleteFrom = null;
                    const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteRowModal'));
                    deleteModal.hide();
                }
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

    // Populate form with data or default rows
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
    
        // Define table bodies outside the if blocks
        const studentTableBody = document.querySelector('#student-evaluation-table tbody');
        const supervisorTableBody = document.querySelector('#supervisor-evaluation-table tbody');
    
        // Populate Student Evaluations
        if (data.student_evaluations && data.student_evaluations.length > 0) {
            studentTableBody.innerHTML = ''; // Clear existing rows
            data.student_evaluations.forEach(evalItem => {
                console.log('Student Evaluation Item:', evalItem); // Debugging
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
        } else {
            // No data, add default empty rows
            console.log('No student evaluations found. Adding default rows.');
            addDefaultStudentRows(studentTableBody);
        }
    
        // Populate Supervisor Evaluations
        if (data.supervisor_evaluations && data.supervisor_evaluations.length > 0) {
            supervisorTableBody.innerHTML = ''; // Clear existing rows
            data.supervisor_evaluations.forEach(evalItem => {
                console.log('Supervisor Evaluation Item:', evalItem); // Debugging
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
        } else {
            // No data, add default empty rows
            console.log('No supervisor evaluations found. Adding default rows.');
            addDefaultSupervisorRows(supervisorTableBody);
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

    // Function for adding preset / default rows
    function addDefaultStudentRows(tableBody) {
        const defaultPeriods = ["AY 2019 - 2020", "AY 2020 - 2021", "AY 2021 - 2022", "AY 2022 - 2023"];
        defaultPeriods.forEach(period => {
            const row = document.createElement('tr');
            row.setAttribute('data-evaluation-id', '0'); // New rows have evaluation_id = 0
            row.innerHTML = `
                <td>
                    <input type="text" class="form-control" name="student_evaluation_period[]" value="${escapeHTML(period)}" required>
                </td>
                <td>
                    <input type="number" class="form-control rating-input" name="student_rating_1[]" placeholder="0.00" required>
                </td>
                <td>
                    <input type="number" class="form-control rating-input" name="student_rating_2[]" placeholder="0.00" required>
                </td>
                <td>
                    <input type="url" class="form-control" name="student_evidence_link[]" placeholder="https://example.com/evidence" pattern="https?://.+" required>
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
            tableBody.appendChild(row);
        });
    }
    
    function addDefaultSupervisorRows(tableBody) {
        const defaultPeriods = ["AY 2019 - 2020", "AY 2020 - 2021", "AY 2021 - 2022", "AY 2022 - 2023"];
        defaultPeriods.forEach(period => {
            const row = document.createElement('tr');
            row.setAttribute('data-evaluation-id', '0'); // New rows have evaluation_id = 0
            row.innerHTML = `
                <td>
                    <input type="text" class="form-control" name="supervisor_evaluation_period[]" value="${escapeHTML(period)}" required>
                </td>
                <td>
                    <input type="number" class="form-control rating-input" name="supervisor_rating_1[]" placeholder="0.00" required>
                </td>
                <td>
                    <input type="number" class="form-control rating-input" name="supervisor_rating_2[]" placeholder="0.00" required>
                </td>
                <td>
                    <input type="url" class="form-control" name="supervisor_evidence_link[]" placeholder="https://example.com/evidence" pattern="https?://.+" required>
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
            tableBody.appendChild(row);
        });
    }
    


});

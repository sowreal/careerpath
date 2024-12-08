// === FETCHING AND POPULATE START ===
function escapeHTML(str) {
    if (!str) return '';
    return str.replace(/&/g, "&amp;")
              .replace(/</g, "&lt;")
              .replace(/>/g, "&gt;")
              .replace(/"/g, "&quot;")
              .replace(/'/g, "&#039;");
}

function addDefaultStudentRows(tableBody) {
    const defaultPeriods = ["AY 2019 - 2020", "AY 2020 - 2021", "AY 2021 - 2022", "AY 2022 - 2023"];
    defaultPeriods.forEach(period => {
        const row = document.createElement('tr');
        row.setAttribute('data-evaluation-id', '0');
        row.innerHTML = `
            <td><input type="text" class="form-control" name="student_evaluation_period[]" value="${escapeHTML(period)}" required></td>
            <td><input type="number" class="form-control rating-input" name="student_rating_1[]" placeholder="0.00" required></td>
            <td><input type="number" class="form-control rating-input" name="student_rating_2[]" placeholder="0.00" required></td>
            <td><input type="url" class="form-control" name="student_evidence_link[]" placeholder="https://example.com/evidence" pattern="https?://.+" required></td>
            <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
        `;
        tableBody.appendChild(row);
    });
}

function addDefaultSupervisorRows(tableBody) {
    const defaultPeriods = ["AY 2019 - 2020", "AY 2020 - 2021", "AY 2021 - 2022", "AY 2022 - 2023"];
    defaultPeriods.forEach(period => {
        const row = document.createElement('tr');
        row.setAttribute('data-evaluation-id', '0');
        row.innerHTML = `
            <td><input type="text" class="form-control" name="supervisor_evaluation_period[]" value="${escapeHTML(period)}" required></td>
            <td><input type="number" class="form-control rating-input" name="supervisor_rating_1[]" placeholder="0.00" required></td>
            <td><input type="number" class="form-control rating-input" name="supervisor_rating_2[]" placeholder="0.00" required></td>
            <td><input type="url" class="form-control" name="supervisor_evidence_link[]" placeholder="https://example.com/evidence" pattern="https?://.+" required></td>
            <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
        `;
        tableBody.appendChild(row);
    });
}

function populateStudentTable(studentData) {
    const tableBody = document.querySelector('#student-evaluation-table tbody');
    tableBody.innerHTML = ''; 

    if (!studentData || studentData.length === 0) {
        addDefaultStudentRows(tableBody);
        return;
    }

    studentData.forEach(item => {
        const tr = document.createElement('tr');
        tr.setAttribute('data-evaluation-id', item.evaluation_id);

        tr.innerHTML = `
            <td><input type="text" class="form-control" name="student_evaluation_period[]" value="${escapeHTML(item.evaluation_period || '')}" required></td>
            <td><input type="number" class="form-control rating-input" name="student_rating_1[]" value="${item.first_semester_rating || ''}" placeholder="0.00" required></td>
            <td><input type="number" class="form-control rating-input" name="student_rating_2[]" value="${item.second_semester_rating || ''}" placeholder="0.00" required></td>
            <td><input type="url" class="form-control" name="student_evidence_link[]" value="${escapeHTML(item.evidence_link_first || '')}" placeholder="https://example.com/evidence" pattern="https?://.+" required></td>
            <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="${escapeHTML(item.remarks_first || '')}" data-second-remark="${escapeHTML(item.remarks_second || '')}">View Remarks</button></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
        `;
        tableBody.appendChild(tr);
    });
}

function populateSupervisorTable(supervisorData) {
    const tableBody = document.querySelector('#supervisor-evaluation-table tbody');
    tableBody.innerHTML = '';

    if (!supervisorData || supervisorData.length === 0) {
        addDefaultSupervisorRows(tableBody);
        return;
    }

    supervisorData.forEach(item => {
        const tr = document.createElement('tr');
        tr.setAttribute('data-evaluation-id', item.evaluation_id);

        tr.innerHTML = `
            <td><input type="text" class="form-control" name="supervisor_evaluation_period[]" value="${escapeHTML(item.evaluation_period || '')}" required></td>
            <td><input type="number" class="form-control rating-input" name="supervisor_rating_1[]" value="${item.first_semester_rating || ''}" placeholder="0.00" required></td>
            <td><input type="number" class="form-control rating-input" name="supervisor_rating_2[]" value="${item.second_semester_rating || ''}" placeholder="0.00" required></td>
            <td><input type="url" class="form-control" name="supervisor_evidence_link[]" value="${escapeHTML(item.evidence_link_first || '')}" placeholder="https://example.com/evidence" pattern="https?://.+" required></td>
            <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="${escapeHTML(item.remarks_first || '')}" data-second-remark="${escapeHTML(item.remarks_second || '')}">View Remarks</button></td>
            <td><button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button></td>
        `;
        tableBody.appendChild(tr);
    });
}

function populateMetadata(metadata) {
    if (!metadata) {
        // Reset to defaults if no metadata
        document.getElementById('student-divisor').value = 0;
        document.getElementById('student-reason').value = '';
        document.getElementById('student-evidence-link').value = '';
        document.getElementById('supervisor-divisor').value = 0;
        document.getElementById('supervisor-reason').value = '';
        document.getElementById('supervisor-evidence-link').value = '';
        
        // Reset overall/faculty scores
        document.getElementById('student_overall_score').value = '';
        document.getElementById('student_faculty_overall_score').value = '';
        document.getElementById('supervisor-overall-score').value = '';
        document.getElementById('supervisor-faculty-overall-score').value = '';
        return;
    }

    // Populate student metadata fields
    document.getElementById('student-divisor').value = metadata.student_divisor || 0;
    document.getElementById('student-reason').value = metadata.student_reason || '';
    document.getElementById('student-evidence-link').value = metadata.student_evidence_link || '';

    // Populate supervisor metadata fields
    document.getElementById('supervisor-divisor').value = metadata.supervisor_divisor || 0;
    document.getElementById('supervisor-reason').value = metadata.supervisor_reason || '';
    document.getElementById('supervisor-evidence-link').value = metadata.supervisor_evidence_link || '';

    // Populate the overall/faculty ratings from metadata
    document.getElementById('student_overall_score').value = metadata.student_overall_rating || 0;
    document.getElementById('student_faculty_overall_score').value = metadata.student_faculty_rating || 0;
    document.getElementById('supervisor-overall-score').value = metadata.supervisor_overall_rating || 0;
    document.getElementById('supervisor-faculty-overall-score').value = metadata.supervisor_faculty_rating || 0;
}

function fetchCriterionA(requestId) {
    return fetch(`../../includes/career_progress_tracking/teaching/fetch_criterion_a.php?request_id=${requestId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateStudentTable(data.student_evaluations);
                populateSupervisorTable(data.supervisor_evaluations);
                populateMetadata(data.metadata);
                return data;
            } else {
                throw new Error(data.error || 'Failed to fetch Criterion A data.');
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}
// === FETCHING AND POPULATE END ===


document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('criterion-a-form');
    const saveBtn = document.getElementById('save-criterion-a');
    const saveSuccessModal = new bootstrap.Modal(document.getElementById('saveConfirmationModal'));
    const saveErrorModal = new bootstrap.Modal(document.getElementById('saveErrorModal'));

    // === SAVING PROCESS START ===
    saveBtn.addEventListener('click', function () {
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        calculateOverallScores();
        const requestId = document.getElementById('request_id').value.trim();

        if (!requestId || parseInt(requestId) <= 0) {
            showErrorModal('Please select a valid evaluation ID.');
            return;
        }

        const payload = gatherPayload(requestId);

        fetch('../../includes/career_progress_tracking/teaching/save_criterion_a.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                saveSuccessModal.show();
                const requestId = document.getElementById('request_id').value.trim();
                if (requestId) {
                    // Re-fetch data to ensure new rows get updated evaluation_id
                    fetchCriterionA(requestId);
                }
            } else {
                showErrorModal(data.error || 'An error occurred.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorModal('Failed to save data. Please check console for details.');
        });
    });

    function gatherPayload(requestId) {
        // Collect student evaluations
        const studentEvaluations = [];
        document.querySelectorAll('#student-evaluation-table tbody tr').forEach(row => {
            const evaluation_id = parseInt(row.getAttribute('data-evaluation-id') || 0, 10);
            const evaluation_period = row.querySelector('input[name="student_evaluation_period[]"]').value.trim();
            const rating1Input = row.querySelector('input[name="student_rating_1[]"]');
            const rating2Input = row.querySelector('input[name="student_rating_2[]"]');
            const evidence_link_first = row.querySelector('input[name="student_evidence_link[]"]').value.trim();
            const evidence_link_second = evidence_link_first; 
            const remarks_first = ''; 
            const remarks_second = ''; 

            studentEvaluations.push({
                evaluation_id,
                evaluation_period,
                first_semester_rating: parseFloat(rating1Input.value) || 0,
                second_semester_rating: parseFloat(rating2Input.value) || 0,
                evidence_link_first,
                evidence_link_second,
                remarks_first,
                remarks_second
            });
        });

        // Collect supervisor evaluations
        const supervisorEvaluations = [];
        document.querySelectorAll('#supervisor-evaluation-table tbody tr').forEach(row => {
            const evaluation_id = parseInt(row.getAttribute('data-evaluation-id') || 0, 10);
            const evaluation_period = row.querySelector('input[name="supervisor_evaluation_period[]"]').value.trim();
            const rating1Input = row.querySelector('input[name="supervisor_rating_1[]"]');
            const rating2Input = row.querySelector('input[name="supervisor_rating_2[]"]');
            const evidence_link_first = row.querySelector('input[name="supervisor_evidence_link[]"]').value.trim();
            const evidence_link_second = evidence_link_first;
            const remarks_first = '';
            const remarks_second = '';

            supervisorEvaluations.push({
                evaluation_id,
                evaluation_period,
                first_semester_rating: parseFloat(rating1Input.value) || 0,
                second_semester_rating: parseFloat(rating2Input.value) || 0,
                evidence_link_first,
                evidence_link_second,
                remarks_first,
                remarks_second
            });
        });

        // Now gather the metadata ratings from the top-level fields
        const student_overall_rating = parseFloat(document.getElementById('student_overall_score').value) || 0;
        const student_faculty_rating = parseFloat(document.getElementById('student_faculty_overall_score').value) || 0;
        const supervisor_overall_rating = parseFloat(document.getElementById('supervisor-overall-score').value) || 0;
        const supervisor_faculty_rating = parseFloat(document.getElementById('supervisor-faculty-overall-score').value) || 0;

        return {
            request_id: parseInt(requestId,10),
            student_divisor: parseInt(document.getElementById('student-divisor').value,10) || 0,
            student_reason: document.getElementById('student-reason').value,
            student_evidence_link: document.getElementById('student-evidence-link').value,
            supervisor_divisor: parseInt(document.getElementById('supervisor-divisor').value,10) || 0,
            supervisor_reason: document.getElementById('supervisor-reason').value,
            supervisor_evidence_link: document.getElementById('supervisor-evidence-link').value,
            student_evaluations: studentEvaluations,
            supervisor_evaluations: supervisorEvaluations,
            // Include new overall/faculty ratings in the payload as part of metadata
            student_overall_rating: student_overall_rating,
            student_faculty_rating: student_faculty_rating,
            supervisor_overall_rating: supervisor_overall_rating,
            supervisor_faculty_rating: supervisor_faculty_rating
        };
    }

    function showErrorModal(message) {
        document.querySelector('#saveErrorModal .modal-body').textContent = message;
        saveErrorModal.show();
    }
    // === SAVING PROCESS END ===


    // === ADD ROW FUNCTION START ===
    document.querySelectorAll('.add-row').forEach(addBtn => {
        addBtn.addEventListener('click', function() {
            const tableId = this.getAttribute('data-table-id');
            const tableBody = document.querySelector(`#${tableId} tbody`);
            
            // Determine if this is student or supervisor
            const isStudent = tableId.includes('student');
            const periodName = isStudent ? 'student_evaluation_period[]' : 'supervisor_evaluation_period[]';
            const rating1Name = isStudent ? 'student_rating_1[]' : 'supervisor_rating_1[]';
            const rating2Name = isStudent ? 'student_rating_2[]' : 'supervisor_rating_2[]';
            const evidenceLinkName = isStudent ? 'student_evidence_link[]' : 'supervisor_evidence_link[]';

            // Create a new row similar to the default row
            const newRow = document.createElement('tr');
            newRow.setAttribute('data-evaluation-id', '0'); // 0 means not saved yet

            newRow.innerHTML = `
                <td>
                    <input type="text" class="form-control" name="${periodName}" value="AY 2023 - 2024" required>
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
                    <button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                </td>
            `;

            tableBody.appendChild(newRow);

            // Recalculate scores if needed
            calculateOverallScores();
        });
    });
    // === ADD ROW FUNCTION END ===


    // === DELETE ROW FUNCTION START ===
    let rowToDelete = null;
    let evaluationIdToDelete = null;
    let tableToDeleteFrom = null;

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-row')) {
            rowToDelete = e.target.closest('tr');
            evaluationIdToDelete = rowToDelete.getAttribute('data-evaluation-id') || '0';

            // Determine which table the row belongs to
            const table = e.target.closest('table');
            if (table.id === 'student-evaluation-table') {
                tableToDeleteFrom = 'student';
            } else if (table.id === 'supervisor-evaluation-table') {
                tableToDeleteFrom = 'supervisor';
            } else {
                tableToDeleteFrom = null;
            }

            // Show confirmation modal
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteRowModal'));
            deleteModal.show();
        }
    });

    document.getElementById('confirm-delete-row').addEventListener('click', function() {
        if (rowToDelete) {
            if (evaluationIdToDelete !== '0' && tableToDeleteFrom) {
                // Row exists in DB, send delete request
                const payload = {
                    evaluation_id: evaluationIdToDelete,
                    table: tableToDeleteFrom
                };

                fetch('../../includes/career_progress_tracking/teaching/delete_criterion_a.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(response => response.json())
                .then(data => {
                    const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteRowModal'));
                    deleteModal.hide();
                    if (data.success) {
                        // Remove the row from the table
                        rowToDelete.remove();
                        rowToDelete = null;
                        evaluationIdToDelete = null;
                        tableToDeleteFrom = null;

                        // Show success message
                        const successModal = new bootstrap.Modal(document.getElementById('deleteSuccessModal'));
                        successModal.show();

                        // Recalculate if needed
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
                    const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteRowModal'));
                    deleteModal.hide();

                    const errorModal = new bootstrap.Modal(document.getElementById('deleteErrorModal'));
                    document.querySelector('#deleteErrorModal .modal-body').textContent = 'An unexpected error occurred.';
                    errorModal.show();
                });
            } else {
                // evaluation_id = 0 means never saved, just remove row from DOM
                const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteRowModal'));
                deleteModal.hide();

                rowToDelete.remove();
                rowToDelete = null;
                evaluationIdToDelete = null;
                tableToDeleteFrom = null;

                // Recalculate if needed
                calculateOverallScores();

                // Optionally show success modal for deletion
                const successModal = new bootstrap.Modal(document.getElementById('deleteSuccessModal'));
                successModal.show();
            }
        }
    });
    // === DELETE ROW FUNCTION END ===


    // === CALCULATION START ===
    function calculateOverallScores() {
        const calculateSectionScores = (divisorId, reasonId, overallScoreId, facultyScoreId, multiplier) => {
            const divisorSelect = document.getElementById(divisorId);
            let divisor = parseInt(divisorSelect.value, 10);
            if (isNaN(divisor) || divisor < 0 || divisor > 8) divisor = 0;
            const reasonSelect = document.getElementById(reasonId);
            const reason = reasonSelect.value;
            const sectionPrefix = divisorId.includes('student') ? 'student' : 'supervisor';
            const evaluationTable = document.getElementById(`${sectionPrefix}-evaluation-table`);
            const ratingInputs = evaluationTable.querySelectorAll(`input[name="${sectionPrefix}_rating_1[]"], input[name="${sectionPrefix}_rating_2[]"]`);

            let totalRating = 0;
            let ratingCount = 0;
            ratingInputs.forEach(input => {
                const val = parseFloat(input.value);
                if (!isNaN(val)) {
                    totalRating += val;
                    ratingCount++;
                }
            });

            let overallAverageRating = 0;
            if ((reason === '' || reason === 'not_applicable') || divisor === 0) {
                if (ratingCount > 0) overallAverageRating = totalRating / ratingCount;
            } else {
                const denominator = 8 - divisor;
                if (denominator > 0) overallAverageRating = totalRating / denominator;
            }

            const facultyScore = overallAverageRating * multiplier;
            document.getElementById(overallScoreId).value = overallAverageRating.toFixed(2);
            document.getElementById(facultyScoreId).value = facultyScore.toFixed(2);
        };

        calculateSectionScores('student-divisor','student-reason','student_overall_score','student_faculty_overall_score',0.36);
        calculateSectionScores('supervisor-divisor','supervisor-reason','supervisor-overall-score','supervisor-faculty-overall-score',0.24);
    }
    
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('rating-input')) {
            calculateOverallScores();
        }
    });

    document.addEventListener('change', function (e) {
        if (e.target.matches('#student-divisor, #student-reason, #supervisor-divisor, #supervisor-reason')) {
            calculateOverallScores();
        }
    });

    // Initial calculation run
    calculateOverallScores();
    // === CALCULATION END ===

    // No automatic fetch on page load. fetchCriterionA is called from teaching.js after evaluation selected.
});

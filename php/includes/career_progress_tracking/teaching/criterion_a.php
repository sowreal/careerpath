<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_a.php -->
<div class="tab-pane fade show active criterion-tab" id="criterion-a" role="tabpanel" aria-labelledby="tab-criterion-a">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION A: Teaching Effectiveness (Max = 60 Points)</strong></h4>
    
    <h5><strong>1. FACULTY PERFORMANCE:</strong> Enter the average rating received by the faculty per semester.<br>  
    For newly appointed faculty from private HEI, LUCs, TESDA/DepEd schools who decide to proceed with the evaluation, 
    enter "0" for semesters without student and supervisor evaluations.
    </h5>

    <div class="row">
        <!-- Student Evaluation Section -->
        <div class="col-12 mt-5">
            <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.1 Student Evaluation (60%)</h5>

            <!-- Divisor Selection -->
            <div class="row g-4 align-items-center mb-4">
                <!-- Number of Semesters to Deduct -->
                <div class="col-md-4">
                    <label for="student-divisor" class="form-label">Number of Semesters to Deduct from Divisor (if applicable):</label>
                    <select class="form-select" id="student-divisor" name="student_divisor">
                        <?php for ($i = 0; $i <= 8; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- Reason for Reducing the Divisor -->
                <div class="col-md-4">
                    <label for="student-reason" class="form-label">Reason for Reducing the Divisor:</label>
                    <select class="form-select" id="student-reason" name="student_reason" required>
                        <option value="">Select Option</option>
                        <option value="Not Applicable">Not Applicable</option>
                        <option value="On Approved Study Leave">On Approved Study Leave</option>
                        <option value="On Approved Sabbatical Leave">On Approved Sabbatical Leave</option>
                        <option value="On Approved Maternity Leave">On Approved Maternity Leave</option>
                    </select>
                </div>

                <!-- Link to Evidence -->
                <div class="col-md-4">
                    <label for="student-evidence-link" class="form-label">Link to Evidence:</label>
                    <input type="url" class="form-control" id="student-evidence-link" name="student_evidence_link" placeholder="https://example.com/evidence" required>
                </div>
            </div>

            <!-- Responsive Table -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="student-evaluation-table">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Evaluation Period</th>
                            <th scope="col">1st Semester Rating</th>
                            <th scope="col">2nd Semester Rating</th>
                            <th scope="col">Link to Evidence</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody><!-- 1st column row contents-->
                        <?php 
                            $evaluationPeriods = ["AY 2019 - 2020", "AY 2020 - 2021", "AY 2021 - 2022", "AY 2022 - 2023"];
                            foreach ($evaluationPeriods as $period): 
                        ?>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="student_evaluation_period[]" value="<?php echo htmlspecialchars($period); ?>" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control rating-input" name="student_rating_1[]" placeholder="0.00" step="0.01" min="0" max="5" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control rating-input" name="student_rating_2[]" placeholder="0.00" step="0.01" min="0" max="5" required>
                                </td>
                                <td>
                                    <input type="url" class="form-control" name="student_evidence_link[]" placeholder="https://example.com/evidence" required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm view-remarks"
                                        data-first-remark=""
                                        data-second-remark="">
                                        View Remarks
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Add Row Button -->
            <button type="button" class="btn btn-success mt-3 add-row" data-table-id="student-evaluation-table">Add Row</button>

            <!-- Overall Scores -->
            <div class="mt-5">
                <div class="row g-3 justify-content-end">
                    <div class="col-md-4">
                        <label for="student-overall-score" class="form-label"><strong>Overall Average Rating:</strong></label>
                        <input type="number" class="form-control" id="student-overall-score" name="student_overall_score" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="faculty-overall-score" class="form-label"><strong>Faculty Score:</strong></label>
                        <input type="number" class="form-control" id="faculty-overall-score" name="faculty_overall_score" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Supervisor's Evaluation Section -->
        <div class="col-12 mt-5">
            <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.2 Supervisor's Evaluation (40%)</h5>

            <!-- Divisor Selection -->
            <div class="row g-4 align-items-center mb-4">
                <!-- Number of Semesters to Deduct -->
                <div class="col-md-4">
                    <label for="supervisor-divisor" class="form-label">Number of Semesters to Deduct from Divisor (if applicable):</label>
                    <select class="form-select" id="supervisor-divisor" name="supervisor_divisor">
                        <?php for ($i = 0; $i <= 8; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <!-- Reason for Reducing the Divisor -->
                <div class="col-md-4">
                    <label for="supervisor-reason" class="form-label">Reason for Reducing the Divisor:</label>
                    <select class="form-select" id="supervisor-reason" name="supervisor_reason" required>
                        <option value="">Select Option</option>
                        <option value="Not Applicable">Not Applicable</option>
                        <option value="On Approved Study Leave">On Approved Study Leave</option>
                        <option value="On Approved Sabbatical Leave">On Approved Sabbatical Leave</option>
                        <option value="On Approved Maternity Leave">On Approved Maternity Leave</option>
                    </select>
                </div>

                <!-- Link to Evidence -->
                <div class="col-md-4">
                    <label for="supervisor-evidence-link" class="form-label">Link to Evidence:</label>
                    <input type="url" class="form-control" id="supervisor-evidence-link" name="supervisor_evidence_link" placeholder="https://example.com/evidence" required>
                </div>
            </div>

            <!-- Responsive Table -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="supervisor-evaluation-table">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Evaluation Period</th>
                            <th scope="col">1st Semester Rating</th>
                            <th scope="col">2nd Semester Rating</th>
                            <th scope="col">Link to Evidence</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($evaluationPeriods as $period): ?>
                            <tr>
                                <td>
                                    <input type="text" class="form-control" name="supervisor_evaluation_period[]" value="<?php echo htmlspecialchars($period); ?>" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control rating-input" name="supervisor_rating_1[]" placeholder="0.00" step="0.01" min="0" max="5" required>
                                </td>
                                <td>
                                    <input type="number" class="form-control rating-input" name="supervisor_rating_2[]" placeholder="0.00" step="0.01" min="0" max="5" required>
                                </td>
                                <td>
                                    <input type="url" class="form-control" name="supervisor_evidence_link[]" placeholder="http://example.com/evidence" required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm view-remarks"
                                        data-first-remark=""
                                        data-second-remark="">
                                        View Remarks
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Add Row Button -->
            <button type="button" class="btn btn-success mt-3 add-row" data-table-id="supervisor-evaluation-table">Add Row</button>

            <!-- Overall Scores -->
            <div class="mt-5">
                <div class="row g-3 justify-content-end">
                    <div class="col-md-4">
                        <label for="supervisor-overall-score" class="form-label"><strong>Overall Average Rating:</strong></label>
                        <input type="number" class="form-control" id="supervisor-overall-score" name="supervisor_overall_score" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="supervisor-faculty-overall-score" class="form-label"><strong>Faculty Score:</strong></label>
                        <input type="number" class="form-control" id="supervisor-faculty-overall-score" name="supervisor_faculty_overall_score" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="d-flex justify-content-end mt-5">
        <button type="button" class="btn btn-success" id="save-criterion-a">Save Criterion A</button>
    </div>

</div>



<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteRowModal" tabindex="-1" aria-labelledby="deleteRowModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="deleteRowModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this row? This action cannot be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirm-delete-row">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Save Confirmation Modal -->
<div class="modal fade" id="saveConfirmationModal" tabindex="-1" aria-labelledby="saveConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="saveConfirmationModalLabel">Save Successful</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Criterion A has been saved successfully!
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Save Error Modal -->
<div class="modal fade" id="saveErrorModal" tabindex="-1" aria-labelledby="saveErrorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="saveErrorModalLabel">Save Failed</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Dynamic error message will be inserted here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Remarks Modal -->
<div class="modal fade" id="remarksModal" tabindex="-1" aria-labelledby="remarksModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="remarksModalLabel">Remarks</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>First Semester:</strong></p>
        <p id="first-semester-remark"></p>
        <p><strong>Second Semester:</strong></p>
        <p id="second-semester-remark"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>



<script>
    // Helper function to add template rows
    function addTemplateRow(tableId, periods = []) {
        const tableBody = document.querySelector(`#${tableId} tbody`);

        if (Array.isArray(periods) && periods.length > 0) {
            periods.forEach(period => {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td>
                        <input type="text" class="form-control" name="${tableId === 'student-evaluation-table' ? 'student_evaluation_period[]' : 'supervisor_evaluation_period[]'}" value="${period}" required>
                    </td>
                    <td>
                        <input type="number" class="form-control rating-input" name="${tableId === 'student-evaluation-table' ? 'student_rating_1[]' : 'supervisor_rating_1[]'}" placeholder="0.00" step="0.01" min="0" max="5" required>
                    </td>
                    <td>
                        <input type="number" class="form-control rating-input" name="${tableId === 'student-evaluation-table' ? 'student_rating_2[]' : 'supervisor_rating_2[]'}" placeholder="0.00" step="0.01" min="0" max="5" required>
                    </td>
                    <td>
                        <input type="url" class="form-control" name="${tableId === 'student-evaluation-table' ? 'student_evidence_link[]' : 'supervisor_evidence_link[]'}" placeholder="https://example.com/evidence" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm view-remarks"
                            data-first-remark=""
                            data-second-remark="">
                            View Remarks
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                    </td>
                `;
                tableBody.appendChild(newRow);
            });
        } else {
            // Add a single row with empty Evaluation Period
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <input type="text" class="form-control" name="${tableId === 'student-evaluation-table' ? 'student_evaluation_period[]' : 'supervisor_evaluation_period[]'}" placeholder="Enter Evaluation Period" required>
                </td>
                <td>
                    <input type="number" class="form-control rating-input" name="${tableId === 'student-evaluation-table' ? 'student_rating_1[]' : 'supervisor_rating_1[]'}" placeholder="0.00" step="0.01" min="0" max="5" required>
                </td>
                <td>
                    <input type="number" class="form-control rating-input" name="${tableId === 'student-evaluation-table' ? 'student_rating_2[]' : 'supervisor_rating_2[]'}" placeholder="0.00" step="0.01" min="0" max="5" required>
                </td>
                <td>
                    <input type="url" class="form-control" name="${tableId === 'student-evaluation-table' ? 'student_evidence_link[]' : 'supervisor_evidence_link[]'}" placeholder="https://example.com/evidence" required>
                </td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm view-remarks"
                        data-first-remark=""
                        data-second-remark="">
                        View Remarks
                    </button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row" aria-label="Delete row">Delete</button>
                </td>
            `;
            tableBody.appendChild(newRow);
        }
    }

    // Populate Criterion A tables if data exists
    function populateFields(data) {
        // Clear existing rows in the tables
        clearTables();

        // Define default Evaluation Periods starting from "AY 2020-2021"
        const defaultPeriods = ["AY 2020 - 2021", "AY 2021 - 2022", "AY 2022 - 2023", "AY 2023 - 2024"];

        // Populate student evaluations
        const studentEvaluations = data.student_evaluations;
        const studentTableBody = document.querySelector('#student-evaluation-table tbody');

        if (studentEvaluations && studentEvaluations.length > 0) {
            studentEvaluations.forEach(eval => {
                addTemplateRow('student-evaluation-table', [eval.evaluation_period]);
                const lastRow = studentTableBody.lastElementChild;
                lastRow.querySelector('input[name="student_rating_1[]"]').value = eval.first_semester_rating;
                lastRow.querySelector('input[name="student_rating_2[]"]').value = eval.second_semester_rating;
                lastRow.querySelector('input[name="student_evidence_link[]"]').value = eval.evidence_link_first_semester;
                lastRow.querySelector('input[name="student_remarks[]"]').value = `${eval.remarks_first_semester || ''} | ${eval.remarks_second_semester || ''}`;
                lastRow.querySelector('.view-remarks').setAttribute('data-first-remark', eval.remarks_first_semester || '');
                lastRow.querySelector('.view-remarks').setAttribute('data-second-remark', eval.remarks_second_semester || '');
            });
        } else {
            // Add four default template rows if no student evaluations exist
            addTemplateRow('student-evaluation-table', defaultPeriods);
        }

        // Populate supervisor evaluations
        const supervisorEvaluations = data.supervisor_evaluations;
        const supervisorTableBody = document.querySelector('#supervisor-evaluation-table tbody');

        if (supervisorEvaluations && supervisorEvaluations.length > 0) {
            supervisorEvaluations.forEach(eval => {
                addTemplateRow('supervisor-evaluation-table', [eval.evaluation_period]);
                const lastRow = supervisorTableBody.lastElementChild;
                lastRow.querySelector('input[name="supervisor_rating_1[]"]').value = eval.first_semester_rating;
                lastRow.querySelector('input[name="supervisor_rating_2[]"]').value = eval.second_semester_rating;
                lastRow.querySelector('input[name="supervisor_evidence_link[]"]').value = eval.evidence_link_first_semester;
                lastRow.querySelector('input[name="supervisor_remarks[]"]').value = `${eval.remarks_first_semester || ''} | ${eval.remarks_second_semester || ''}`;
                lastRow.querySelector('.view-remarks').setAttribute('data-first-remark', eval.remarks_first_semester || '');
                lastRow.querySelector('.view-remarks').setAttribute('data-second-remark', eval.remarks_second_semester || '');
            });
        } else {
            // Add four default template rows if no supervisor evaluations exist
            addTemplateRow('supervisor-evaluation-table', defaultPeriods);
        }

        // Recalculate scores
        calculateOverallScores();
    }

    // Function for clearing tables
    function clearTables() {
        document.querySelector('#student-evaluation-table tbody').innerHTML = '';
        document.querySelector('#supervisor-evaluation-table tbody').innerHTML = '';
    }

    // Calculate Overall Scores
    const calculateOverallScores = () => {
        // Student Evaluation Calculations
        let studentTotal = 0;
        let studentCount = 0;
        document.querySelectorAll('#student-evaluation-table tbody tr').forEach(row => {
            const rating1 = parseFloat(row.querySelector('input[name="student_rating_1[]"]').value) || 0;
            const rating2 = parseFloat(row.querySelector('input[name="student_rating_2[]"]').value) || 0;
            const average = (rating1 + rating2) / 2;
            studentTotal += average;
            studentCount++;
        });
        const studentAverage = studentCount ? (studentTotal / studentCount).toFixed(2) : 0;
        document.getElementById('student-overall-score').value = studentAverage;
        document.getElementById('faculty-overall-score').value = (studentAverage * 0.36).toFixed(2);

        // Supervisor Evaluation Calculations
        let supervisorTotal = 0;
        let supervisorCount = 0;
        document.querySelectorAll('#supervisor-evaluation-table tbody tr').forEach(row => {
            const rating1 = parseFloat(row.querySelector('input[name="supervisor_rating_1[]"]').value) || 0;
            const rating2 = parseFloat(row.querySelector('input[name="supervisor_rating_2[]"]').value) || 0;
            const average = (rating1 + rating2) / 2;
            supervisorTotal += average;
            supervisorCount++;
        });
        const supervisorAverage = supervisorCount ? (supervisorTotal / supervisorCount).toFixed(2) : 0;
        document.getElementById('supervisor-overall-score').value = supervisorAverage;
        document.getElementById('supervisor-faculty-overall-score').value = (supervisorAverage * 0.4).toFixed(2);
    };

    document.addEventListener('DOMContentLoaded', () => {
        const addRowButtons = document.querySelectorAll('.add-row');
        let deleteRowTarget = null;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteRowModal'));
        const saveConfirmationModal = new bootstrap.Modal(document.getElementById('saveConfirmationModal'));
        const saveErrorModal = new bootstrap.Modal(document.getElementById('saveErrorModal'));

        // Removed the redundant createTableRow function to avoid conflicts

        // Add row event listeners
        addRowButtons.forEach(button => {
            button.addEventListener('click', () => {
                const tableId = button.getAttribute('data-table-id');
                addTemplateRow(tableId); // Add a single row
                setTimeout(calculateOverallScores, 100); // Recalculate after adding row
            });
        });

        // Delegate delete button clicks
        document.addEventListener('click', (e) => {
            if (e.target && e.target.classList.contains('delete-row')) {
                deleteRowTarget = e.target.closest('tr');
                deleteModal.show();
            }
        });

        // Confirm deletion
        document.getElementById('confirm-delete-row').addEventListener('click', () => {
            if (deleteRowTarget) {
                deleteRowTarget.remove();
                deleteRowTarget = null;
                deleteModal.hide();
                calculateOverallScores();
            }
        });

        // Event listeners for input changes to recalculate scores
        document.addEventListener('input', (e) => {
            if (e.target.classList.contains('rating-input')) {
                calculateOverallScores();
            }
        });

        // Save Criterion A
        const saveCriterionA = document.getElementById('save-criterion-a');
        if (saveCriterionA) {
            saveCriterionA.addEventListener('click', () => {
                // Check if an evaluation is selected
                const requestId = document.getElementById('hidden-request-id').value;
                if (!requestId) {
                    // Show error modal
                    document.getElementById('saveErrorModalLabel').textContent = 'Save Failed';
                    document.querySelector('#saveErrorModal .modal-body').textContent = 'Please select an evaluation before saving.';
                    saveErrorModal.show();
                    return;
                }

                // Manual Validation of Required Fields within Criterion A
                let isValid = true;

                // Collect all input fields and selects within Criterion A
                const criterionAFields = document.querySelectorAll('#criterion-a input, #criterion-a select');
                criterionAFields.forEach(field => {
                    const value = field.value.trim();

                    // Basic non-empty validation for required fields
                    if (field.hasAttribute('required') && !value) {
                        field.classList.add('is-invalid');
                        isValid = false;
                        return; 
                    }

                    // Additional validation for URL fields
                    if (field.type === 'url' && field.hasAttribute('required')) {
                        const urlPattern = /^(https?:\/\/).+/;
                        if (!urlPattern.test(value)) {
                            field.classList.add('is-invalid');
                            isValid = false;
                            return;
                        }
                    }

                    // Remove invalid class if validation passes
                    field.classList.remove('is-invalid');
                });

                if (isValid) {
                    // Prepare data for saving
                    const userId = window.userId;
                    const criterionAData = {};

                    // Collect all field values
                    criterionAFields.forEach(field => {
                        const name = field.name;
                        const value = field.value.trim();

                        if (name.endsWith('[]')) {
                            const key = name.slice(0, -2);
                            if (!criterionAData[key]) {
                                criterionAData[key] = [];
                            }
                            criterionAData[key].push(value);
                        } else {
                            criterionAData[name] = value;
                        }
                    });

                    // Log data being sent
                    console.log('criterionAData:', criterionAData);

                    // Add user_id and request_id
                    criterionAData['user_id'] = userId;
                    criterionAData['request_id'] = requestId;

                    // Send data to the backend via AJAX
                    fetch('../../includes/career_progress_tracking/teaching/save_criterion_a.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(criterionAData),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success modal
                                saveConfirmationModal.show();
                            } else {
                                // Show error modal
                                document.getElementById('saveErrorModalLabel').textContent = 'Save Failed';
                                document.querySelector('#saveErrorModal .modal-body').textContent = data.error || 'An unexpected error occurred.';
                                saveErrorModal.show();
                            }
                        })
                        .catch(err => {
                            console.error('Error saving data:', err);
                            // Show error modal
                            document.getElementById('saveErrorModalLabel').textContent = 'Save Failed';
                            document.querySelector('#saveErrorModal .modal-body').textContent = 'A network error occurred. Please try again.';
                            saveErrorModal.show();
                        });
                } else {
                    // Show validation error modal
                    document.getElementById('saveErrorModalLabel').textContent = 'Save Failed';
                    document.querySelector('#saveErrorModal .modal-body').textContent = 'Please complete all required fields before saving.';
                    saveErrorModal.show();
                }
            });
        }

    });

    // Event listener for View Remarks buttons
    document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('view-remarks')) {
        const firstRemark = e.target.getAttribute('data-first-remark') || 'No remark for first semester.';
        const secondRemark = e.target.getAttribute('data-second-remark') || 'No remark for second semester.';

        // Set the modal content
        document.getElementById('first-semester-remark').textContent = firstRemark;
        document.getElementById('second-semester-remark').textContent = secondRemark;

        // Show the modal
        const remarksModal = new bootstrap.Modal(document.getElementById('remarksModal'));
        remarksModal.show();
    }
    });
</script>
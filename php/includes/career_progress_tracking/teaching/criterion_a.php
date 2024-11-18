<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_a.php -->
<div class="tab-pane fade show active" id="criterion-a" role="tabpanel" aria-labelledby="tab-criterion-a">
    <h4 class="mb-3 pb-2 border-bottom border-3 border-success">CRITERION A: Teaching Effectiveness (Max = 60 Points)</h4>
    <p>
        <strong>FACULTY PERFORMANCE:</strong> Enter the average rating received by the faculty per semester.<br>  
        For newly appointed faculty from private HEI, LUCs, TESDA/DepEd schools who decide to proceed with the evaluation, enter "0" for semesters without student and supervisor evaluations.
    </p>

    <div class="row">
        <!-- Student Evaluation Section -->
        <div class="col-12 mt-4">
            <h5 class="mb-3 pb-1 border-bottom border-2 border-success">1.1 Student Evaluation (60%)</h5>

            <!-- Divisor Selection -->
            <div class="row g-3 align-items-center mb-3">
                <div class="col-md-6">
                    <label for="student-divisor" class="form-label">Number of Semesters to Deduct from Divisor (if applicable):</label>
                    <select class="form-select" id="student-divisor">
                        <?php for ($i = 0; $i <= 8; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="student-reason" class="form-label">Reason for Reducing the Divisor:</label>
                    <select class="form-select" id="student-reason" required>
                        <option value="">Select Option</option>
                        <option value="not_applicable">Not Applicable</option>
                        <option value="on_approved_study_leave">On Approved Study Leave</option>
                        <option value="on_approved_sabbatical_leave">On Approved Sabbatical Leave</option>
                        <option value="on_approved_maternity_leave">On Approved Maternity Leave</option>
                    </select>
                </div>
            </div>

            <!-- Responsive Table -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="student-evaluation-table">
                    <thead class="table-light">
                        <tr class="align-middle">
                            <th>Evaluation Period</th>
                            <th>1st Semester Rating</th>
                            <th>2nd Semester Rating</th>
                            <th>Link to Evidence</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Existing Rows -->
                        <?php 
                            $evaluationPeriods = ["AY 2019-2020", "AY 2020-2021", "AY 2021-2022", "AY 2022-2023"];
                            foreach ($evaluationPeriods as $period): 
                        ?>
                            <tr class="align-middle">
                                <td>
                                    <input type="text" class="form-control" name="evaluation_period[]" value="<?php echo $period; ?>" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="student_rating_1[]" placeholder="0.00" step="0.01" min="0" max="5">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="student_rating_2[]" placeholder="0.00" step="0.01" min="0" max="5">
                                </td>
                                <td>
                                    <input type="url" class="form-control" name="student_evidence_link[]" placeholder="http://">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="student_remarks[]" placeholder="Enter remarks">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Add Row Button -->
            <button type="button" class="btn btn-success mt-3 add-row" data-table-id="student-evaluation-table">Add Row</button>

            <!-- Overall Scores -->
            <div class="mt-4">
                <div class="row g-3 justify-content-end">
                    <div class="col-md-4">
                        <label for="student-overall-score" class="form-label">Overall Average Rating:</label>
                        <input type="number" class="form-control" id="student-overall-score" value="" disabled>
                    </div>
                    <div class="col-md-4">
                        <label for="faculty-overall-score" class="form-label">Faculty Score:</label>
                        <input type="number" class="form-control" id="faculty-overall-score" value="" disabled>
                    </div>
                </div>
            </div>
        </div>

        <!-- Supervisor's Evaluation Section -->
        <div class="col-12 mt-5">
            <h5 class="mb-3 pb-2 border-bottom border-2 border-success">1.2 Supervisor's Evaluation (40%)</h5>

            <!-- Divisor Selection -->
            <div class="row g-3 align-items-center mb-3">
                <div class="col-md-6">
                    <label for="supervisor-divisor" class="form-label">Number of Semesters to Deduct from Divisor (if applicable):</label>
                    <select class="form-select" id="supervisor-divisor">
                        <?php for ($i = 0; $i <= 8; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="supervisor-reason" class="form-label">Reason for Reducing the Divisor:</label>
                    <select class="form-select" id="supervisor-reason" required>
                        <option value="">Select Option</option>
                        <option value="not_applicable">Not Applicable</option>
                        <option value="on_approved_study_leave">On Approved Study Leave</option>
                        <option value="on_approved_sabbatical_leave">On Approved Sabbatical Leave</option>
                        <option value="on_approved_maternity_leave">On Approved Maternity Leave</option>
                    </select>
                </div>
            </div>

            <!-- Responsive Table -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle" id="supervisor-evaluation-table">
                    <thead class="table-light">
                        <tr class="align-middle">
                            <th>Evaluation Period</th>
                            <th>1st Semester Rating</th>
                            <th>2nd Semester Rating</th>
                            <th>Link to Evidence</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($evaluationPeriods as $period): ?>
                            <tr class="align-middle">
                                <td>
                                    <input type="text" class="form-control" name="supervisor_evaluation_period[]" value="<?php echo $period; ?>" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="supervisor_rating_1[]" placeholder="0.00" step="0.01" min="0" max="5">
                                </td>
                                <td>
                                    <input type="number" class="form-control" name="supervisor_rating_2[]" placeholder="0.00" step="0.01" min="0" max="5">
                                </td>
                                <td>
                                    <input type="url" class="form-control" name="supervisor_evidence_link[]" placeholder="http://">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Add Row Button -->
            <button type="button" class="btn btn-success mt-3 add-row" data-table-id="supervisor-evaluation-table">Add Row</button>

            <!-- Overall Scores -->
            <div class="mt-4">
                <div class="row g-3 justify-content-end">
                    <div class="col-md-4">
                        <label for="supervisor-overall-score" class="form-label">Overall Average Rating:</label>
                        <input type="number" class="form-control" id="supervisor-overall-score" value="" disabled>
                    </div>
                    <div class="col-md-4">
                        <label for="supervisor-faculty-overall-score" class="form-label">Faculty Score:</label>
                        <input type="number" class="form-control" id="supervisor-faculty-overall-score" value="" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="d-flex justify-content-end mt-4">
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

<script>
    // JavaScript code to handle dynamic rows
document.addEventListener('DOMContentLoaded', function () {
    const addRowButtons = document.querySelectorAll('.add-row');
    let deleteRowTarget;

    addRowButtons.forEach(button => {
        button.addEventListener('click', function () {
            const tableId = this.getAttribute('data-table-id');
            const tableBody = document.querySelector(`#${tableId} tbody`);
            const newRow = document.createElement('tr');
            newRow.classList.add('align-middle');
            newRow.innerHTML = `
                <td>
                    <input type="text" class="form-control" name="${tableId}-evaluation_period[]" placeholder="Enter Evaluation Period">
                </td>
                <td>
                    <input type="number" class="form-control" name="${tableId}-rating_1[]" placeholder="0.00" step="0.01" min="0" max="5">
                </td>
                <td>
                    <input type="number" class="form-control" name="${tableId}-rating_2[]" placeholder="0.00" step="0.01" min="0" max="5">
                </td>
                <td>
                    <input type="url" class="form-control" name="${tableId}-evidence_link[]" placeholder="http://">
                </td>
                <td>
                    <input type="text" class="form-control" name="${tableId}-remarks[]" placeholder="Enter remarks">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                </td>
            `;
            tableBody.appendChild(newRow);
        });
    });

    // Delete row with confirmation
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('delete-row')) {
            deleteRowTarget = e.target.closest('tr');
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteRowModal'));
            deleteModal.show();
        }
    });

    document.getElementById('confirm-delete-row').addEventListener('click', function () {
        if (deleteRowTarget) {
            deleteRowTarget.remove();
            deleteRowTarget = null;
            const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteRowModal'));
            deleteModal.hide();
        }
    });

    // Additional JavaScript for calculations and validations can be added here
});

</script>
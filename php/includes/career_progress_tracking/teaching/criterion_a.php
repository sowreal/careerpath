<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_a.php -->
<div class="tab-pane fade show active criterion-tab" id="criterion-a" role="tabpanel" aria-labelledby="tab-criterion-a">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION A: Teaching Effectiveness (Max = 60 Points)</strong></h4>
    
    <h5><strong>1. FACULTY PERFORMANCE:</strong> Enter the average rating received by the faculty per semester.<br>  
    For newly appointed faculty from private HEI, LUCs, TESDA/DepEd schools who decide to proceed with the evaluation, 
    enter "0" for semesters without student and supervisor evaluations.
    </h5>

    <form id="criterion-a-form">
        <div class="row">
        <!-- Hidden Input for request_id -->
        <input type="hidden" id="request_id" name="request_id" value="" readonly>

            <!-- Student Evaluation Section -->
            <div class="col-12 mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.1 Student Evaluation (60%)</h5>

                <!-- Divisor Selection -->
                <div class="row g-4 align-items-center mb-4">
                    <div class="col-md-4">
                        <label for="student-divisor" class="form-label">Number of Semesters to Deduct from Divisor (if applicable):</label>
                        <select class="form-select" id="student-divisor" name="student_divisor">
                            <?php for ($i = 0; $i <= 7; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="student-reason" class="form-label">Reason for Reducing the Divisor:</label>
                        <select class="form-select" id="student-reason" name="student_reason" required>
                            <option value="">Select Option</option>
                            <option value="0">Not Applicable</option>
                            <option value="1">On Approved Study Leave</option>
                            <option value="2">On Approved Sabbatical Leave</option>
                            <option value="3">On Approved Maternity Leave</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid option.
                        </div>
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
                        <tbody>
                            <?php 
                                $evaluationPeriods = ["AY 2019 - 2020", "AY 2020 - 2021", "AY 2021 - 2022", "AY 2022 - 2023"];
                                foreach ($evaluationPeriods as $period): 
                            ?>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" name="student_evaluation_period[]" value="<?php echo htmlspecialchars($period); ?>">
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
                            <label for="student_overall_score" class="form-label"><strong>Overall Average Rating:</strong></label>
                            <input type="number" class="form-control" id="student_overall_score" name="student_overall_score" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="student_faculty_overall_score" class="form-label"><strong>Faculty Score:</strong></label>
                            <input type="number" class="form-control" id="student_faculty_overall_score" name="student_faculty_overall_score" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Supervisor's Evaluation Section -->
            <div class="col-12 mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.2 Supervisor's Evaluation (40%)</h5>

                <!-- Divisor Selection -->
                <div class="row g-4 align-items-center mb-4">
                    <div class="col-md-4">
                        <label for="supervisor-divisor" class="form-label">Number of Semesters to Deduct from Divisor (if applicable):</label>
                        <select class="form-select" id="supervisor-divisor" name="supervisor_divisor">
                            <?php for ($i = 0; $i <= 7; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="supervisor-reason" class="form-label">Reason for Reducing the Divisor:</label>
                        <select class="form-select" id="supervisor-reason" name="supervisor_reason" required>
                            <option value="">Select Option</option>
                            <option value="0">Not Applicable</option>
                            <option value="1">On Approved Study Leave</option>
                            <option value="2">On Approved Sabbatical Leave</option>
                            <option value="3">On Approved Maternity Leave</option>
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
                                        <input type="text" class="form-control" name="supervisor_evaluation_period[]" value="<?php echo htmlspecialchars($period); ?>">
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
                            <input type="number" class="form-control" id="supervisor-overall-score" name="supervisor-overall-score" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="supervisor-faculty-overall-score" class="form-label"><strong>Faculty Score:</strong></label>
                            <input type="number" class="form-control" id="supervisor-faculty-overall-score" name="supervisor-faculty-overall-score" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-end mt-5">
            <button type="button" class="btn btn-success" id="save-criterion-a">Save Criterion A</button>
        </div>
    </form>
</div>



<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteRowModal" tabindex="-1" aria-labelledby="deleteRowModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> 
        <h5 class="modal-title" id="deleteRowModalLabel">Confirm Deletion</h5>
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

<!-- Delete Success Modal -->
<div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-labelledby="deleteSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> 
        <h5 class="modal-title" id="deleteSuccessModalLabel">Deletion Successful</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        The row has been successfully deleted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Error Modal -->
<div class="modal fade" id="deleteErrorModal" tabindex="-1" aria-labelledby="deleteErrorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header"> 
        <h5 class="modal-title" id="deleteErrorModalLabel">Deletion Failed</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Error message will be injected here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
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




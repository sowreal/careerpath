<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_a.php -->
<div class="tab-pane fade show active criterion-tab" id="criterion-a" role="tabpanel" aria-labelledby="tab-criterion-a">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION A: Teaching Effectiveness (Max = 60 Points)</strong></h4>
    
    <h5><strong>1. FACULTY PERFORMANCE:</strong> Enter the average rating received by the faculty per semester.<br>  
    For newly appointed faculty from private HEI, LUCs, TESDA/DepEd schools who decide to proceed with the evaluation, 
    enter "0" for semesters without student and supervisor evaluations.
    </h5>

    <form id="criterion-a-form">
        <div class="row">
            
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
                                        <input type="text" class="form-control" name="student_evaluation_period[]" value="<?php echo htmlspecialchars($period); ?>">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control rating-input" name="student_rating_1[]" placeholder="0.00" step="0.01" min="0" max="5" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control rating-input" name="student_rating_2[]" placeholder="0.00" step="0.01" min="0" max="5" required>
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
                                        <input type="text" class="form-control" name="supervisor_evaluation_period[]" value="<?php echo htmlspecialchars($period); ?>">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control rating-input" name="supervisor_rating_1[]" placeholder="0.00" step="0.01" min="0" max="5" required>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control rating-input" name="supervisor_rating_2[]" placeholder="0.00" step="0.01" min="0" max="5" required>
                                    </td>
                                    <td>
                                        <input type="url" class="form-control" name="supervisor_evidence_link[]" placeholder="http://example.com/evidence" pattern="https?://.+" required>
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

        <!-- Hidden Inputs for Calculated Fields -->
        <input type="hidden" name="student_overall_average[]" />
        <input type="hidden" name="student_faculty_rating[]" />
        <input type="hidden" name="supervisor_overall_average[]" />
        <input type="hidden" name="supervisor_faculty_overall_score[]" />

        <!-- Hidden Request ID -->
        <input type="hidden" id="hidden-request-id" name="request_id" value="<?php echo $_SESSION['request_id']; ?>">

        <!-- Save Button -->
        <div class="d-flex justify-content-end mt-5">
            <button type="button" class="btn btn-success" id="save-criterion-a">Save Criterion A</button>
        </div>
    </form>
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


<!-- Include Criterion A-specific JS -->
<script src="<?php echo BASE_URL; ?>/php/includes/career_progress_tracking/teaching/js/criterion_a.js"></script>
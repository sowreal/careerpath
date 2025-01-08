<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_a.php -->
<div class="tab-pane fade show active criterion-tab" id="criterion-a" role="tabpanel" aria-labelledby="tab-criterion-a">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION A: Teaching Effectiveness (Max = 60 Points)</strong></h4>
    
    <h5><strong>1. FACULTY PERFORMANCE:</strong> Enter the average rating received by the faculty per semester.<br>  
    For newly appointed faculty from private HEI, LUCs, TESDA/DepEd schools who decide to proceed with the evaluation, 
    enter "0" for semesters without student and supervisor evaluations.
    </h5>

    <form id="criterion-a-form" enctype="multipart/form-data">
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
                        <select class="form-select" id="student-divisor" name="student-divisor">
                            <?php for ($i = 0; $i <= 7; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="student-reason" class="form-label">Reason for Reducing the Divisor:</label>
                        <select class="form-select" id="student-reason" name="student-reason" required>
                            <option value="">Select Option</option>
                            <option value="not_applicable">Not Applicable</option>
                            <option value="study_leave">On Approved Study Leave</option>
                            <option value="sabbatical_leave">On Approved Sabbatical Leave</option>
                            <option value="maternity_leave">On Approved Maternity Leave</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a valid option.
                        </div>
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
                          <th scope="col">Evidence</th>
                          <th scope="col">Remarks</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $evaluationPeriods = $evaluationPeriods ?? ["AY 2019 - 2020", "AY 2020 - 2021", "AY 2021 - 2022", "AY 2022 - 2023"];
                          $request_id = $request_id ?? null;

                          foreach ($evaluationPeriods as $index => $period): 
                              // Fetch evaluation data from the database
                              // Example: Assuming $studentEvaluations is an associative array fetched from the database
                              $evaluation = $studentEvaluations[$index] ?? [];
                              $evaluation_id = $request_id ? $request_id . '_' . $period . '_student' : "default_" . $index . "_student"; 
                        ?>
                        <tr>
                          <td>
                            <input type="text" class="form-control" name="student_evaluation_period[]" value="<?php echo htmlspecialchars($period); ?>" readonly>
                          </td>
                          <td>
                            <input type="number" class="form-control rating-input" name="student_rating_1[]" placeholder="0.00" value="<?php echo htmlspecialchars($evaluation['first_semester_rating'] ?? ''); ?>" readonly>
                          </td>
                          <td>
                            <input type="number" class="form-control rating-input" name="student_rating_2[]" placeholder="0.00" value="<?php echo htmlspecialchars($evaluation['second_semester_rating'] ?? ''); ?>" readonly>
                          </td>
                          <td>
                            <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                                    data-request-id="<?php echo $request_id ?? ''; ?>" 
                                    data-evaluation-id="<?php echo $evaluation_id; ?>" 
                                    data-table-type="student">
                              View Evidence
                            </button>
                            <input type="hidden" name="evaluation_id[]" value="<?php echo $evaluation_id; ?>">
                            <input type="hidden" name="evidence_file_1[]" value="<?php echo htmlspecialchars($evaluation['evidence_file_1'] ?? ''); ?>">
                            <input type="hidden" name="evidence_file_2[]" value="<?php echo htmlspecialchars($evaluation['evidence_file_2'] ?? ''); ?>">
                          </td>
                          <td>
                            <button type="button" class="btn btn-success btn-sm add-remarks"
                                data-evaluation-id="<?php echo $evaluation_id; ?>" 
                                data-table-type="student"
                                data-first-remark="<?php echo htmlspecialchars($evaluation['remarks_first'] ?? ''); ?>"
                                data-second-remark="<?php echo htmlspecialchars($evaluation['remarks_second'] ?? ''); ?>">
                                Add Remarks
                            </button>
                          </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                </div>

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
                        <select class="form-select" id="supervisor-divisor" name="supervisor-divisor">
                            <?php for ($i = 0; $i <= 7; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="supervisor-reason" class="form-label">Reason for Reducing the Divisor:</label>
                        <select class="form-select" id="supervisor-reason" name="supervisor-reason" required>
                            <option value="">Select Option</option>
                            <option value="not_applicable">Not Applicable</option>
                            <option value="study_leave">On Approved Study Leave</option>
                            <option value="sabbatical_leave">On Approved Sabbatical Leave</option>
                            <option value="maternity_leave">On Approved Maternity Leave</option>
                        </select>
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
                        <th scope="col">Evidence</th> 
                        <th scope="col">Remarks</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        foreach ($evaluationPeriods as $index => $period): 
                            // Fetch evaluation data from the database
                            $evaluation = $supervisorEvaluations[$index] ?? [];
                            $evaluation_id = $request_id ? $request_id . '_' . $period . '_supervisor' : "default_" . $index . "_supervisor"; 
                      ?>
                      <tr>
                        <td>
                          <input type="text" class="form-control" name="supervisor_evaluation_period[]" value="<?php echo htmlspecialchars($period); ?>" readonly>
                        </td>
                        <td>
                          <input type="number" class="form-control rating-input" name="supervisor_rating_1[]" placeholder="0.00" value="<?php echo htmlspecialchars($evaluation['first_semester_rating'] ?? ''); ?>" readonly>
                        </td>
                        <td>
                          <input type="number" class="form-control rating-input" name="supervisor_rating_2[]" placeholder="0.00" value="<?php echo htmlspecialchars($evaluation['second_semester_rating'] ?? ''); ?>" readonly>
                        </td>
                        <td>
                          <button type="button" class="btn btn-success btn-sm upload-evidence-btn" 
                                  data-request-id="<?php echo $request_id ?? ''; ?>" 
                                  data-evaluation-id="<?php echo $evaluation_id; ?>" 
                                  data-table-type="supervisor">
                            Upload Evidence
                          </button>
                          <input type="hidden" name="evaluation_id[]" value="<?php echo $evaluation_id; ?>">
                          <input type="hidden" name="evidence_file_1[]" value="<?php echo htmlspecialchars($evaluation['evidence_file_1'] ?? ''); ?>">
                          <input type="hidden" name="evidence_file_2[]" value="<?php echo htmlspecialchars($evaluation['evidence_file_2'] ?? ''); ?>">
                        </td>
                        <td>
                          <button type="button" class="btn btn-success btn-sm view-remarks"
                              data-evaluation-id="<?php echo $evaluation_id; ?>" 
                              data-table-type="supervisor"
                              data-first-remark="<?php echo htmlspecialchars($evaluation['remarks_first'] ?? ''); ?>"
                              data-second-remark="<?php echo htmlspecialchars($evaluation['remarks_second'] ?? ''); ?>">
                              View Remarks
                          </button>
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

<!-- Save Confirmation Modal -->
<div class="modal fade" id="saveConfirmationModal" tabindex="-1" aria-labelledby="saveConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="saveConfirmationModalLabel">Save Successful</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
  <div class="modal-dialog">
    <form id="remarksForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="remarksModalLabel">Add/View Remarks</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="evaluation_id" id="modal_evaluation_id">
          <input type="hidden" name="table_type" id="modal_table_type">
          <!-- CSRF Token (Optional but Recommended) -->
          <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
          <div class="mb-3">
            <label for="firstRemark" class="form-label">First Remark</label>
            <textarea class="form-control" id="firstRemark" name="first_remark" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label for="secondRemark" class="form-label">Second Remark</label>
            <textarea class="form-control" id="secondRemark" name="second_remark" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="saveRemarksBtn">
            <span id="saveBtnText">Save Remarks</span>
            <span id="saveBtnSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </form>
  </div>
</div>



<script>
  $(document).ready(function() {
  // Handle Add Remarks button click
  $('.add-remarks').on('click', function() {
    const evaluationId = $(this).data('evaluation-id');
    const tableType = $(this).data('table-type');
    const firstRemark = $(this).data('first-remark');
    const secondRemark = $(this).data('second-remark');
    
    // Populate modal fields
    $('#modal_evaluation_id').val(evaluationId);
    $('#modal_table_type').val(tableType);
    $('#firstRemark').val(firstRemark);
    $('#secondRemark').val(secondRemark);
    
    // Set modal title
    $('#remarksModalLabel').text('Add Remarks');
    
    // Enable editing
    $('#firstRemark').prop('readonly', false);
    $('#secondRemark').prop('readonly', false);
    $('#saveRemarksBtn').show();
    
    // Show modal
    $('#remarksModal').modal('show');
  });

  // Handle View Remarks button click
  $('.view-remarks').on('click', function() {
    const evaluationId = $(this).data('evaluation-id');
    const tableType = $(this).data('table-type');
    const firstRemark = $(this).data('first-remark');
    const secondRemark = $(this).data('second-remark');
    
    // Populate modal fields
    $('#modal_evaluation_id').val(evaluationId);
    $('#modal_table_type').val(tableType);
    $('#firstRemark').val(firstRemark);
    $('#secondRemark').val(secondRemark);
    
    // Set modal title
    $('#remarksModalLabel').text('View Remarks');
    
    // Make fields read-only
    $('#firstRemark').prop('readonly', true);
    $('#secondRemark').prop('readonly', true);
    $('#saveRemarksBtn').hide();
    
    // Show modal
    $('#remarksModal').modal('show');
  });

  // Handle Remarks Form Submission
  $('#remarksForm').on('submit', function(e) {
    e.preventDefault();
    
    const formData = $(this).serialize();
    
    $.ajax({
      type: 'POST',
      url: 'save_remarks.php',
      data: formData,
      success: function(response) {
        // Assuming 'Success' is returned on success
        if(response.trim() === 'Success') {
          $('#remarksModal').modal('hide');
          // Optionally, display a success message
          alert('Remarks saved successfully.');
          // Refresh the specific row or the entire page
          location.reload(); // Simple refresh
        } else {
          alert('Failed to save remarks. Please try again.');
        }
      },
      error: function() {
        alert('An error occurred. Please try again.');
      }
    });
  });
});

</script>
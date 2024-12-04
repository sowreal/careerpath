<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_b.php -->
<div class="tab-pane fade" id="criterion-b" role="tabpanel" aria-labelledby="tab-criterion-b">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION B - SERVICE TO THE COMMUNITY (MAX = 50 POINTS)</strong></h4>

    <h5><strong>1. For every instructional material developed and approved for use</strong></h5>
    <h5><strong>1.1 Patentable inventions, utility models and industrial design</strong></h5>

    <form id="criterion-b-form">
        <div class="row">
            <!-- Hidden Input for request_id -->
            <input type="hidden" id="request_id" name="request_id" value="" readonly>
            <!-- Sole Inventor Section -->
            <div class="col-12 mt-2">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success"><strong>1.1.1 Invention Patents</strong></h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="sole-inventor-table">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Name of the Invention</th>
                                <th>Application Date (mm/dd/yyyy)</th>
                                <th>Patent Application Stage</th>
                                <th>Date Accepted, Published, or Granted (mm/dd/yyyy)</th>
                                <th>Faculty Score</th>
                                <th>Link to Evidence from Google Drive</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 7; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><input type="text" class="form-control" name="sole_invention_name[]" required></td>
                                <td><input type="date" class="form-control" name="sole_application_date[]" required></td>
                                <td>
                                    <select class="form-select" name="sole_application_stage[]" required>
                                        <option value="">SELECT OPTION</option>
                                        <option value="Filed">Filed</option>
                                        <option value="Published">Published</option>
                                        <option value="Granted">Granted</option>
                                    </select>
                                </td>
                                <td><input type="date" class="form-control" name="sole_granted_date[]" required></td>
                                <td><input type="number" class="form-control" name="sole_faculty_score[]" step="0.01" min="0" required></td>
                                <td><input type="url" class="form-control" name="sole_evidence_link[]" placeholder="https://drive.google.com/..." required></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Multiple Inventors Section -->
            <div class="col-12 mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.1.2 WITH MULTIPLE INVENTORS</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="multiple-inventors-table">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Name of the Invention</th>
                                <th>Date of Application (mm/dd/yyyy)</th>
                                <th>Patent Application Stage</th>
                                <th>Date Accepted, Published, or Granted (mm/dd/yyyy)</th>
                                <th>% Contribution (in decimal form)</th>
                                <th>Faculty Score</th>
                                <th>Link to Evidence from Google Drive</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 8; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><input type="text" class="form-control" name="multiple_invention_name[]" required></td>
                                <td><input type="date" class="form-control" name="multiple_application_date[]" required></td>
                                <td>
                                    <select class="form-select" name="multiple_application_stage[]" required>
                                        <option value="">SELECT OPTION</option>
                                        <option value="Filed">Filed</option>
                                        <option value="Published">Published</option>
                                        <option value="Granted">Granted</option>
                                    </select>
                                </td>
                                <td><input type="date" class="form-control" name="multiple_granted_date[]" required></td>
                                <td><input type="number" class="form-control" name="multiple_contribution[]" step="0.01" min="0" max="1" required></td>
                                <td><input type="number" class="form-control" name="multiple_faculty_score[]" step="0.01" min="0" required></td>
                                <td><input type="url" class="form-control" name="multiple_evidence_link[]" placeholder="https://drive.google.com/..." required></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            


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

<!-- Delete Success Modal -->
<div class="modal fade" id="deleteSuccessModal" tabindex="-1" aria-labelledby="deleteSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white"> 
        <h5 class="modal-title" id="deleteSuccessModalLabel">Deletion Successful</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        The row has been successfully deleted.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Error Modal -->
<div class="modal fade" id="deleteErrorModal" tabindex="-1" aria-labelledby="deleteErrorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header"> 
        <h5 class="modal-title text-danger" id="deleteErrorModalLabel">Deletion Failed</h5>
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

<!-- Include Criterion A-specific JS -->
<script src="<?php echo BASE_URL; ?>/php/includes/career_progress_tracking/research/js/criterion_a.js"></script>

<!-- Modal: Evaluation selection -->
<div class="modal fade" id="evaluationModal" tabindex="-1" aria-labelledby="evaluationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="evaluationModalLabel">Select Evaluation</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Loading evaluations...</p> <!-- Content will be dynamically populated -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="confirm-selection" data-bs-dismiss="modal">Select</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for Viewing Remarks -->
<div class="modal fade" id="remarksModalA" tabindex="-1" aria-labelledby="remarksModalALabel" aria-hidden="true">
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

<!-- Unsaved Changes Confirmation Modal -->
<div class="modal fade" id="unsavedChangesModal" tabindex="-1" aria-labelledby="unsavedChangesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="unsavedChangesModalLabel">Unsaved Changes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        You have unsaved changes. Are you sure you want to leave without saving?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirm-navigation">Leave Without Saving</button>
      </div>
    </div>
  </div>
</div>

<!-- Upload Evidence Modal For Criterion A-->
<div class="modal fade" id="uploadEvidenceModalA" tabindex="-1" aria-labelledby="uploadEvidenceModalALabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadEvidenceModalLabel">Upload Evidence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="evidenceUploadForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="firstSemesterFile" class="form-label">1st Semester:</label>
                        <input type="file" class="form-control" id="firstSemesterFile" name="fileFirstSemester" accept=".pdf, .doc, .docx, .jpg, .jpeg, .png, .xlsx, .xls">
                        <div id="firstSemesterFilename" class="mt-2"></div>
                        <button type="button" class="btn btn-sm btn-danger mt-2" id="deleteFile1" data-semester="sem1">Remove</button>
                    </div>
                    <div class="mb-3">
                        <label for="secondSemesterFile" class="form-label">2nd Semester:</label>
                        <input type="file" class="form-control" id="secondSemesterFile" name="fileSecondSemester" accept=".pdf, .doc, .docx, .jpg, .jpeg, .png, .xlsx, .xls">
                        <div id="secondSemesterFilename" class="mt-2"></div>
                        <button type="button" class="btn btn-sm btn-danger mt-2" id="deleteFile2" data-semester="sem2">Remove</button>
                    </div>
                    <input type="hidden" id="modal_request_id" name="request_id">
                    <input type="hidden" id="modal_evaluation_id" name="evaluation_id">
                    <input type="hidden" id="modal_table_type" name="table_type">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="uploadEvidenceBtn">Upload</button>
            </div>
        </div>
    </div>
</div>

<!-- Single-File Upload Modal for Criterion B and C-->
<div class="modal fade" id="uploadSingleEvidenceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadSingleEvidenceModalLabel">Upload Evidence (Criterion B)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="b_singleEvidenceUploadForm" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="singleBFileInput" class="form-label">Evidence File</label>
            <input type="file" class="form-control" id="singleBFileInput" name="singleFileInput"
                   accept=".pdf, .doc, .docx, .jpg, .jpeg, .png, .xlsx, .xls" />
            <div class="small text-muted mt-1">Allowed: PDF, DOC, DOCX, JPG, JPEG, PNG, XLS, XLSX</div>
            <div id="singleBFileName" class="mt-2"></div>
          </div>
          <input type="hidden" id="b_modal_request_id" name="modal_request_id" value="">
          <input type="hidden" id="b_modal_subcriterion" name="modal_subcriterion" value="">
          <input type="hidden" id="b_modal_record_id" name="modal_record_id" value="">
          <input type="hidden" id="b_existing_file_path" name="existing_file_path" value="">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" id="b_uploadSingleEvidenceBtn">Upload</button>
      </div>
    </div>
  </div>
</div>


<!-- Generic Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="messageModalLabel">Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="messageModalBody">
                <!-- Message content will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

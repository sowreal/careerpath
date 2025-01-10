<?php
// php/dashboard/career_progress_tracking/research/kra2_modals.php
?>

<!-- Evaluation Selection Modal -->
<div class="modal fade" id="evaluationModal" tabindex="-1" aria-labelledby="evaluationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="evaluationModalLabel">Select Evaluation</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Content will be dynamically populated by research.js -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="confirm-selection-research">Select</button>
            </div>
        </div>
    </div>
</div>

<!-- Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="messageModalLabel">Message</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Message content will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Row Confirmation Modal -->
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

<!-- Upload Single Evidence Modal (Criterion A) -->
<div class="modal fade" id="uploadSingleEvidenceModalA" tabindex="-1" aria-labelledby="uploadSingleEvidenceModalALabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="uploadSingleEvidenceModalALabel">Upload Evidence (Criterion A)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="a_singleEvidenceUploadForm" enctype="multipart/form-data">
                    <input type="hidden" name="request_id" id="a_modal_request_id" value="">
                    <input type="hidden" name="subcriterion" id="a_modal_subcriterion" value="">
                    <input type="hidden" name="record_id" id="a_modal_record_id" value="">
                    <input type="hidden" name="existing_file" id="a_existing_file_path" value="">

                    <div class="mb-3">
                        <label for="singleAFileInput" class="form-label">Choose File:</label>
                        <input type="file" class="form-control" id="singleAFileInput" name="evidence_file">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Selected File:</label>
                        <span id="singleAFileName"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="deleteFileBtn">Delete File</button>
                <button type="button" class="btn btn-primary" id="a_uploadSingleEvidenceBtn">Upload</button>
            </div>
        </div>
    </div>
</div>
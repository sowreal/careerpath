<!-- php/includes/career_progress_tracking/research/kra2_modals.php -->

<!-- Modal: Evaluation selection -->
<div class="modal fade" id="evaluationModal" tabindex="-1" aria-labelledby="evaluationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="evaluationModalLabel">Select Evaluation</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Loading evaluations...</p>
                <!-- Evaluation numbers will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="confirm-selection-research">Select</button>
            </div>
        </div>
    </div>
</div>

<!-- Add other modals for KRA 2, Criterion A here (e.g., upload evidence modal, delete confirmation modal, etc.) -->
<!-- Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
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

<!-- Modal for Delete Confirmation -->
<div class="modal fade" id="deleteRowModal" tabindex="-1" aria-labelledby="deleteRowModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteRowModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this row?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-row">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Single File Upload (Criterion A) -->
<div class="modal fade" id="uploadSingleEvidenceModalA" tabindex="-1" aria-labelledby="uploadSingleEvidenceModalALabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="uploadSingleEvidenceModalALabel">Upload Evidence</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="a_singleEvidenceUploadForm" enctype="multipart/form-data">
                    <input type="hidden" name="request_id" id="a_modal_request_id" value="">
                    <input type="hidden" name="record_id" id="a_modal_record_id" value="">
                    <input type="hidden" name="subcriterion" id="a_modal_subcriterion" value="">
                    <input type="hidden" name="action" value="upload_evidence">
                    <div class="mb-3">
                        <label for="singleAFileInput" class="form-label">Choose File</label>
                        <input type="file" class="form-control" id="singleAFileInput" name="evidence_file">
                        <div id="singleAFileName" class="mt-2"></div>
                    </div>
                    <div class="mb-3" id="a_existingFileNotice">
                        <!-- Existing file notice will be here -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="a_uploadSingleEvidenceBtn">Select File</button>
            </div>
        </div>
    </div>
</div>
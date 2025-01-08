<!-- careerpath/php/includes/career_progress_tracking/extension/kra3_criterion_a.php -->

<div class="tab-pane fade show active" id="kra3-criterion-a" role="tabpanel" aria-labelledby="tab-kra3-criterion-a">
    <div class="container-fluid">
        <h3 class="mb-4 mt-4 pb-2 border-bottom border-3 border-success">
            <strong>KRA III - EXTENSION (Criterion A)</strong>
        </h3>

        <form id="kra3-criterion-a-form">
            <div class="row">
                <!-- Hidden Input for request_id -->
                <input type="hidden" id="request_id" name="request_id" value="" readonly>

                <!-- CRITERION A: SERVICE TO THE INSTITUTION -->
                <div class="col-12 mt-3">
                    <h4 class="mb-4 pb-2 border-bottom border-3 border-success">
                        <strong>CRITERION A - SERVICE TO THE INSTITUTION (MAX = 30 POINTS)</strong>
                    </h4>

                    <!-- 1. FOR EVERY SUCCESSFUL LINKAGE, NETWORKING OR PARTNERSHIP ACTIVITY -->
                    <h5 class="mt-4">
                        <strong>1. FOR EVERY SUCCESSFUL LINKAGE, NETWORKING OR PARTNERSHIP ACTIVITY</strong>
                    </h5>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-sm align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Name of Partner</th>
                                    <th scope="col">Nature of Partnership</th>
                                    <th scope="col">Faculty role in the forging of partnership</th>
                                    <th scope="col">MOA Start (mm/dd/yyyy)</th>
                                    <th scope="col">MOA Expiration (mm/dd/yyyy)</th>
                                    <th scope="col">Activities conducted based on MOA</th>
                                    <th scope="col">Date of activity (mm/dd/yyyy)</th>
                                    <th scope="col">Faculty Score</th>
                                    <th scope="col">Link to Evidence from Google Drive</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 1; $i <= 9; $i++): ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="a1_partner_name_<?php echo $i; ?>" /></td>
                                    <td><input type="text" class="form-control" name="a1_partnership_nature_<?php echo $i; ?>" /></td>
                                    <td>
                                        <select class="form-select" name="a1_faculty_role_<?php echo $i; ?>">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Lead Coordinator">Lead Coordinator</option>
                                            <option value="Assistant Coordinator">Assistant Coordinator</option>
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="a1_moa_start_<?php echo $i; ?>" /></td>
                                    <td><input type="date" class="form-control" name="a1_moa_expiration_<?php echo $i; ?>" /></td>
                                    <td><input type="text" class="form-control" name="a1_activities_conducted_<?php echo $i; ?>" /></td>
                                    <td><input type="date" class="form-control" name="a1_activity_date_<?php echo $i; ?>" /></td>
                                    <td><input type="number" class="form-control" name="a1_faculty_score_<?php echo $i; ?>" value="0.00" readonly /></td>
                                    <td><input type="url" class="form-control" name="a1_link_evidence_<?php echo $i; ?>" placeholder="https://drive.google.com/..." /></td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8"></td>
                                    <td>
                                        <input type="number" class="form-control" id="a1_total_score" name="a1_total_score" value="0.00" readonly>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- 2. TOTAL CONTRIBUTION TO INCOME GENERATION -->
                    <h5 class="mt-4">
                        <strong>2. TOTAL CONTRIBUTION TO INCOME GENERATION</strong>
                    </h5>
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-sm align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Name of the Commercialized Product, Funded Project, or Project with Industry</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Coverage Period (mm/dd/yyyy to mm/dd/yyyy)</th>
                                    <th scope="col">Total Amount</th>
                                    <th scope="col">Faculty Points</th>
                                    <th scope="col">Link to Evidence from Google Drive</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 1; $i <= 9; $i++): ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="a2_project_name_<?php echo $i; ?>" /></td>
                                    <td>
                                        <select class="form-select" name="a2_role_<?php echo $i; ?>">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Lead Contributor">Lead Contributor</option>
                                            <option value="Co-contributor">Co-contributor</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="a2_coverage_period_<?php echo $i; ?>" placeholder="mm/dd/yyyy to mm/dd/yyyy" /></td>
                                    <td><input type="number" class="form-control" name="a2_total_amount_<?php echo $i; ?>" /></td>
                                    <td><input type="number" class="form-control" name="a2_faculty_points_<?php echo $i; ?>" value="0.00" readonly /></td>
                                    <td><input type="url" class="form-control" name="a2_link_evidence_<?php echo $i; ?>" placeholder="https://drive.google.com/..." /></td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5"></td>
                                    <td>
                                        <input type="number" class="form-control" id="a2_total_score" name="a2_total_score" value="0.00" readonly>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-success" id="save-kra3-criterion-a">Save Criterion A</button>
            </div>
        </form>

        <!-- MODALS -->
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
                        KRA3 Criterion A has been saved successfully!
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
    </div>
</div>

<!-- Include KRA3 Criterion A-specific JS -->
<script src="<?php echo BASE_URL; ?>/php/includes/career_progress_tracking/extension/js/kra3_criterion_a.js"></script>
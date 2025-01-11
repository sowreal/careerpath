<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_a.php -->
<div class="tab-pane fade show active criterion-tab" id="criterion-a" role="tabpanel" aria-labelledby="tab-criterion-a">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION A: Involvement in Professional Organization (Max = 20 Points)</strong></h4>
    <p class="card-text">
        This section evaluates the faculty's involvement in professional organizations.
    </p>
    <form id="criterion-a-form" enctype="multipart/form-data">
        <div class="row">
            <!-- Hidden input for request_id -->
            <input type="hidden" id="request_id_a" name="request_id_a" value="" readonly>

            <!-- Section 1: Involvement in Professional Organization -->
            <div class="sub-criterion">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1. FOR CURRENT INDIVIDUAL MEMBERSHIP AND ACTIVE ROLE/CONTRIBUTION IN PROFESSIONAL ORGANIZATION, LEARNED/HONOR/SCIENTIFIC SOCIETY</h5>

                <div class="mt-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="involvement-table">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Name of Organization</th>
                                    <th scope="col">Type of Organization</th>
                                    <th scope="col">Activity of the Organization</th>
                                    <th scope="col">Role or Contribution</th>
                                    <th scope="col">Date of Activity</th>
                                    <th scope="col">Faculty Score</th>
                                    <th scope="col">Link to Evidence</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><input type="text" class="form-control" name="kra1_a_involvement[<?php echo $i; ?>][organization_name]"></td>
                                        <td><input type="text" class="form-control" name="kra1_a_involvement[<?php echo $i; ?>][organization_type]"></td>
                                        <td><input type="text" class="form-control" name="kra1_a_involvement[<?php echo $i; ?>][organization_activity]"></td>
                                        <td>
                                            <select class="form-select role-select" name="kra1_a_involvement[<?php echo $i; ?>][role]">
                                                <option value="">SELECT OPTION</option>
                                                <option value="Board Member">Board Member</option>
                                                <option value="Officer">Officer</option>
                                                <option value="Lead Organizer">Lead Organizer</option>
                                                <option value="Co-organizer">Co-organizer</option>
                                                <option value="Committee Chair">Committee Chair</option>
                                                <option value="Committee Member">Committee Member</option>
                                                <option value="Moderator">Moderator</option>
                                                <option value="Facilitator">Facilitator</option>
                                            </select>
                                        </td>
                                        <td><input type="date" class="form-control" name="kra1_a_involvement[<?php echo $i; ?>][activity_date]"></td>
                                        <td><input type="text" class="form-control score-input" name="kra1_a_involvement[<?php echo $i; ?>][score]" placeholder="0" readonly></td>
                                        <td>
                                            <input type="text" class="form-control evidence-link" name="kra1_a_involvement[<?php echo $i; ?>][evidence_link]" placeholder="Link to Evidence">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm view-remarks-a">View Remarks</button>
                                        </td>
                                        <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                                    </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-success mt-3 add-row" data-table-id="involvement-table">Add Row</button>
                    <!-- Overall Scores for Involvement -->
                    <div class="mt-4">
                        <div class="row g-3 justify-content-end">
                            <div class="col-md-4">
                                <label for="kra1_a_involvement_total" class="form-label"><strong>Total Score:</strong></label>
                                <input type="text" class="form-control" id="kra1_a_involvement_total" name="kra1_a_involvement_total" readonly>
                            </div>
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
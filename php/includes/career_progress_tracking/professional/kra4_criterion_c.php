<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_d.php -->
<div class="tab-pane fade" id="criterion-d" role="tabpanel" aria-labelledby="tab-criterion-d">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION C: Awards and Recognition (Max = 20 Points)</strong></h4>
    <p class="card-text">
        This section evaluates the faculty's awards and recognitions received in relevant areas of specialization, profession, and/or assignment.
    </p>
    <form id="criterion-d-form" enctype="multipart/form-data">
        <div class="row">
            <!-- Hidden input for request_id -->
            <input type="hidden" id="request_id_d" name="request_id_d" value="" readonly>

            <!-- Section 1: Awards of Distinction -->
            <div class="sub-criterion">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1. FOR EVERY AWARD OF DISTINCTION RECEIVED IN RECOGNITION OF ACHIEVEMENT IN RELEVANT AREAS OF SPECIALIZATION, PROFESSION AND/OR ASSIGNMENT OF THE FACULTY CONCERNED</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="awards-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name of the Award</th>
                                <th scope="col">Scope of the Award</th>
                                <th scope="col">Award-Giving Body/Organization</th>
                                <th scope="col">Date the Award was Given</th>
                                <th scope="col">Venue of the Award</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Link to Evidence</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 8; $i++): ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="kra1_d_awards[<?php echo $i; ?>][award_name]"></td>
                                    <td>
                                        <select class="form-select award-scope-select" name="kra1_d_awards[<?php echo $i; ?>][award_scope]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Institutional">Institutional</option>
                                            <option value="Local">Local</option>
                                            <option value="Regional">Regional</option>
                                            <option value="National">National</option>
                                            <option value="International">International</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="kra1_d_awards[<?php echo $i; ?>][award_giving_body]"></td>
                                    <td><input type="date" class="form-control" name="kra1_d_awards[<?php echo $i; ?>][date_given]"></td>
                                    <td><input type="text" class="form-control" name="kra1_d_awards[<?php echo $i; ?>][venue]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra1_d_awards[<?php echo $i; ?>][score]" placeholder="0" readonly></td>
                                    <td>
                                        <input type="text" class="form-control evidence-link" name="kra1_d_awards[<?php echo $i; ?>][evidence_link]" placeholder="Link to Evidence">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm view-remarks-d">View Remarks</button>
                                    </td>
                                    <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-success mt-3 add-row" data-table-id="awards-table">Add Row</button>
                <!-- Overall Scores for Awards -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra1_d_awards_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra1_d_awards_total" name="kra1_d_awards_total" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-end mt-5">
            <button type="button" class="btn btn-success" id="save-criterion-d">Save Criterion C</button>
        </div>
    </form>
</div>
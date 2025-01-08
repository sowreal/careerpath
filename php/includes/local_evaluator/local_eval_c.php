<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_c.php -->
<div class="tab-pane fade" id="criterion-c" role="tabpanel" aria-labelledby="tab-criterion-c">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION C: Thesis, Dissertation, and Mentorship Services (Max = 10 Points)</strong></h4>
    <p class="card-text">
        This section evaluates the faculty's contribution to Thesis, Dissertation, and Mentorship Services.
    </p>
    <form id="criterion-c-form" enctype="multipart/form-data">
        <div class="row">
            <!-- Hidden input for request_id -->
            <input type="hidden" id="request_id_c" name="request_id_c" value="" readonly>

            <!-- Section 1: Services Rendered to Students as Adviser -->
            <div class="sub-criterion">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1. FOR SERVICES RENDERED TO STUDENTS AS:</h5>

                <!-- 1.1 Adviser -->
                <div class="mt-4">
                    <h6 class="mb-4"><strong>1.1 ADVISER</strong></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="adviser-table">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Requirement</th>
                                    <th scope="col">AY 2019-2020</th>
                                    <th scope="col">AY 2020-2021</th>
                                    <th scope="col">AY 2021-2022</th>
                                    <th scope="col">AY 2022-2023</th>
                                    <th scope="col">Faculty Score</th>
                                    <th scope="col">Evidence</th>
                                    <th scope="col">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $adviser_requirements = ["SPECIAL/CAPSTONE PROJECT", "UNDERGRADUATE THESIS", "MASTER'S THESIS", "DISSERTATION"];
                                foreach ($adviser_requirements as $index => $requirement): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $requirement; ?></td>
                                        <?php for ($year = 2019; $year <= 2022; $year++): ?>
                                            <td><input type="number" class="form-control" name="kra1_c_adviser[<?php echo $index; ?>][ay_<?php echo $year; ?>]" step="1" min="0" value="0"></td>
                                        <?php endfor; ?>
                                        <td><input type="number" class="form-control score-input" name="kra1_c_adviser[<?php echo $index; ?>][score]" step="0.01" min="0" value="0.00"></td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="adviser_<?php echo $index; ?>">Upload Evidence</button>
                                            <input type="hidden" name="kra1_c_adviser[<?php echo $index; ?>][evidence_file]" value="">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-success mt-3 add-row" data-table-id="adviser-table">Add Row</button>
                    <!-- Overall Scores for Adviser -->
                    <div class="mt-4">
                        <div class="row g-3 justify-content-end">
                            <div class="col-md-4">
                                <label for="kra1_c_adviser_total" class="form-label"><strong>Total Score:</strong></label>
                                <input type="number" class="form-control" id="kra1_c_adviser_total" name="kra1_c_adviser_total" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 1.2 Panel -->
                <div class="mt-5 sub-criterion">
                    <h6 class="mb-4"><strong>1.2 PANEL</strong></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle" id="panel-table">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Requirement</th>
                                    <th scope="col">AY 2019-2020</th>
                                    <th scope="col">AY 2020-2021</th>
                                    <th scope="col">AY 2021-2022</th>
                                    <th scope="col">AY 2022-2023</th>
                                    <th scope="col">Faculty Score</th>
                                    <th scope="col">Evidence</th>
                                    <th scope="col">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $panel_requirements = ["SPECIAL/CAPSTONE PROJECT", "UNDERGRADUATE THESIS", "MASTER'S THESIS", "DISSERTATION"];
                                foreach ($panel_requirements as $index => $requirement): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $requirement; ?></td>
                                        <?php for ($year = 2019; $year <= 2022; $year++): ?>
                                            <td><input type="number" class="form-control" name="kra1_c_panel[<?php echo $index; ?>][ay_<?php echo $year; ?>]" step="1" min="0" value="0"></td>
                                        <?php endfor; ?>
                                        <td><input type="number" class="form-control score-input" name="kra1_c_panel[<?php echo $index; ?>][score]" step="0.01" min="0" value="0.00"></td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="panel_<?php echo $index; ?>">Upload Evidence</button>
                                            <input type="hidden" name="kra1_c_panel[<?php echo $index; ?>][evidence_file]" value="">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-success mt-3 add-row" data-table-id="panel-table">Add Row</button>
                    <!-- Overall Scores for Panel -->
                    <div class="mt-4">
                        <div class="row g-3 justify-content-end">
                            <div class="col-md-4">
                                <label for="kra1_c_panel_total" class="form-label"><strong>Total Score:</strong></label>
                                <input type="number" class="form-control" id="kra1_c_panel_total" name="kra1_c_panel_total" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Services Rendered as Mentor -->
            <div class="mt-5 sub-criterion">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">2. FOR SERVICES RENDERED AS MENTOR</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="mentor-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name of Academic Competition</th>
                                <th scope="col">Name of Sponsor Organization</th>
                                <th scope="col">Award Received</th>
                                <th scope="col">Date Awarded (mm/dd/yyyy)</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Evidence</th>
                                <th scope="col">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 3; $i++): ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="kra1_c_mentor[<?php echo $i; ?>][competition]" required></td>
                                    <td><input type="text" class="form-control" name="kra1_c_mentor[<?php echo $i; ?>][organization]" required></td>
                                    <td><input type="text" class="form-control" name="kra1_c_mentor[<?php echo $i; ?>][award]" required></td>
                                    <td><input type="date" class="form-control" name="kra1_c_mentor[<?php echo $i; ?>][date_awarded]" required></td>
                                    <td><input type="number" class="form-control score-input" name="kra1_c_mentor[<?php echo $i; ?>][score]" step="0.01" min="0" value="0.00" required></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="mentor_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra1_c_mentor[<?php echo $i; ?>][evidence_file]" value="">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-success mt-3 add-row" data-table-id="mentor-table">Add Row</button>
                <!-- Overall Scores for Mentor -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra1_c_mentor_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="number" class="form-control" id="kra1_c_mentor_total" name="kra1_c_mentor_total" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-end mt-5">
            <button type="button" class="btn btn-success" id="save-criterion-c">Save Criterion C</button>
        </div>
    </form>
</div>
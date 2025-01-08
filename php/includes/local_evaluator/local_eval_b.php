<div class="tab-pane fade" id="criterion-b" role="tabpanel" aria-labelledby="tab-criterion-b">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success">
        <strong>CRITERION B: Curriculum and Instructional Materials Development (Max = 30 Points)</strong>
    </h4>
    <p class="card-text">
        This section evaluates the faculty's contribution to curriculum and instructional material development.
    </p>
    <form id="criterion-b-form" enctype="multipart/form-data">
        <div class="row">
            <!-- Hidden input for request_id -->
            <input type="hidden" id="request_id_b" name="request_id_b" value="" readonly>

            <!-- Sub-criterion B.1: Sole Authorship -->
            <div class="sub-criterion">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1. FOR EVERY INSTRUCTIONAL MATERIAL DEVELOPED AND APPROVED FOR USE</h5>
                <h6 class="mb-4"><strong>1.1 SOLE AUTHORSHIP</strong></h6>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="sole-authorship-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title of Instructional Material</th>
                                <th scope="col">Type of Instructional Material</th>
                                <th scope="col">Reviewer or its Equivalent</th>
                                <th scope="col">Publisher/Repository</th>
                                <th scope="col">Date Published (mm/dd/yyyy)</th>
                                <th scope="col">Date Approved for Use (mm/dd/yyyy)</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Evidence</th>
                                <th scope="col">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="kra1_b_sole_authorship[<?php echo $i; ?>][title]"></td>
                                    <td>
                                        <select class="form-select" name="kra1_b_sole_authorship[<?php echo $i; ?>][type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Textbook">Textbook</option>
                                            <option value="Textbook Chapter">Textbook Chapter</option>
                                            <option value="Manual/Module">Manual/Module</option>
                                            <option value="Multimedia Teaching Material">Multimedia Teaching Material</option>
                                            <option value="Testing Material">Testing Material</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="kra1_b_sole_authorship[<?php echo $i; ?>][reviewer]"></td>
                                    <td><input type="text" class="form-control" name="kra1_b_sole_authorship[<?php echo $i; ?>][publisher]"></td>
                                    <td><input type="date" class="form-control" name="kra1_b_sole_authorship[<?php echo $i; ?>][date_published]"></td>
                                    <td><input type="date" class="form-control" name="kra1_b_sole_authorship[<?php echo $i; ?>][date_approved]"></td>
                                    <td><input type="number" class="form-control score-input" name="kra1_b_sole_authorship[<?php echo $i; ?>][score]"></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="sole_authorship_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra1_b_sole_authorship[<?php echo $i; ?>][evidence_file]" value="">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Add Row Button for Sole Authorship -->
                <button type="button" class="btn btn-success mt-3 add-row" data-table-id="sole-authorship-table">Add Row</button>
                <!-- Overall Scores for Sole Authorship -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra1_b_sole_authorship_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="number" class="form-control" id="kra1_b_sole_authorship_total" name="kra1_b_sole_authorship_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion B.2: Co-authorship -->
            <div class="sub-criterion mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.2 CO-AUTHORSHIP</h5>
                <p class="mb-4">
                    Note: Every IM with Multiple Authors should be Accompanied by a Certification using FORM I-B1a
                </p>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="co-authorship-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title of IM</th>
                                <th scope="col">Type of IM</th>
                                <th scope="col">Reviewer or its Equivalent</th>
                                <th scope="col">Publisher/Repository</th>
                                <th scope="col">Date Published (mm/dd/yyyy)</th>
                                <th scope="col">Date Approved for Use (mm/dd/yyyy)</th>
                                <th scope="col">% Contribution (write in decimal form)</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Evidence</th>
                                <th scope="col">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="kra1_b_co_authorship[<?php echo $i; ?>][title]"></td>
                                    <td>
                                        <select class="form-select" name="kra1_b_co_authorship[<?php echo $i; ?>][type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Textbook">Textbook</option>
                                            <option value="Textbook Chapter">Textbook Chapter</option>
                                            <option value="Manual/Module">Manual/Module</option>
                                            <option value="Multimedia Teaching Material">Multimedia Teaching Material</option>
                                            <option value="Testing Material">Testing Material</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="kra1_b_co_authorship[<?php echo $i; ?>][reviewer]"></td>
                                    <td><input type="text" class="form-control" name="kra1_b_co_authorship[<?php echo $i; ?>][publisher]"></td>
                                    <td><input type="date" class="form-control" name="kra1_b_co_authorship[<?php echo $i; ?>][date_published]"></td>
                                    <td><input type="date" class="form-control" name="kra1_b_co_authorship[<?php echo $i; ?>][date_approved]"></td>
                                    <td><input type="number" step="0.01" class="form-control" name="kra1_b_co_authorship[<?php echo $i; ?>][contribution_percentage]"></td>
                                    <td><input type="number" class="form-control score-input" name="kra1_b_co_authorship[<?php echo $i; ?>][score]"></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="co_authorship_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra1_b_co_authorship[<?php echo $i; ?>][evidence_file]" value="">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Add Row Button for Co-Authorship -->
                <button type="button" class="btn btn-success mt-3 add-row" data-table-id="co-authorship-table">Add Row</button>
                <!-- Overall Scores for Co-Authorship -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra1_b_co_authorship_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="number" class="form-control" id="kra1_b_co_authorship_total" name="kra1_b_co_authorship_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion B.3: Academic Programs -->
            <div class="sub-criterion mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">2. ACADEMIC PROGRAMS DEVELOPED/REVISED AND IMPLEMENTED</h5>
                <div class="table-responsive">   
                    <table class="table table-bordered align-middle" id="academic-programs-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name of Academic Degree Program (provide complete name of the program)</th>
                                <th scope="col">Type of Program</th>
                                <th scope="col">Board Approval (Board Reso. No.)</th>
                                <th scope="col">Academic Year Implemented</th>
                                <th scope="col">Role</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Evidence</th>
                                <th scope="col">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="kra1_b_academic_programs[<?php echo $i; ?>][program_name]"></td>
                                    <td>
                                        <select class="form-select" name="kra1_b_academic_programs[<?php echo $i; ?>][program_type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="New Program">New Program</option>
                                            <option value="Revised Program">Revised Program</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="kra1_b_academic_programs[<?php echo $i; ?>][board_approval]"></td>
                                    <td>
                                        <select class="form-select" name="kra1_b_academic_programs[<?php echo $i; ?>][academic_year]">
                                            <option value="">SELECT OPTION</option>
                                            <?php
                                            $currentYear = date("Y");
                                            for ($year = $currentYear; $year >= $currentYear - 4; $year--) {
                                                $yearRange = $year . '-' . ($year + 1);
                                                echo "<option value=\"$yearRange\">$yearRange</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-select" name="kra1_b_academic_programs[<?php echo $i; ?>][role]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Lead">Lead</option>
                                            <option value="Contributor">Contributor</option>
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control score-input" name="kra1_b_academic_programs[<?php echo $i; ?>][score]"></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="academic_programs_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra1_b_academic_programs[<?php echo $i; ?>][evidence_file]" value="">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div> 
                <!-- Add Row Button for Academic Programs -->
                <button type="button" class="btn btn-success mt-3 add-row" data-table-id="academic-programs-table">Add Row</button>
                <!-- Overall Scores for Academic Programs -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra1_b_academic_programs_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="number" class="form-control" id="kra1_b_academic_programs_total" name="kra1_b_academic_programs_total" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Save Button -->
        <div class="d-flex justify-content-end mt-5">
            <button type="button" class="btn btn-success" id="save-criterion-b">Save Criterion B</button>
        </div>
    </form>
</div>
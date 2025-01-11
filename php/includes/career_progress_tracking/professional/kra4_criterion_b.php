<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_b.php -->
<div class="tab-pane fade" id="criterion-b" role="tabpanel" aria-labelledby="tab-criterion-b">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION B: Continuing Development (Max = 60 Points)</strong></h4>
    <p class="card-text">
        This section evaluates the faculty's continuing development through educational qualifications, participation in conferences/seminars/workshops, and paper presentations.
    </p>
    <form id="criterion-b-form" enctype="multipart/form-data">
        <div class="row">
            <!-- Hidden input for request_id -->
            <input type="hidden" id="request_id_b" name="request_id_b" value="" readonly>

            <!-- Section 1.1: Doctorate Degree -->
            <div class="sub-criterion">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.1 FOR DOCTORATE DEGREE (First Time)</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="doctorate-degree-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name of Doctorate Degree</th>
                                <th scope="col">Name of Institution where Degree was Obtained</th>
                                <th scope="col">Date Completed</th>
                                <th scope="col">Is the faculty Qualified for the Degree?</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Link to Evidence</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><input type="text" class="form-control" name="kra1_b_doctorate_degree[1][degree_name]"></td>
                                <td><input type="text" class="form-control" name="kra1_b_doctorate_degree[1][institution]"></td>
                                <td><input type="date" class="form-control" name="kra1_b_doctorate_degree[1][date_completed]"></td>
                                <td>
                                    <select class="form-select qualified-select" name="kra1_b_doctorate_degree[1][is_qualified]">
                                        <option value="NO">NO</option>
                                        <option value="YES">YES</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control score-input" name="kra1_b_doctorate_degree[1][score]" placeholder="0" readonly></td>
                                <td>
                                    <input type="text" class="form-control evidence-link" name="kra1_b_doctorate_degree[1][evidence_link]" placeholder="Link to Evidence">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm view-remarks-b">View Remarks</button>
                                </td>
                                <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-success mt-3 add-row" data-table-id="additional-degrees-table">Add Row</button>
            </div>

            <!-- Section 1.2: Additional Degrees -->
            <div class="sub-criterion mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.2 ADDITIONAL DEGREES</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="additional-degrees-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Degree</th>
                                <th scope="col">Degree Name</th>
                                <th scope="col">Name of HEI</th>
                                <th scope="col">Date Completed</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Link to Evidence</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 4; $i++): ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <select class="form-select degree-type-select" name="kra1_b_additional_degrees[<?php echo $i; ?>][degree_type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Additional Doctorate Degree">Additional Doctorate Degree</option>
                                            <option value="Additional Master's Degree">Additional Master's Degree</option>
                                            <option value="Post-Doctorate Diploma/Certificate">Post-Doctorate Diploma/Certificate</option>
                                            <option value="Post-Masters Diploma/Certificate">Post-Masters Diploma/Certificate</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="kra1_b_additional_degrees[<?php echo $i; ?>][degree_name]"></td>
                                    <td><input type="text" class="form-control" name="kra1_b_additional_degrees[<?php echo $i; ?>][hei_name]"></td>
                                    <td><input type="date" class="form-control" name="kra1_b_additional_degrees[<?php echo $i; ?>][date_completed]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra1_b_additional_degrees[<?php echo $i; ?>][score]" placeholder="0" readonly></td>
                                    <td>
                                        <input type="text" class="form-control evidence-link" name="kra1_b_additional_degrees[<?php echo $i; ?>][evidence_link]" placeholder="Link to Evidence">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm view-remarks-b">View Remarks</button>
                                    </td>
                                    <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-success mt-3 add-row" data-table-id="additional-degrees-table">Add Row</button>
                <!-- Overall Scores for Additional Degrees -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra1_b_additional_degrees_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra1_b_additional_degrees_total" name="kra1_b_additional_degrees_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Participation in Conferences, Seminars, etc. -->
            <div class="sub-criterion mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">2. FOR EVERY PARTICIPATION IN CONFERENCES, SEMINARS, WORKSHOPS, INDUSTRY IMMERSION (MAX = 10 POINTS)</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="participation-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name of Conference/Training</th>
                                <th scope="col">Scope</th>
                                <th scope="col">Organizer</th>
                                <th scope="col">Date of Activity</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Link to Evidence</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="kra1_b_participation[<?php echo $i; ?>][conference_name]"></td>
                                    <td>
                                        <select class="form-select scope-select" name="kra1_b_participation[<?php echo $i; ?>][scope]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Local">Local</option>
                                            <option value="International">International</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="kra1_b_participation[<?php echo $i; ?>][organizer]"></td>
                                    <td><input type="date" class="form-control" name="kra1_b_participation[<?php echo $i; ?>][activity_date]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra1_b_participation[<?php echo $i; ?>][score]" placeholder="0" readonly></td>
                                    <td>
                                        <input type="text" class="form-control evidence-link" name="kra1_b_participation[<?php echo $i; ?>][evidence_link]" placeholder="Link to Evidence">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm view-remarks-b">View Remarks</button>
                                    </td>
                                    <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-success mt-3 add-row" data-table-id="participation-table">Add Row</button>
                <!-- Overall Scores for Participation -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra1_b_participation_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra1_b_participation_total" name="kra1_b_participation_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Paper Presentation -->
            <div class="sub-criterion mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">3. FOR EVERY PAPER PRESENTATION IN CONFERENCES (MAX = 10 POINTS)</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="paper-presentation-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Title of Paper</th>
                                <th scope="col">Local or International</th>
                                <th scope="col">Title of the Conference</th>
                                <th scope="col">Conference Organizer</th>
                                <th scope="col">Date Presented</th>
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
                                    <td><input type="text" class="form-control" name="kra1_b_paper_presentation[<?php echo $i; ?>][paper_title]"></td>
                                    <td>
                                        <select class="form-select local-international-select" name="kra1_b_paper_presentation[<?php echo $i; ?>][local_international]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Local">Local</option>
                                            <option value="International">International</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="kra1_b_paper_presentation[<?php echo $i; ?>][conference_title]"></td>
                                    <td><input type="text" class="form-control" name="kra1_b_paper_presentation[<?php echo $i; ?>][conference_organizer]"></td>
                                    <td><input type="date" class="form-control" name="kra1_b_paper_presentation[<?php echo $i; ?>][date_presented]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra1_b_paper_presentation[<?php echo $i; ?>][score]" placeholder="0" readonly></td>
                                    <td>
                                        <input type="text" class="form-control evidence-link" name="kra1_b_paper_presentation[<?php echo $i; ?>][evidence_link]" placeholder="Link to Evidence">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm view-remarks-b">View Remarks</button>
                                    </td>
                                    <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-success mt-3 add-row" data-table-id="paper-presentation-table">Add Row</button>
                <!-- Overall Scores for Paper Presentation -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra1_b_paper_presentation_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra1_b_paper_presentation_total" name="kra1_b_paper_presentation_total" readonly>
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
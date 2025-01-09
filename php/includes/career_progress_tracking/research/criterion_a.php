<!-- careerpath/php/includes/career_progress_tracking/research/criterion_a.php -->
<div class="tab-pane fade show active criterion-tab" id="criterion-a" role="tabpanel" aria-labelledby="tab-criterion-a">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success">
        <strong>CRITERION A - RESEARCH OUTPUTS (MAX = 100 POINTS)</strong>
    </h4>
    <p class="card-text">
        This section evaluates the faculty's research and scholarly outputs.
    </p>

    <form id="criterion-a-form">
        <div class="row">
            <!-- Hidden Input for request_id -->
            <input type="hidden" id="request_id" name="request_id" value="" readonly>

            <!-- Sub-criterion A.1: Sole Authorship -->
            <div class="sub-criterion">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">
                    1. FOR EVERY SCHOLARLY RESEARCH PAPER/EDUCATIONAL OR TECHNICAL ARTICLE AND OTHER OUTPUTS PUBLISHED
                </h5>
                <h6 class="mb-4"><strong>1.1 SOLE AUTHORSHIP</strong></h6>
                <!-- Responsive Table for Sole Authorship -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="sole-authorship-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title of Research Output</th>
                                <th scope="col">Type of Research Output</th>
                                <th scope="col">Name of Journal / Publisher</th>
                                <th scope="col">Reviewer or Its Equivalent</th>
                                <th scope="col">International</th>
                                <th scope="col">Date Published (mm/dd/yyyy)</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Evidence</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="kra1_a_sole_authorship[<?php echo $i; ?>][title]"></td>
                                    <td>
                                        <select class="form-select" name="kra1_a_sole_authorship[<?php echo $i; ?>][type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="scholarly_paper">Scholarly Paper</option>
                                            <option value="educational_article">Educational Article</option>
                                            <option value="technical_article">Technical Article</option>
                                            <option value="other_output">Other Outputs</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="kra1_a_sole_authorship[<?php echo $i; ?>][journal_publisher]"></td>
                                    <td><input type="text" class="form-control" name="kra1_a_sole_authorship[<?php echo $i; ?>][reviewer]"></td>
                                    <td>
                                        <select class="form-select" name="kra1_a_sole_authorship[<?php echo $i; ?>][international]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="kra1_a_sole_authorship[<?php echo $i; ?>][date_published]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra1_a_sole_authorship[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="sole_authorship_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra1_a_sole_authorship[<?php echo $i; ?>][evidence_file]" value="">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Add Row Button for Sole Authorship -->
                <button type="button" class="btn btn-success mt-3 add-sole-authorship-row" data-table-id="sole-authorship-table">Add Row</button>
                <!-- Overall Scores for Sole Authorship -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra1_a_sole_authorship_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra1_a_sole_authorship_total" name="kra1_a_sole_authorship_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion A.2: Co-Authorship -->
            <div class="sub-criterion mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.2 CO-AUTHORSHIP</h5>
                <p class="mb-4">
                    Note: Every Research Output with Multiple Authors should be accompanied by a Certification using FORM II-A1a
                </p>
                <!-- Responsive Table for Co-Authorship -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="co-authorship-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title of Research Output</th>
                                <th scope="col">Type of Research Output</th>
                                <th scope="col">Name of Journal / Publisher</th>
                                <th scope="col">Reviewer or Equivalent (if applicable)</th>
                                <th scope="col">International</th>
                                <th scope="col">Date Published (mm/dd/yyyy)</th>
                                <th scope="col">% Contribution</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Evidence</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="kra1_a_co_authorship[<?php echo $i; ?>][title]"></td>
                                    <td>
                                        <select class="form-select" name="kra1_a_co_authorship[<?php echo $i; ?>][type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="scholarly_paper">Scholarly Paper</option>
                                            <option value="educational_article">Educational Article</option>
                                            <option value="technical_article">Technical Article</option>
                                            <option value="other_output">Other Outputs</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="kra1_a_co_authorship[<?php echo $i; ?>][journal_publisher]"></td>
                                    <td><input type="text" class="form-control" name="kra1_a_co_authorship[<?php echo $i; ?>][reviewer]"></td>
                                    <td>
                                        <select class="form-select" name="kra1_a_co_authorship[<?php echo $i; ?>][international]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="kra1_a_co_authorship[<?php echo $i; ?>][date_published]"></td>
                                    <td><input type="number" class="form-control" name="kra1_a_co_authorship[<?php echo $i; ?>][contribution_percentage]" placeholder="0" min="0" max="100"></td>
                                    <td><input type="text" class="form-control score-input" name="kra1_a_co_authorship[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="co_authorship_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra1_a_co_authorship[<?php echo $i; ?>][evidence_file]" value="">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Add Row Button for Co-Authorship -->
                <button type="button" class="btn btn-success mt-3 add-co-authorship-row" data-table-id="co-authorship-table">Add Row</button>
                <!-- Overall Scores for Co-Authorship -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra1_a_co_authorship_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra1_a_co_authorship_total" name="kra1_a_co_authorship_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion A.3: Lead Researcher -->
            <div class="sub-criterion mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">
                    2. FOR EVERY RESEARCH OUTPUT TRANSLATED INTO PROJECT, POLICY OR PRODUCT AS:
                </h5>
                <h6 class="mb-4"><strong>2.1 LEAD RESEARCHER</strong></h6>
                <!-- Responsive Table for Lead Researcher -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="lead-researcher-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title of Research</th>
                                <th scope="col">Date Completed (mm/dd/yyyy)</th>
                                <th scope="col">Name of Project, Policy or Product</th>
                                <th scope="col">Funding Source</th>
                                <th scope="col">Date implemented, adopted or developed (mm/dd/yyyy)</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Evidence</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="kra1_a_lead_researcher[<?php echo $i; ?>][title]"></td>
                                    <td><input type="date" class="form-control" name="kra1_a_lead_researcher[<?php echo $i; ?>][date_completed]"></td>
                                    <td><input type="text" class="form-control" name="kra1_a_lead_researcher[<?php echo $i; ?>][project_name]"></td>
                                    <td><input type="text" class="form-control" name="kra1_a_lead_researcher[<?php echo $i; ?>][funding_source]"></td>
                                    <td><input type="date" class="form-control" name="kra1_a_lead_researcher[<?php echo $i; ?>][date_implemented]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra1_a_lead_researcher[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="lead_researcher_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra1_a_lead_researcher[<?php echo $i; ?>][evidence_file]" value="">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Add Row Button for Lead Researcher -->
                <button type="button" class="btn btn-success mt-3 add-lead-researcher-row" data-table-id="lead-researcher-table">Add Row</button>
                <!-- Overall Scores for Lead Researcher -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra1_a_lead_researcher_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra1_a_lead_researcher_total" name="kra1_a_lead_researcher_total" readonly>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sub-criterion A.4: Contributor -->
            <div class="sub-criterion mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">
                    2.2 CONTRIBUTOR (should be accompanied by a Certification using FORM II-A2a)
                </h5>
                <!-- Responsive Table for Contributor -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="contributor-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title of Research</th>
                                <th scope="col">Date Completed (mm/dd/yyyy)</th>
                                <th scope="col">Name of Project, Policy or Product</th>
                                <th scope="col">Funding Source</th>
                                <th scope="col">Date implemented, adopted or developed (mm/dd/yyyy)</th>
                                <th scope="col">% Contribution</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Evidence</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="kra1_a_contributor[<?php echo $i; ?>][title]"></td>
                                    <td><input type="date" class="form-control" name="kra1_a_contributor[<?php echo $i; ?>][date_completed]"></td>
                                    <td><input type="text" class="form-control" name="kra1_a_contributor[<?php echo $i; ?>][project_name]"></td>
                                    <td><input type="text" class="form-control" name="kra1_a_contributor[<?php echo $i; ?>][funding_source]"></td>
                                    <td><input type="date" class="form-control" name="kra1_a_contributor[<?php echo $i; ?>][date_implemented]"></td>
                                    <td><input type="number" class="form-control" name="kra1_a_contributor[<?php echo $i; ?>][contribution_percentage]" placeholder="0" min="0" max="100"></td>
                                    <td><input type="text" class="form-control score-input" name="kra1_a_contributor[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="contributor_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra1_a_contributor[<?php echo $i; ?>][evidence_file]" value="">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Add Row Button for Contributor -->
                <button type="button" class="btn btn-success mt-3 add-contributor-row" data-table-id="contributor-table">Add Row</button>
                <!-- Overall Scores for Contributor -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra1_a_contributor_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra1_a_contributor_total" name="kra1_a_contributor_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion A.5: Local Authors -->
            <div class="sub-criterion mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">
                    3. FOR EVERY RESEARCH PUBLICATION CITED BY OTHER AUTHORS
                </h5>
                <h6 class="mb-4"><strong>3.1 LOCAL AUTHORS (MAX = 40 POINTS)</strong></h6>
                <!-- Responsive Table for Local Authors -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="local-authors-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title of Journal Article</th>
                                <th scope="col">Date Published</th>
                                <th scope="col">Name of Journal</th>
                                <th scope="col">No. of Citation</th>
                                <th scope="col">Citation Index</th>
                                <th scope="col">Year's Citation Published</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Evidence</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="kra1_a_local_authors[<?php echo $i; ?>][title]"></td>
                                    <td><input type="date" class="form-control" name="kra1_a_local_authors[<?php echo $i; ?>][date_published]"></td>
                                    <td><input type="text" class="form-control" name="kra1_a_local_authors[<?php echo $i; ?>][journal_name]"></td>
                                    <td><input type="number" class="form-control" name="kra1_a_local_authors[<?php echo $i; ?>][citation_count]"></td>
                                    <td><input type="text" class="form-control" name="kra1_a_local_authors[<?php echo $i; ?>][citation_index]"></td>
                                    <td><input type="date" class="form-control" name="kra1_a_local_authors[<?php echo $i; ?>][citation_year]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra1_a_local_authors[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="local_authors_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra1_a_local_authors[<?php echo $i; ?>][evidence_file]" value="">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Add Row Button for Local Authors -->
                <button type="button" class="btn btn-success mt-3 add-local-authors-row" data-table-id="local-authors-table">Add Row</button>
                <!-- Overall Scores for Local Authors -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra1_a_local_authors_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra1_a_local_authors_total" name="kra1_a_local_authors_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion A.6: International Authors -->
            <div class="sub-criterion mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">
                    3.2 INTERNATIONAL AUTHORS (MAX = 60 POINTS)
                </h5>
                <!-- Responsive Table for International Authors -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="international-authors-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title of Journal Article</th>
                                <th scope="col">Date Published</th>
                                <th scope="col">Name of Journal</th>
                                <th scope="col">No. of Citation</th>
                                <th scope="col">Citation Index</th>
                                <th scope="col">Year's Citation Published</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Evidence</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="kra1_a_international_authors[<?php echo $i; ?>][title]"></td>
                                    <td><input type="date" class="form-control" name="kra1_a_international_authors[<?php echo $i; ?>][date_published]"></td>
                                    <td><input type="text" class="form-control" name="kra1_a_international_authors[<?php echo $i; ?>][journal_name]"></td>
                                    <td><input type="number" class="form-control" name="kra1_a_international_authors[<?php echo $i; ?>][citation_count]"></td>
                                    <td><input type="text" class="form-control" name="kra1_a_international_authors[<?php echo $i; ?>][citation_index]"></td>
                                    <td><input type="date" class="form-control" name="kra1_a_international_authors[<?php echo $i; ?>][citation_year]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra1_a_international_authors[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="international_authors_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra1_a_international_authors[<?php echo $i; ?>][evidence_file]" value="">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm view-remarks">View Remarks</button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Add Row Button for International Authors -->
                <button type="button" class="btn btn-success mt-3 add-international-authors-row" data-table-id="international-authors-table">Add Row</button>
                <!-- Overall Scores for International Authors -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra1_a_international_authors_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra1_a_international_authors_total" name="kra1_a_international_authors_total" readonly>
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

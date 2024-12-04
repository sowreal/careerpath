<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_a.php -->
<div class="tab-pane fade show active criterion-tab" id="criterion-a" role="tabpanel" aria-labelledby="tab-criterion-a">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION A - RESEARCH OUTPUTS (MAX = 100 POINTS)</strong></h4>
    
    <h5><strong>1. FOR EVERY SCHOLARLY RESEARCH PAPER/EDUCATIONAL OR TECHNICAL ARTICLE AND OTHER OUTPUTS PUBLISHED:</strong></h5>
    

    <form id="criterion-a-form">
        <div class="row">
            <!-- Hidden Input for request_id -->
            <input type="hidden" id="request_id" name="request_id" value="" readonly>

            <!-- Research Outputs Section -->
            <div class="col-12 mt-5">
              <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.1 SOLE AUTHORSHIP</h5>
                <!-- Responsive Table for Research Outputs -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="research-output-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title of Research Output</th>
                                <th scope="col">Type of Research Output</th>
                                <th scope="col">Name of Journal / Publisher</th>
                                <th scope="col">Reviewer or Its Equivalent</th>
                                <th scope="col">International Indexing Body</th>
                                <th scope="col">Date Published (mm/dd/yyyy)</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Link to Evidence from Google Drive</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><input type="text" class="form-control" name="title_of_research_output_<?php echo $i; ?>" /></td>
                                <td>
                                    <select class="form-select" name="type_of_research_output_<?php echo $i; ?>">
                                        <option value="">SELECT OPTION</option>
                                        <option value="scholarly_paper">Scholarly Paper</option>
                                        <option value="educational_article">Educational Article</option>
                                        <option value="technical_article">Technical Article</option>
                                        <option value="other_output">Other Outputs</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="journal_publisher_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="reviewer_equivalent_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="indexing_body_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="date_published_<?php echo $i; ?>" /></td>
                                <td><input type="number" class="form-control" name="faculty_score_<?php echo $i; ?>" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="link_evidence_<?php echo $i; ?>" placeholder="https://drive.google.com/..." /></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Overall Score -->
                <div class="mt-5">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="overall_score" class="form-label"><strong>Total Score:</strong></label>
                            <input type="number" class="form-control" id="overall_score" name="overall_score" value="0.00" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Co-Authorship Section -->
            <div class="col-12 mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1.2 CO-AUTHORSHIP</h5>
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
                                <th scope="col">International Indexing Body (if applicable)</th>
                                <th scope="col">Date Published (mm/dd/yyyy)</th>
                                <th scope="col">% Contribution (write in decimal form)</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Link to Evidence from Google Drive</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><input type="text" class="form-control" name="coauthorship_title_of_research_output_<?php echo $i; ?>" /></td>
                                <td>
                                    <select class="form-select" name="coauthorship_type_of_research_output_<?php echo $i; ?>">
                                        <option value="">SELECT OPTION</option>
                                        <option value="scholarly_paper">Scholarly Paper</option>
                                        <option value="educational_article">Educational Article</option>
                                        <option value="technical_article">Technical Article</option>
                                        <option value="other_output">Other Outputs</option>
                                    </select>
                                </td>
                                <td><input type="text" class="form-control" name="coauthorship_journal_publisher_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="coauthorship_reviewer_equivalent_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="coauthorship_indexing_body_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="coauthorship_date_published_<?php echo $i; ?>" /></td>
                                <td><input type="number" class="form-control" name="coauthorship_contribution_<?php echo $i; ?>" placeholder="0.0" /></td>
                                <td><input type="number" class="form-control" name="coauthorship_faculty_score_<?php echo $i; ?>" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="coauthorship_link_evidence_<?php echo $i; ?>" placeholder="https://drive.google.com/..." /></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <p class="text-muted">Note: Every Research Output with Multiple Authors should be accompanied by a Certification using FORM II-A1a</p>
            </div>

            <!-- Lead Researcher Section -->
            <div class="col-12 mt-5">
                <h5><strong>2. FOR EVERY RESEARCH OUTPUT TRANSLATED INTO PROJECT, POLICY OR PRODUCT AS:</strong></h5>
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">2.1 LEAD RESEARCHER</h5>
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
                                <th scope="col">Link to Evidence from Google Drive</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 6; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><input type="text" class="form-control" name="lead_research_title_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="lead_research_date_completed_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="lead_research_project_name_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="lead_research_funding_source_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="lead_research_date_implemented_<?php echo $i; ?>" /></td>
                                <td><input type="number" class="form-control" name="lead_research_faculty_score_<?php echo $i; ?>" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="lead_research_link_evidence_<?php echo $i; ?>" placeholder="https://drive.google.com/..." /></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Contributor Section -->
            <div class="col-12 mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">2.2 CONTRIBUTOR (should be accompanied by a Certification using FORM II-A2a)</h5>
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
                                <th scope="col">% Contribution (write in decimal form)</th>
                                <th scope="col">Faculty Score</th>
                                <th scope="col">Link to Evidence from Google Drive</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 6; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><input type="text" class="form-control" name="contributor_title_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="contributor_date_completed_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="contributor_project_name_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="contributor_funding_source_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="contributor_date_implemented_<?php echo $i; ?>" /></td>
                                <td><input type="number" class="form-control" name="contributor_contribution_<?php echo $i; ?>" placeholder="0.0" /></td>
                                <td><input type="number" class="form-control" name="contributor_faculty_score_<?php echo $i; ?>" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="contributor_link_evidence_<?php echo $i; ?>" placeholder="https://drive.google.com/..." /></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Local Authors Section -->
            <div class="col-12 mt-5">
                <h5><strong>3. FOR EVERY RESEARCH PUBLICATION CITED BY OTHER AUTHORS</strong></h5>
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">3.1 LOCAL AUTHORS (MAX = 40 POINTS)</h5>
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
                                <th scope="col">Link to Evidence from Google Drive</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 7; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><input type="text" class="form-control" name="local_authors_title_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="local_authors_date_published_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="local_authors_journal_<?php echo $i; ?>" /></td>
                                <td><input type="number" class="form-control" name="local_authors_no_of_citation_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="local_authors_citation_index_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="local_authors_year_citation_published_<?php echo $i; ?>" /></td>
                                <td><input type="number" class="form-control" name="local_authors_faculty_score_<?php echo $i; ?>" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="local_authors_link_evidence_<?php echo $i; ?>" placeholder="https://drive.google.com/..." /></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- International Authors Section -->
            <div class="col-12 mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">3.2 INTERNATIONAL AUTHORS (MAX = 60 POINTS)</h5>
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
                                <th scope="col">Link to Evidence from Google Drive</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 15; $i++): ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><input type="text" class="form-control" name="international_authors_title_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="international_authors_date_published_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="international_authors_journal_<?php echo $i; ?>" /></td>
                                <td><input type="number" class="form-control" name="international_authors_no_of_citation_<?php echo $i; ?>" /></td>
                                <td><input type="text" class="form-control" name="international_authors_citation_index_<?php echo $i; ?>" /></td>
                                <td><input type="date" class="form-control" name="international_authors_year_citation_published_<?php echo $i; ?>" /></td>
                                <td><input type="number" class="form-control" name="international_authors_faculty_score_<?php echo $i; ?>" value="0.00" readonly /></td>
                                <td><input type="url" class="form-control" name="international_authors_link_evidence_<?php echo $i; ?>" placeholder="https://drive.google.com/..." /></td>
                            </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-end mt-5">
            <button type="button" class="btn btn-success" id="save-criterion-a">Save Criterion A</button>
        </div>
    </form>
</div>

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
        Criterion A has been saved successfully!
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

<!-- Include Criterion A-specific JS -->
<script src="<?php echo BASE_URL; ?>/php/includes/career_progress_tracking/research/js/research.js"></script>

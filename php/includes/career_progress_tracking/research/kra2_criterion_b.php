<!-- careerpath/php/includes/career_progress_tracking/research/criterion_b.php -->
<div class="tab-pane fade" id="criterion-b" role="tabpanel" aria-labelledby="tab-criterion-b">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success">
        <strong>CRITERION B: Inventions (Max = 100 Points)</strong>
    </h4>
    <p class="card-text">
        This section evaluates the faculty's contributions to inventions, patents, and other intellectual property.
    </p>

    <form id="criterion-b-form">
        <div class="row">
            <!-- Hidden Input for request_id -->
            <input type="hidden" id="request_id" name="request_id" value="" readonly>

            <!-- Sub-criterion B.1: Invention Patents (Sole Inventor) -->
            <div class="sub-criterion">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">
                    1. FOR EVERY PATENTED INVENTION
                </h5>
                <h6 class="mb-4">
                    <strong>1.1 PATENTABLE INVENTIONS, UTILITY MODELS AND INDUSTRIAL DESIGNS</strong>
                </h6>
                <h6 class="mb-4">
                    <strong>1.1.1 INVENTION PATENTS</strong>
                </h6>
                <h6 class="mb-4">
                    <strong>SOLE INVENTOR</strong>
                </h6>
                <!-- Responsive Table for Invention Patents (Sole Inventor) -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="invention-patents-sole-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name of the Invention</th>
                                <th scope="col">Application Date (mm/dd/yyyy)</th>
                                <th scope="col">Patent Application Stage</th>
                                <th scope="col">Date Accepted, Published, or Granted (mm/dd/yyyy)</th>
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
                                    <td><input type="text" class="form-control" name="kra2_b_invention_patents_sole[<?php echo $i; ?>][name]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_invention_patents_sole[<?php echo $i; ?>][application_date]"></td>
                                    <td>
                                        <select class="form-select" name="kra2_b_invention_patents_sole[<?php echo $i; ?>][application_stage]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Filed">Filed</option>
                                            <option value="Published">Published</option>
                                            <option value="Granted">Granted</option>
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="kra2_b_invention_patents_sole[<?php echo $i; ?>][granted_date]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra2_b_invention_patents_sole[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="invention_patents_sole_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_b_invention_patents_sole[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button for Invention Patents (Sole Inventor) -->
                <button type="button" class="btn btn-success mt-3 add-invention-patents-sole-row" data-table-id="invention-patents-sole-table">Add Row</button>
                <!-- Overall Scores for Invention Patents (Sole Inventor) -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_b_invention_patents_sole_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_b_invention_patents_sole_total" name="kra2_b_invention_patents_sole_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion B.2: Invention Patents (Multiple Inventors) -->
            <div class="sub-criterion mt-5">
                <h6 class="mb-4">
                    <strong>WITH MULTIPLE INVENTORS</strong>
                </h6>
                <!-- Responsive Table for Invention Patents (Multiple Inventors) -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="invention-patents-multiple-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name of the Invention</th>
                                <th scope="col">Date of Application (mm/dd/yyyy)</th>
                                <th scope="col">Patent Application Stage</th>
                                <th scope="col">Date Accepted, Published, or Granted (mm/dd/yyyy)</th>
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
                                    <td><input type="text" class="form-control" name="kra2_b_invention_patents_multiple[<?php echo $i; ?>][name]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_invention_patents_multiple[<?php echo $i; ?>][application_date]"></td>
                                    <td>
                                        <select class="form-select" name="kra2_b_invention_patents_multiple[<?php echo $i; ?>][application_stage]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Filed">Filed</option>
                                            <option value="Published">Published</option>
                                            <option value="Granted">Granted</option>
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="kra2_b_invention_patents_multiple[<?php echo $i; ?>][granted_date]"></td>
                                    <td><input type="number" class="form-control" name="kra2_b_invention_patents_multiple[<?php echo $i; ?>][contribution_percentage]" min="0" max="100"></td>
                                    <td><input type="text" class="form-control score-input" name="kra2_b_invention_patents_multiple[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="invention_patents_multiple_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_b_invention_patents_multiple[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button for Invention Patents (Multiple Inventors) -->
                <button type="button" class="btn btn-success mt-3 add-invention-patents-multiple-row" data-table-id="invention-patents-multiple-table">Add Row</button>
                <!-- Overall Scores for Invention Patents (Multiple Inventors) -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_b_invention_patents_multiple_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_b_invention_patents_multiple_total" name="kra2_b_invention_patents_multiple_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion B.3: Utility Models and Industrial Designs (Sole Inventor) -->
            <div class="sub-criterion mt-5">
                <h6 class="mb-4">
                    <strong>1.1.2 UTILITY MODELS AND INDUSTRIAL DESIGNS</strong>
                </h6>
                <h6 class="mb-4">
                    <strong>SOLE INVENTOR</strong>
                </h6>
                <!-- Responsive Table for Utility Models and Industrial Designs (Sole Inventor) -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="utility-models-sole-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name of Invention</th>
                                <th scope="col">Type of Patent</th>
                                <th scope="col">Date of Application (mm/dd/yyyy)</th>
                                <th scope="col">Date Granted (mm/dd/yyyy)</th>
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
                                    <td><input type="text" class="form-control" name="kra2_b_utility_models_sole[<?php echo $i; ?>][name]"></td>
                                    <td>
                                        <select class="form-select" name="kra2_b_utility_models_sole[<?php echo $i; ?>][type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Utility Model">Utility Model</option>
                                            <option value="Industrial Design">Industrial Design</option>
                                            <!-- Add more options if needed -->
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="kra2_b_utility_models_sole[<?php echo $i; ?>][application_date]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_utility_models_sole[<?php echo $i; ?>][granted_date]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra2_b_utility_models_sole[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="utility_models_sole_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_b_utility_models_sole[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button for Utility Models and Industrial Designs (Sole Inventor) -->
                <button type="button" class="btn btn-success mt-3 add-utility-models-sole-row" data-table-id="utility-models-sole-table">Add Row</button>
                <!-- Overall Scores for Utility Models and Industrial Designs (Sole Inventor) -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_b_utility_models_sole_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_b_utility_models_sole_total" name="kra2_b_utility_models_sole_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion B.4: Utility Models and Industrial Designs (Multiple Inventors) -->
            <div class="sub-criterion mt-5">
                <h6 class="mb-4">
                    <strong>WITH MULTIPLE INVENTORS</strong>
                </h6>
                <!-- Responsive Table for Utility Models and Industrial Designs (Multiple Inventors) -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="utility-models-multiple-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name of Invention</th>
                                <th scope="col">Type of Patent</th>
                                <th scope="col">Date of Application (mm/dd/yyyy)</th>
                                <th scope="col">Date Granted (mm/dd/yyyy)</th>
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
                                    <td><input type="text" class="form-control" name="kra2_b_utility_models_multiple[<?php echo $i; ?>][name]"></td>
                                    <td>
                                        <select class="form-select" name="kra2_b_utility_models_multiple[<?php echo $i; ?>][type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Utility Model">Utility Model</option>
                                            <option value="Industrial Design">Industrial Design</option>
                                            <!-- Add more options if needed -->
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="kra2_b_utility_models_multiple[<?php echo $i; ?>][application_date]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_utility_models_multiple[<?php echo $i; ?>][granted_date]"></td>
                                    <td><input type="number" class="form-control" name="kra2_b_utility_models_multiple[<?php echo $i; ?>][contribution_percentage]" min="0" max="100"></td>
                                    <td><input type="text" class="form-control score-input" name="kra2_b_utility_models_multiple[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="utility_models_multiple_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_b_utility_models_multiple[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button for Utility Models and Industrial Designs (Multiple Inventors) -->
                <button type="button" class="btn btn-success mt-3 add-utility-models-multiple-row" data-table-id="utility-models-multiple-table">Add Row</button>
                <!-- Overall Scores for Utility Models and Industrial Designs (Multiple Inventors) -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_b_utility_models_multiple_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_b_utility_models_multiple_total" name="kra2_b_utility_models_multiple_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion B.5: Commercialized Patented Products (Local) -->
            <div class="sub-criterion mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">
                    1.2 COMMERCIALIZED PATENTED PRODUCTS
                </h5>
                <h6 class="mb-4">
                    <strong>1.2.1 LOCAL (MAX = 20 POINTS)</strong>
                </h6>
                <!-- Responsive Table for Commercialized Patented Products (Local) -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="commercialized-products-local-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name of Patented Product</th>
                                <th scope="col">Type of Product</th>
                                <th scope="col">Date Patented</th>
                                <th scope="col">Date Product was First Commercialized</th>
                                <th scope="col">Area/Place</th>
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
                                    <td><input type="text" class="form-control" name="kra2_b_commercialized_products_local[<?php echo $i; ?>][name]"></td>
                                    <td>
                                        <select class="form-select" name="kra2_b_commercialized_products_local[<?php echo $i; ?>][type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Product 1">Product 1</option>
                                            <option value="Product 2">Product 2</option>
                                            <!-- Add more options if needed -->
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="kra2_b_commercialized_products_local[<?php echo $i; ?>][date_patented]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_commercialized_products_local[<?php echo $i; ?>][date_commercialized]"></td>
                                    <td><input type="text" class="form-control" name="kra2_b_commercialized_products_local[<?php echo $i; ?>][area_place]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra2_b_commercialized_products_local[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="commercialized_products_local_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_b_commercialized_products_local[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button for Commercialized Patented Products (Local) -->
                <button type="button" class="btn btn-success mt-3 add-commercialized-products-local-row" data-table-id="commercialized-products-local-table">Add Row</button>
                <!-- Overall Scores for Commercialized Patented Products (Local) -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_b_commercialized_products_local_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_b_commercialized_products_local_total" name="kra2_b_commercialized_products_local_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion B.6: Commercialized Patented Products (International) -->
            <div class="sub-criterion mt-5">
                <h6 class="mb-4">
                    <strong>1.2.2 INTERNATIONAL (MAX = 30 POINTS)</strong>
                </h6>
                <!-- Responsive Table for Commercialized Patented Products (International) -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="commercialized-products-international-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name of Patented Product</th>
                                <th scope="col">Type of Product</th>
                                <th scope="col">Date Patented</th>
                                <th scope="col">Date Product was First Commercialized</th>
                                <th scope="col">Area/Place</th>
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
                                    <td><input type="text" class="form-control" name="kra2_b_commercialized_products_international[<?php echo $i; ?>][name]"></td>
                                    <td>
                                        <select class="form-select" name="kra2_b_commercialized_products_international[<?php echo $i; ?>][type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Product 1">Product 1</option>
                                            <option value="Product 2">Product 2</option>
                                            <!-- Add more options if needed -->
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="kra2_b_commercialized_products_international[<?php echo $i; ?>][date_patented]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_commercialized_products_international[<?php echo $i; ?>][date_commercialized]"></td>
                                    <td><input type="text" class="form-control" name="kra2_b_commercialized_products_international[<?php echo $i; ?>][area_place]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra2_b_commercialized_products_international[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="commercialized_products_international_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_b_commercialized_products_international[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button for Commercialized Patented Products (International) -->
                <button type="button" class="btn btn-success mt-3 add-commercialized-products-international-row" data-table-id="commercialized-products-international-table">Add Row</button>
                <!-- Overall Scores for Commercialized Patented Products (International) -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_b_commercialized_products_international_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_b_commercialized_products_international_total" name="kra2_b_commercialized_products_international_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sub-criterion mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">
                    2. FOR EVERY NON-PATENTABLE INVENTION
                </h5>
                <h6 class="mb-4">
                    <strong>2.1 COPYRIGHTED AND UTILIZED SOFTWARE PRODUCTS</strong>
                </h6>
                <h6 class="mb-4">
                    <strong>2.1.1 NEW SOFTWARE PRODUCTS (COMPUTER PROGRAM)</strong>
                </h6>
                <h6 class="mb-4">
                    <strong>SOLE DEVELOPER</strong>
                </h6>
                <!-- Responsive Table for Commercialized Patented Products (International) -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="new-software-products-sole-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name of the Software</th>
                                <th scope="col">Date Copyrighted</th>
                                <th scope="col">Date Utilized</th>
                                <th scope="col">Name of End Users</th>
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
                                    <td><input type="text" class="form-control" name="kra2_b_new_software_products_sole[<?php echo $i; ?>][name]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_new_software_products_sole[<?php echo $i; ?>][date_copyrighted]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_new_software_products_sole[<?php echo $i; ?>][date_utilized]"></td>
                                    <td><input type="text" class="form-control" name="kra2_b_new_software_products_sole[<?php echo $i; ?>][end_users]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra2_b_new_software_products_sole[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="new_software_products_sole_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_b_new_software_products_sole[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button for Commercialized Patented Products (International) -->
                <button type="button" class="btn btn-success mt-3 add-new-software-products-sole-row" data-table-id="new-software-products-sole-table">Add Row</button>
                <!-- Overall Scores for Commercialized Patented Products (International) -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_b_new_software_products_sole_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_b_new_software_products_sole_total" name="kra2_b_new_software_products_sole_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sub-criterion mt-5">
                <h6 class="mb-4">
                    <strong>WITH MULTIPLE DEVELOPERS</strong>
                </h6>
                <!-- Responsive Table for Commercialized Patented Products (International) -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="new-software-products-multiple-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name of the Software</th>
                                <th scope="col">Date Copyrighted</th>
                                <th scope="col">Date Utilized</th>
                                <th scope="col">Name of End-user</th>
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
                                    <td><input type="text" class="form-control" name="kra2_b_new_software_products_multiple[<?php echo $i; ?>][name]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_new_software_products_multiple[<?php echo $i; ?>][date_copyrighted]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_new_software_products_multiple[<?php echo $i; ?>][date_utilized]"></td>
                                    <td><input type="text" class="form-control" name="kra2_b_new_software_products_multiple[<?php echo $i; ?>][end_users]"></td>
                                    <td><input type="number" class="form-control" name="kra2_b_new_software_products_multiple[<?php echo $i; ?>][contribution_percentage]" min="0" max="100"></td>
                                    <td><input type="text" class="form-control score-input" name="kra2_b_new_software_products_multiple[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="new_software_products_multiple_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_b_new_software_products_multiple[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button for Commercialized Patented Products (International) -->
                <button type="button" class="btn btn-success mt-3 add-new-software-products-multiple-row" data-table-id="new-software-products-multiple-table">Add Row</button>
                                <!-- Overall Scores for Commercialized Patented Products (International) -->
                                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_b_new_software_products_multiple_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_b_new_software_products_multiple_total" name="kra2_b_new_software_products_multiple_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sub-criterion mt-5">
                <h6 class="mb-4">
                    <strong>2.1.2 UPDATED SOFTWARE PRODUCTS</strong>
                </h6>
                <h6 class="mb-4">
                    <strong>SOLE/CO-DEVELOPER</strong>
                </h6>
                <!-- Responsive Table for Updated Software Products -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="updated-software-products-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name of the Software</th>
                                <th scope="col">Date Copyrighted</th>
                                <th scope="col">Date Utilized</th>
                                <th scope="col">Contribution</th>
                                <th scope="col">Specify New</th>
                                <th scope="col">Name of End Users</th>
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
                                    <td><input type="text" class="form-control" name="kra2_b_updated_software_products[<?php echo $i; ?>][name]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_updated_software_products[<?php echo $i; ?>][date_copyrighted]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_updated_software_products[<?php echo $i; ?>][date_utilized]"></td>
                                    <td>
                                        <select class="form-select" name="kra2_b_updated_software_products[<?php echo $i; ?>][contribution]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Updates in Functionalities">Updates in Functionalities</option>
                                            <option value="Inclusion of new features">Inclusion of new features</option>
                                            <option value="Improvement in software performance">Improvement in software performance</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-select" name="kra2_b_updated_software_products[<?php echo $i; ?>][specify_new]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="kra2_b_updated_software_products[<?php echo $i; ?>][end_users]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra2_b_updated_software_products[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="updated_software_products_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_b_updated_software_products[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button for Updated Software Products -->
                <button type="button" class="btn btn-success mt-3 add-updated-software-products-row" data-table-id="updated-software-products-table">Add Row</button>
                <!-- Overall Scores for Updated Software Products -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_b_updated_software_products_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_b_updated_software_products_total" name="kra2_b_updated_software_products_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion B.7: New Plant Variety or Animal Breeds -->
            <div class="sub-criterion mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">
                2.2 NEW PLANT VARIETY OR ANIMAL BREEDS DEVELOPED/NEW MICROBIAL STRAINS ISOLATED THAT ARE PROPAGATED OR REPRODUCED
                </h5>
                <h6 class="mb-4">
                    <strong>SOLE DEVELOPER</strong>
                </h6>
                <!-- Responsive Table for New Plant Variety or Animal Breeds (Sole Developer) -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="new-plant-variety-sole-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name of Plant Variety, Animal Breed, or Microbial Strain</th>
                                <th scope="col">Type (Plant, Animal, or Microbial)</th>
                                <th scope="col">Date Completed</th>
                                <th scope="col">Date Registered</th>
                                <th scope="col">Date of Propagation</th>
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
                                    <td><input type="text" class="form-control" name="kra2_b_new_plant_variety_sole[<?php echo $i; ?>][name]"></td>
                                    <td>
                                        <select class="form-select" name="kra2_b_new_plant_variety_sole[<?php echo $i; ?>][type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Plant">Plant</option>
                                            <option value="Animal">Animal</option>
                                            <option value="Microbial">Microbial</option>
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="kra2_b_new_plant_variety_sole[<?php echo $i; ?>][date_completed]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_new_plant_variety_sole[<?php echo $i; ?>][date_registered]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_new_plant_variety_sole[<?php echo $i; ?>][date_propagation]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra2_b_new_plant_variety_sole[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="new_plant_variety_sole_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_b_new_plant_variety_sole[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button for New Plant Variety or Animal Breeds (Sole Developer) -->
                <button type="button" class="btn btn-success mt-3 add-new-plant-variety-sole-row" data-table-id="new-plant-variety-sole-table">Add Row</button>
                <!-- Overall Scores for New Plant Variety or Animal Breeds (Sole Developer) -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_b_new_plant_variety_sole_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_b_new_plant_variety_sole_total" name="kra2_b_new_plant_variety_sole_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion B.8: New Plant Variety or Animal Breeds (Multiple Developers) -->
            <div class="sub-criterion mt-5">
                <h6 class="mb-4">
                    <strong>WITH MULTIPLE DEVELOPERS</strong>
                </h6>
                <!-- Responsive Table for New Plant Variety or Animal Breeds (Multiple Developers) -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="new-plant-variety-multiple-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name of Plant Variety, Animal Breed, or Microbial Strain</th>
                                <th scope="col">Type (Plant, Animal, or Microbial)</th>
                                <th scope="col">Date Completed</th>
                                <th scope="col">Date Registered</th>
                                <th scope="col">Date of Propagation</th>
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
                                    <td><input type="text" class="form-control" name="kra2_b_new_plant_variety_multiple[<?php echo $i; ?>][name]"></td>
                                    <td>
                                        <select class="form-select" name="kra2_b_new_plant_variety_multiple[<?php echo $i; ?>][type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Plant">Plant</option>
                                            <option value="Animal">Animal</option>
                                            <option value="Microbial">Microbial</option>
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="kra2_b_new_plant_variety_multiple[<?php echo $i; ?>][date_completed]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_new_plant_variety_multiple[<?php echo $i; ?>][date_registered]"></td>
                                    <td><input type="date" class="form-control" name="kra2_b_new_plant_variety_multiple[<?php echo $i; ?>][date_propagation]"></td>
                                    <td><input type="number" class="form-control" name="kra2_b_new_plant_variety_multiple[<?php echo $i; ?>][contribution_percentage]" min="0" max="100"></td>
                                    <td><input type="text" class="form-control score-input" name="kra2_b_new_plant_variety_multiple[<?php echo $i; ?>][score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="new_plant_variety_multiple_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_b_new_plant_variety_multiple[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button for New Plant Variety or Animal Breeds (Multiple Developers) -->
                <button type="button" class="btn btn-success mt-3 add-new-plant-variety-multiple-row" data-table-id="new-plant-variety-multiple-table">Add Row</button>
                <!-- Overall Scores for New Plant Variety or Animal Breeds (Multiple Developers) -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_b_new_plant_variety_multiple_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_b_new_plant_variety_multiple_total" name="kra2_b_new_plant_variety_multiple_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- End of row -->

        <!-- Save Button -->
        <div class="d-flex justify-content-end mt-5">
            <button type="button" class="btn btn-success" id="save-criterion-b">Save Criterion B</button>
        </div>
    </form>
</div>

<!-- (Modals remain the same as in your original criterion_a.php) -->

<!-- Include Criterion B-specific JS for KRA 2 (You'll need to create this file) -->
<script src="<?php echo BASE_URL; ?>/php/includes/career_progress_tracking/inventions/js/criterion_b.js"></script>
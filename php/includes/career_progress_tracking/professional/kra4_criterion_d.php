<!-- careerpath/php/includes/career_progress_tracking/support_to_operations/criterion_d.php -->
<div class="tab-pane fade" id="criterion-d" role="tabpanel" aria-labelledby="tab-criterion-d">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION D: Bonus Indicators for Newly Appointed Faculty (Max = 20 Points)</strong></h4>
    <p class="card-text">
        This section provides bonus points for newly appointed faculty based on their full-time academic service in higher learning institutions and industry experience.
    </p>
    <form id="criterion-d-form" enctype="multipart/form-data">
        <div class="row">
            <!-- Hidden input for request_id -->
            <input type="hidden" id="request_id_d" name="request_id_d" value="" readonly>

            <!-- Section 1: Full-Time Academic Service -->
            <div class="sub-criterion">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1. FOR EVERY YEAR OF FULL-TIME ACADEMIC SERVICE IN AN INSTITUTION OF HIGHER LEARNING</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="academic-service-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Designation/Position</th>
                                <th scope="col">Name of HEIs</th>
                                <th scope="col">No. of Years</th>
                                <th scope="col">Period Covered (Start)</th>
                                <th scope="col">Period Covered (End)</th>
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
                                    <td>
                                        <select class="form-select academic-position-select" name="kra4_d_academic_service[<?php echo $i; ?>][position]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="President">President</option>
                                            <option value="Vice President">Vice President</option>
                                            <option value="Dean or Director">Dean or Director</option>
                                            <option value="Department/Program Head">Department/Program Head</option>
                                            <option value="Faculty member">Faculty member</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="kra4_d_academic_service[<?php echo $i; ?>][hei_name]"></td>
                                    <td><input type="number" class="form-control" name="kra4_d_academic_service[<?php echo $i; ?>][num_years]" min="0"></td>
                                    <td><input type="date" class="form-control" name="kra4_d_academic_service[<?php echo $i; ?>][period_start]"></td>
                                    <td><input type="date" class="form-control" name="kra4_d_academic_service[<?php echo $i; ?>][period_end]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra4_d_academic_service[<?php echo $i; ?>][score]" placeholder="0" readonly></td>
                                    <td>
                                        <input type="text" class="form-control evidence-link" name="kra4_d_academic_service[<?php echo $i; ?>][evidence_link]" placeholder="Link to Evidence">
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
                <button type="button" class="btn btn-success mt-3 add-row" data-table-id="academic-service-table">Add Row</button>
                <!-- Overall Scores for Academic Service -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra4_d_academic_service_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra4_d_academic_service_total" name="kra4_d_academic_service_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 2: Industry Experience -->
            <div class="sub-criterion mt-5">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">2. FOR EVERY YEAR OF INDUSTRY EXPERIENCE (NON-ACADEMIC ORGANIZATION)</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="industry-experience-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Name of Company/Organization</th>
                                <th scope="col">Designation/Position</th>
                                <th scope="col">No. of Years</th>
                                <th scope="col">Period Covered (Start)</th>
                                <th scope="col">Period Covered (End)</th>
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
                                    <td><input type="text" class="form-control" name="kra4_d_industry_experience[<?php echo $i; ?>][company_name]"></td>
                                    <td>
                                        <select class="form-select industry-position-select" name="kra4_d_industry_experience[<?php echo $i; ?>][position]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Managerial/Supervisory">Managerial/Supervisory</option>
                                            <option value="Technical/Skilled">Technical/Skilled</option>
                                            <option value="Support/Administrative">Support/Administrative</option>
                                        </select>
                                    </td>
                                    <td><input type="number" class="form-control" name="kra4_d_industry_experience[<?php echo $i; ?>][num_years]" min="0"></td>
                                    <td><input type="date" class="form-control" name="kra4_d_industry_experience[<?php echo $i; ?>][period_start]"></td>
                                    <td><input type="date" class="form-control" name="kra4_d_industry_experience[<?php echo $i; ?>][period_end]"></td>
                                    <td><input type="text" class="form-control score-input" name="kra4_d_industry_experience[<?php echo $i; ?>][score]" placeholder="0" readonly></td>
                                    <td>
                                        <input type="text" class="form-control evidence-link" name="kra4_d_industry_experience[<?php echo $i; ?>][evidence_link]" placeholder="Link to Evidence">
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
                <button type="button" class="btn btn-success mt-3 add-row" data-table-id="industry-experience-table">Add Row</button>
                <!-- Overall Scores for Industry Experience -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra4_d_industry_experience_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra4_d_industry_experience_total" name="kra4_d_industry_experience_total" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-end mt-5">
            <button type="button" class="btn btn-success" id="save-criterion-d">Save Criterion D</button>
        </div>
    </form>
</div>
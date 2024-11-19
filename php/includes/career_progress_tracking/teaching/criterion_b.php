<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_b.php -->
<div class="tab-pane fade" id="criterion-b" role="tabpanel" aria-labelledby="tab-criterion-b">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION B: Curriculum and Instructional Materials Development (Max = 30 Points)</strong></h4>

    <h5>1. FOR EVERY INSTRUCTIONAL MATERIAL DEVELOPED AND APPROVED FOR USE</h5>


    <!-- Sole Authorship -->
    <div class="mt-4">
        <h5 class="mb-3 pb-2 border-bottom border-2 border-success">1.1 Sole Authorship</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="sole-authorship-table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Title of Instructional Material</th>
                        <th scope="col">Type of IM</th>
                        <th scope="col">Reviewer/Repository</th>
                        <th scope="col">Date Published</th>
                        <th scope="col">Date Approved</th>
                        <th scope="col">Faculty Score</th>
                        <th scope="col">Link to Evidence</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><input type="text" class="form-control" name="sole_title[]" required></td>
                        <td><input type="text" class="form-control" name="sole_type[]" required></td>
                        <td><input type="text" class="form-control" name="sole_reviewer[]" required></td>
                        <td><input type="date" class="form-control" name="sole_date_published[]" required></td>
                        <td><input type="date" class="form-control" name="sole_date_approved[]" required></td>
                        <td><input type="number" class="form-control" name="sole_faculty_score[]" step="0.01" min="0" required></td>
                        <td><input type="url" class="form-control" name="sole_evidence_link[]" placeholder="http://example.com/evidence" required></td>
                        <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-success mt-3 add-row" data-table-id="sole-authorship-table">Add Row</button>
    </div>

    <!-- Co-Authorship -->
    <div class="mt-5">
        <h5 class="mb-3 pb-2 border-bottom border-2 border-success">1.2 Co-Authorship</h5>
        <p>
            <strong>Note:</strong> 
            Every Instructional Material with Multiple Authors should be Accompanied by a Certification using FORM I-B1a
        </p>


        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="co-authorship-table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Title of IM</th>
                        <th scope="col">Type of IM</th>
                        <th scope="col">Reviewer/Repository</th>
                        <th scope="col">Date Published</th>
                        <th scope="col">Date Approved</th>
                        <th scope="col">% Contribution</th>
                        <th scope="col">Faculty Score</th>
                        <th scope="col">Link to Evidence</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><input type="text" class="form-control" name="co_title[]" required></td>
                        <td><input type="text" class="form-control" name="co_type[]" required></td>
                        <td><input type="text" class="form-control" name="co_reviewer[]" required></td>
                        <td><input type="date" class="form-control" name="co_date_published[]" required></td>
                        <td><input type="date" class="form-control" name="co_date_approved[]" required></td>
                        <td><input type="number" class="form-control" name="co_contribution[]" step="0.01" min="0" max="100" required></td>
                        <td><input type="number" class="form-control" name="co_faculty_score[]" step="0.01" min="0" required></td>
                        <td><input type="url" class="form-control" name="co_evidence_link[]" placeholder="http://example.com/evidence" required></td>
                        <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-success mt-3 add-row" data-table-id="co-authorship-table">Add Row</button>
    </div>

    <!-- Academic Programs -->
    <div class="mt-5">
        <h5 class="mb-3 pb-2 border-bottom border-2 border-success">2. Academic Programs Developed/Revised and Implemented</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="academic-programs-table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Name of Program</th>
                        <th scope="col">Type of Program</th>
                        <th scope="col">Board Approval</th>
                        <th scope="col">Year Implemented</th>
                        <th scope="col">Role</th>
                        <th scope="col">Faculty Score</th>
                        <th scope="col">Link to Evidence</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><input type="text" class="form-control" name="program_name[]" required></td>
                        <td><input type="text" class="form-control" name="program_type[]" required></td>
                        <td><input type="text" class="form-control" name="program_approval[]" required></td>
                        <td><input type="number" class="form-control" name="program_year[]" min="1900" max="2100" required></td>
                        <td><input type="text" class="form-control" name="program_role[]" required></td>
                        <td><input type="number" class="form-control" name="program_faculty_score[]" step="0.01" min="0" required></td>
                        <td><input type="url" class="form-control" name="program_evidence_link[]" placeholder="http://example.com/evidence" required></td>
                        <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-success mt-3 add-row" data-table-id="academic-programs-table">Add Row</button>
    </div>

    <!-- Save Button -->
    <div class="d-flex justify-content-end mt-5">
        <button type="submit" class="btn btn-success" id="save-criterion-b">Save Criterion B</button>
    </div>
</div>

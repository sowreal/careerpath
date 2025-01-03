<div class="tab-pane fade criterion-tab" id="criterion-b" role="tabpanel" aria-labelledby="tab-criterion-b">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION B: Curriculum & Material Development (Max = 30 Points)</strong></h4>

    <div class="mt-5">
        <h5 class="mb-4 pb-2 border-bottom border-2 border-success">1. Sole Authorship</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="sole-authorship-table">
                <thead class="table-light">
                    <tr>
                        <th>Title of Instructional Material</th>
                        <th>Type of Material</th>
                        <th>Reviewer/Equivalent</th>
                        <th>Publisher/Repository</th>
                        <th>Date Published</th>
                        <th>Date Approved</th>
                        <th>Faculty Score</th>
                        <th>Link to Evidence</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" name="sole_title[]"></td>
                        <td><input type="text" class="form-control" name="sole_type[]"></td>
                        <td><input type="text" class="form-control" name="sole_reviewer[]"></td>
                        <td><input type="text" class="form-control" name="sole_publisher[]"></td>
                        <td><input type="date" class="form-control" name="sole_published_date[]"></td>
                        <td><input type="date" class="form-control" name="sole_approved_date[]"></td>
                        <td><input type="number" class="form-control rating-input" name="sole_score[]" placeholder="0.00" required></td>
                        <td><input type="url" class="form-control" name="sole_link[]" pattern="https?://.+" required></td>
                        <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
                        <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-success mt-3 add-row" data-table-id="sole-authorship-table">Add Row</button>
    </div>

    <div class="mt-5">
        <h5 class="mb-4 pb-2 border-bottom border-2 border-success">2. Co-Authorship</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="co-authorship-table">
                <thead class="table-light">
                    <tr>
                        <th>Title of Instructional Material</th>
                        <th>Type of Material</th>
                        <th>Reviewer/Equivalent</th>
                        <th>Publisher/Repository</th>
                        <th>Date Published</th>
                        <th>Date Approved</th>
                        <th>% Contribution</th>
                        <th>Faculty Score</th>
                        <th>Link to Evidence</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" name="co_title[]"></td>
                        <td><input type="text" class="form-control" name="co_type[]"></td>
                        <td><input type="text" class="form-control" name="co_reviewer[]"></td>
                        <td><input type="text" class="form-control" name="co_publisher[]"></td>
                        <td><input type="date" class="form-control" name="co_published_date[]"></td>
                        <td><input type="date" class="form-control" name="co_approved_date[]"></td>
                        <td><input type="number" class="form-control" name="co_contribution[]"></td>
                        <td><input type="number" class="form-control rating-input" name="co_score[]" placeholder="0.00" required></td>
                        <td><input type="url" class="form-control" name="co_link[]" pattern="https?://.+" required></td>
                        <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
                        <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-success mt-3 add-row" data-table-id="co-authorship-table">Add Row</button>
    </div>

    <div class="mt-5">
        <h5 class="mb-4 pb-2 border-bottom border-2 border-success">3. Academic Programs Developed/Revised and Implemented</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="academic-programs-table">
                <thead class="table-light">
                    <tr>
                        <th>Name of Academic Degree Program</th>
                        <th>Type of Program</th>
                        <th>Board Approval (Res. No.)</th>
                        <th>Academic Year Implemented</th>
                        <th>Role</th>
                        <th>Faculty Score</th>
                        <th>Link to Evidence</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" name="program_name[]"></td>
                        <td><input type="text" class="form-control" name="program_type[]"></td>
                        <td><input type="text" class="form-control" name="program_approval[]"></td>
                        <td><input type="text" class="form-control" name="program_year[]"></td>
                        <td><input type="text" class="form-control" name="program_role[]"></td>
                        <td><input type="number" class="form-control rating-input" name="program_score[]" placeholder="0.00" required></td>
                        <td><input type="url" class="form-control" name="program_link[]" pattern="https?://.+" required></td>
                        <td><button type="button" class="btn btn-primary btn-sm view-remarks" data-first-remark="" data-second-remark="">View Remarks</button></td>
                        <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-success mt-3 add-row" data-table-id="academic-programs-table">Add Row</button>
    </div>

</div>
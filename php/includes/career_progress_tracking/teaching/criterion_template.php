<div class="tab-pane fade" id="criterion-b" role="tabpanel" aria-labelledby="tab-criterion-b">
    <h4 class="mb-3 pb-2 border-bottom border-3 border-success">
        CRITERION B: Curriculum & Instructional Materials Development (Max = 30 Points)
    </h4>
    <p>Instructions: Provide details of instructional materials developed and approved for use. Include evidence links where applicable.</p>

    <div class="row">
        <!-- Sole Authorship Section -->
        <div class="col-12 mt-4">
            <h5 class="mb-3 pb-1 border-bottom border-2 border-success">
                1. Sole Authorship
            </h5>
            <table class="table table-bordered align-middle" id="sole-authorship-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title of Instructional Material</th>
                        <th>Type of Instructional Material</th>
                        <th>Reviewer / Repository</th>
                        <th>Date Published</th>
                        <th>Date Approved</th>
                        <th>Faculty Score</th>
                        <th>Link to Evidence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic rows -->
                </tbody>
            </table>
            <button class="btn btn-success mt-3 add-row" data-table-id="sole-authorship-table">Add Row</button>
        </div>

        <!-- Co-Authorship Section -->
        <div class="col-12 mt-5">
            <h5 class="mb-3 pb-2 border-bottom border-2 border-success">
                2. Co-Authorship
            </h5>
            <p class="mb-2">
                Note: Each material with multiple authors should be accompanied by a certification using Form B1a.
            </p>
            <table class="table table-bordered align-middle" id="co-authorship-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title of Instructional Material</th>
                        <th>Type of Instructional Material</th>
                        <th>Reviewer / Repository</th>
                        <th>Date Published</th>
                        <th>Date Approved</th>
                        <th>% Contribution</th>
                        <th>Faculty Score</th>
                        <th>Link to Evidence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic rows -->
                </tbody>
            </table>
            <button class="btn btn-success mt-3 add-row" data-table-id="co-authorship-table">Add Row</button>
        </div>

        <!-- Academic Programs Section -->
        <div class="col-12 mt-5">
            <h5 class="mb-3 pb-2 border-bottom border-2 border-success">
                3. Academic Programs Developed / Revised & Implemented
            </h5>
            <table class="table table-bordered align-middle" id="academic-programs-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name of Program</th>
                        <th>Type of Program</th>
                        <th>Board Approval</th>
                        <th>Academic Year</th>
                        <th>Role</th>
                        <th>Faculty Score</th>
                        <th>Link to Evidence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic rows -->
                </tbody>
            </table>
            <button class="btn btn-success mt-3 add-row" data-table-id="academic-programs-table">Add Row</button>
        </div>
    </div>

    <!-- Save Button -->
    <div class="col-12 mt-5">
        <button class="btn btn-success" id="save-criterion-b">Save Criterion B</button>
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
</div>

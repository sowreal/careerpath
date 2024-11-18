<div class="tab-pane fade" id="criterion-c" role="tabpanel" aria-labelledby="tab-criterion-c">
    <h4 class="mb-3 pb-2 border-bottom border-3 border-success">
        CRITERION C: Thesis, Dissertation, and Mentorship Services (Max = 10 Points)
    </h4>
    <p>Instructions: Provide details for services rendered as an adviser, panel member, or mentor. Include evidence links where applicable.</p>

    <div class="row">
        <!-- Adviser Section -->
        <div class="col-12 mt-4">
            <h5 class="mb-3 pb-1 border-bottom border-2 border-success">
                1.1 Services Rendered to Students as Adviser
            </h5>
            <table class="table table-bordered align-middle" id="adviser-services-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Requirement</th>
                        <th>AY 2019-2020</th>
                        <th>AY 2020-2021</th>
                        <th>AY 2021-2022</th>
                        <th>AY 2022-2023</th>
                        <th>Faculty Score</th>
                        <th>Link to Evidence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic rows -->
                </tbody>
            </table>
            <button class="btn btn-success mt-3 add-row" data-table-id="adviser-services-table">Add Row</button>
        </div>

        <!-- Panel Section -->
        <div class="col-12 mt-5">
            <h5 class="mb-3 pb-1 border-bottom border-2 border-success">
                1.2 Services Rendered to Students as Panel Member
            </h5>
            <table class="table table-bordered align-middle" id="panel-services-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Requirement</th>
                        <th>AY 2019-2020</th>
                        <th>AY 2020-2021</th>
                        <th>AY 2021-2022</th>
                        <th>AY 2022-2023</th>
                        <th>Faculty Score</th>
                        <th>Link to Evidence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic rows -->
                </tbody>
            </table>
            <button class="btn btn-success mt-3 add-row" data-table-id="panel-services-table">Add Row</button>
        </div>

        <!-- Mentor Section -->
        <div class="col-12 mt-5">
            <h5 class="mb-3 pb-1 border-bottom border-2 border-success">
                2. Services Rendered as Mentor
            </h5>
            <table class="table table-bordered align-middle" id="mentor-services-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name of Academic Competition</th>
                        <th>Name of Sponsor Organization</th>
                        <th>Award Received</th>
                        <th>Date Awarded</th>
                        <th>Faculty Score</th>
                        <th>Link to Evidence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Dynamic rows -->
                </tbody>
            </table>
            <button class="btn btn-success mt-3 add-row" data-table-id="mentor-services-table">Add Row</button>
        </div>
    </div>

    <!-- Save Button -->
    <div class="col-12 mt-5">
        <button class="btn btn-success" id="save-criterion-c">Save Criterion C</button>
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

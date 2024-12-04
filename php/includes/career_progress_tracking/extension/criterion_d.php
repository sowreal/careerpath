<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_c.php -->
<div class="tab-pane fade" id="criterion-c" role="tabpanel" aria-labelledby="tab-criterion-c">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success"><strong>CRITERION DDDD - BONUS CRITERION (MAX = 20 POINTS)</strong></h4>

    <!-- Section 1: Services Rendered to Students as Adviser -->
    <h5>1. FOR SERVICES RENDERED TO STUDENTS AS:</h5>

    <!-- 1.1 Adviser -->
    <div class="mt-4">
        <h5 class="mb-3 pb-2 border-bottom border-2 border-success">1.1 Adviser</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="adviser-table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Requirement</th>
                        <th scope="col">AY 2019-2020</th>
                        <th scope="col">AY 2020-2021</th>
                        <th scope="col">AY 2021-2022</th>
                        <th scope="col">AY 2022-2023</th>
                        <th scope="col">Faculty Score</th>
                        <th scope="col">Link to Evidence</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $adviser_requirements = ["Special/Capstone Project", "Undergraduate Thesis", "Master's Thesis", "Dissertation"];
                    foreach ($adviser_requirements as $index => $requirement): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $requirement; ?></td>
                            <?php for ($year = 1; $year <= 4; $year++): ?>
                                <td><input type="number" class="form-control" name="adviser_ay_<?php echo $year; ?>[]" step="1" min="0" required></td>
                            <?php endfor; ?>
                            <td><input type="number" class="form-control" name="adviser_score[]" step="0.01" min="0" required></td>
                            <td><input type="url" class="form-control" name="adviser_evidence_link[]" placeholder="http://example.com/evidence" required></td>
                            <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-success mt-3 add-row" data-table-id="adviser-table">Add Row</button>
    </div>

    <!-- 1.2 Panel -->
    <div class="mt-5">
        <h5 class="mb-3 pb-2 border-bottom border-2 border-success">1.2 Panel</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="panel-table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Requirement</th>
                        <th scope="col">AY 2019-2020</th>
                        <th scope="col">AY 2020-2021</th>
                        <th scope="col">AY 2021-2022</th>
                        <th scope="col">AY 2022-2023</th>
                        <th scope="col">Faculty Score</th>
                        <th scope="col">Link to Evidence</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $panel_requirements = ["Special/Capstone Project", "Undergraduate Thesis", "Master's Thesis", "Dissertation"];
                    foreach ($panel_requirements as $index => $requirement): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $requirement; ?></td>
                            <?php for ($year = 1; $year <= 4; $year++): ?>
                                <td><input type="number" class="form-control" name="panel_ay_<?php echo $year; ?>[]" step="1" min="0" required></td>
                            <?php endfor; ?>
                            <td><input type="number" class="form-control" name="panel_score[]" step="0.01" min="0" required></td>
                            <td><input type="url" class="form-control" name="panel_evidence_link[]" placeholder="http://example.com/evidence" required></td>
                            <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-success mt-3 add-row" data-table-id="panel-table">Add Row</button>
    </div>

    <!-- Section 2: Services Rendered as Mentor -->
    <div class="mt-5">
        <h5 class="mb-3 pb-2 border-bottom border-2 border-success">2. FOR SERVICES RENDERED AS MENTOR</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle" id="mentor-table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Name of Academic Competition</th>
                        <th scope="col">Name of Sponsor Organization</th>
                        <th scope="col">Award Received</th>
                        <th scope="col">Date Awarded</th>
                        <th scope="col">Faculty Score</th>
                        <th scope="col">Link to Evidence</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><input type="text" class="form-control" name="mentor_competition[]" required></td>
                            <td><input type="text" class="form-control" name="mentor_organization[]" required></td>
                            <td><input type="text" class="form-control" name="mentor_award[]" required></td>
                            <td><input type="date" class="form-control" name="mentor_date_awarded[]" required></td>
                            <td><input type="number" class="form-control" name="mentor_score[]" step="0.01" min="0" required></td>
                            <td><input type="url" class="form-control" name="mentor_evidence_link[]" placeholder="http://example.com/evidence" required></td>
                            <td><button type="button" class="btn btn-danger btn-sm delete-row">Delete</button></td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-success mt-3 add-row" data-table-id="mentor-table">Add Row</button>
    </div>

    <!-- Save Button -->
    <div class="d-flex justify-content-end mt-5">
        <button type="submit" class="btn btn-success" id="save-criterion-c">Save Criterion C</button>
    </div>
</div>


<!-- careerpath/php/includes/career_progress_tracking/teaching/criterion_a.php -->
<div class="tab-pane fade show active" id="criterion-a" role="tabpanel" aria-labelledby="tab-criterion-a">
    <h4 class="mb-3 pb-2 border-bottom border-3 border-success">CRITERION A: Teaching Effectiveness (Max = 60 Points)</h4>
    <p>
        <strong>FACULTY PERFORMANCE:</strong> Enter the average rating received by the faculty per semester.<br>  
        For newly appointed faculty from private HEI, LUCs, TESDA/DepEd schools who decide to proceed with the evaluation, enter "0" for semesters without student and supervisor evaluations.
    </p>


    <div class="row">
        <!-- Student Evaluation Section -->
        <div class="col-12 mt-4">
            <h5 class="mb-3 pb-1 border-bottom border-2 border-success">1.1 Student Evaluation (60%)</h5>

            <!-- Divisor Selection -->
            <div class="row g-3 align-items-center mb-3">
                <div class="col-md-6">
                    <label for="student-divisor" class="form-label">Number of Semesters to Deduct from Divisor (if applicable):</label>
                    <select class="form-select" id="student-divisor">
                        <?php for ($i = 0; $i <= 8; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="student-reason" class="form-label">Reason for Reducing the Divisor:</label>
                    <select class="form-select" id="student-reason">
                        <option value="">Select Option</option>
                        <option value="not_applicable">Not Applicable</option>
                        <option value="on_approved_study_leave">On Approved Study Leave</option>
                        <option value="on_approved_sabbatical_leave">On Approved Sabbatical Leave</option>
                        <option value="on_approved_maternity_leave">On Approved Maternity Leave</option>
                    </select>
                </div>
            </div>

            <!-- Responsive Table -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr class="align-middle">
                            <th>Evaluation Period</th>
                            <th>1st Semester Rating</th>
                            <th>2nd Semester Rating</th>
                            <th>Link to Evidence</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $evaluationPeriods = ["AY 2019-2020", "AY 2020-2021", "AY 2021-2022", "AY 2022-2023"];
                            foreach ($evaluationPeriods as $period): 
                        ?>
                            <tr class="align-middle">
                                <td><?php echo $period; ?></td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0.00" value="" step="0.01" min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0.00" value="" step="0.01" min="0">
                                </td>
                                <td>
                                    <a href="#" target="_blank">Link to Evidence</a>
                                </td>
                                <td>
                                    <button class="btn btn-link text-decoration-none" data-bs-toggle="modal" data-bs-target="#remarksModal" 
                                            data-remarks1="Excellent performance in 1st semester of <?php echo $period; ?>."
                                            data-remarks2="Good progress in 2nd semester of <?php echo $period; ?>.">
                                        View Remarks
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            

            <!-- Overall Scores -->
            <div class="mt-4">
                <div class="row g-3 justify-content-end">
                    <div class="col-md-4">
                        <label for="student-overall-score" class="form-label">Overall Average Rating:</label>
                        <input type="number" class="form-control" id="student-overall-score" value="" disabled>
                    </div>
                    <div class="col-md-4">
                        <label for="faculty-overall-score" class="form-label">Faculty Score:</label>
                        <input type="number" class="form-control" id="faculty-overall-score" value="" disabled>
                    </div>
                </div>
            </div>
        </div>

        <!-- Supervisor's Evaluation Section -->
        <div class="col-12 mt-5">
            <h5 class="mb-3 pb-2 border-bottom border-2 border-success">1.2 Supervisor's Evaluation (40%)</h5>
            
            <!-- Divisor Selection -->
            <div class="row g-3 align-items-center mb-3">
                <div class="col-md-6">
                    <label for="supervisor-divisor" class="form-label">Number of Semesters to Deduct from Divisor (if applicable):</label>
                    <select class="form-select" id="supervisor-divisor">
                        <?php for ($i = 0; $i <= 8; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="supervisor-reason" class="form-label">Reason for Reducing the Divisor:</label>
                    <select class="form-select" id="supervisor-reason">
                        <option value="">Select Option</option>
                        <option value="not_applicable">Not Applicable</option>
                        <option value="on_approved_study_leave">On Approved Study Leave</option>
                        <option value="on_approved_sabbatical_leave">On Approved Sabbatical Leave</option>
                        <option value="on_approved_maternity_leave">On Approved Maternity Leave</option>
                    </select>
                </div>
            </div>

            <!-- Responsive Table -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr class="align-middle">
                            <th>Evaluation Period</th>
                            <th>1st Semester Rating</th>
                            <th>2nd Semester Rating</th>
                            <th>Link to Evidence</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($evaluationPeriods as $period): ?>
                            <tr class="align-middle">
                                <td><?php echo $period; ?></td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0.00" value="" step="0.01" min="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control" placeholder="0.00" value="" step="0.01" min="0">
                                </td>
                                <td>
                                    <a href="#" target="_blank">Link to Evidence</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Overall Scores -->
            <div class="mt-4">
                <div class="row g-3 justify-content-end">
                    <div class="col-md-4">
                        <label for="supervisor-overall-score" class="form-label">Overall Average Rating:</label>
                        <input type="number" class="form-control" id="supervisor-overall-score" value="0.00" min="0" disabled>
                    </div>
                    <div class="col-md-4">
                        <label for="supervisor-faculty-overall-score" class="form-label">Faculty Score:</label>
                        <input type="number" class="form-control" id="supervisor-faculty-overall-score" value="0.00" min="0" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Save Button -->
    <div class="d-flex justify-content-end mt-4">
        <button type="button" class="btn btn-success" id="save-criterion-a">Save Criterion A</button>
    </div>
</div>



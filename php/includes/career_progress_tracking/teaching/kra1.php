<div class="card mt-4">
    <div class="card-header d-flex bg-success justify-content-between align-items-center text-white">
        <h5 class="mb-0">Summary of KRA I</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Summary Table for KRA I -->
            <div class="col-md-6">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="align-middle">
                                <th>Criterion</th>
                                <th>Average Score</th>
                                <th>Total Points</th>
                                <th>Overall Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="kra-summary-body">
                            <!-- Dynamic Rows Will Be Injected Here -->
                            <tr class="align-middle">
                                <td>Teaching Effectiveness</td>
                                <td>85%</td>
                                <td>60 / 60</td>
                                <td>Excellent performance in Teaching Effectiveness.</td>
                            </tr>
                            <tr>
                                <td>Curriculum & Material Development</td>
                                <td>70%</td>
                                <td>21 / 30</td>
                                <td>Good development and contribution to instructional materials.</td>
                            </tr>
                            <tr>
                                <td>Thesis & Mentorship Services</td>
                                <td>90%</td>
                                <td>9 / 10</td>
                                <td>Outstanding performance in mentorship and advisory roles.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4 mb-2 justify-content-end">
                    <label for="student-overall-score" class="form-label"><strong>Grand Total Points for KRA II:</strong></label>
                    <input type="number" class="form-control" value="90" readonly>
                </div>
            </div>
            <!-- Placeholder for Graphs -->
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                <!-- <h5 class="text-center mb-4">Performance Visualization</h5> -->
                <div class="d-flex justify-content-center" style="width: 100%; max-width: 400px;">
                    <!-- Doughnut Chart for Overall Performance -->
                    <canvas id="kraDoughnutChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
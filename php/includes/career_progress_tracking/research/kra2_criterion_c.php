<!-- careerpath/php/includes/career_progress_tracking/research/criterion_c.php -->
<div class="tab-pane fade" id="criterion-c" role="tabpanel" aria-labelledby="tab-criterion-c">
    <h4 class="mb-4 pb-2 border-bottom border-3 border-success">
        <strong>CRITERION C: Creative Works (Max = 100 Points)</strong>
    </h4>
    <p class="card-text">
        This section evaluates the faculty's contributions to creative works.
    </p>
    <form id="criterion-c-form">
        <div class="row">
            <!-- Hidden input for request_id -->
            <input type="hidden" id="request_id_c" name="request_id_c" value="" readonly>

            <!-- Sub-criterion C.1: New Creative Performing Artwork -->
            <div class="sub-criterion">
                <h5 class="mb-4 pb-2 border-bottom border-2 border-success">
                    1. FOR EVERY CREATIVE WORK CREATED, PERFORMED, PRESENTED, EXHIBITED, AND PUBLISHED
                </h5>
                <h6 class="mb-4">
                    <strong>1.1 NEW CREATIVE PERFORMING ARTWORK (e.g., MUSIC, DANCE, AND THEATRE)</strong>
                </h6>
                <!-- Responsive Table -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="performing-artwork-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title of Creative Performing Art</th>
                                <th scope="col">Type of Performing Art</th>
                                <th scope="col">Classification</th>
                                <th scope="col">Date Copyrighted/ (mm/dd/yyyy)</th>
                                <th scope="col">Venue of Performance</th>
                                <th scope="col">Organizer</th>
                                <th scope="col">Faculty Points</th>
                                <th scope="col">Evidence</th>
                                <th scope="col">Remarks</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($i = 1; $i <= 3; $i++) : ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><input type="text" class="form-control" name="kra2_c_performing_artwork[<?php echo $i; ?>][title]"></td>
                                    <td>
                                        <select class="form-select" name="kra2_c_performing_artwork[<?php echo $i; ?>][type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Music">Music</option>
                                            <option value="Dance">Dance</option>
                                            <option value="Theatre">Theatre</option>
                                            <!-- Add more options if needed -->
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-select" name="kra2_c_performing_artwork[<?php echo $i; ?>][classification]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Regional">Regional</option>
                                            <option value="National">National</option>
                                            <option value="International">International</option>
                                            <!-- Add more options if needed -->
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="kra2_c_performing_artwork[<?php echo $i; ?>][copyright_date]"></td>
                                    <td><input type="text" class="form-control" name="kra2_c_performing_artwork[<?php echo $i; ?>][venue]"></td>
                                    <td><input type="text" class="form-control" name="kra2_c_performing_artwork[<?php echo $i; ?>][organizer]"></td>
                                    <td><input type="text" class="form-control" name="kra2_c_performing_artwork[<?php echo $i; ?>][faculty_points]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="performing_artwork_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_c_performing_artwork[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button -->
                <button type="button" class="btn btn-success mt-3 add-performing-artwork-row" data-table-id="performing-artwork-table">Add Row</button>
                <!-- Overall Score -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_c_performing_artwork_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_c_performing_artwork_total" name="kra2_c_performing_artwork_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion C.2: Exhibition -->
            <div class="sub-criterion mt-5">
                <h6 class="mb-4">
                    <strong>1.2 EXHIBITION (e.g., VISUAL ART, ARCHITECTURE, FILM, AND MULTIMEDIA)</strong>
                </h6>
                <!-- Responsive Table -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="exhibition-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title of Creative Work</th>
                                <th scope="col">Type of Creative Work</th>
                                <th scope="col">Classification</th>
                                <th scope="col">Exhibition Date</th>
                                <th scope="col">Venue of Exhibit</th>
                                <th scope="col">Organizer</th>
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
                                    <td><input type="text" class="form-control" name="kra2_c_exhibition[<?php echo $i; ?>][title]"></td>
                                    <td>
                                        <select class="form-select" name="kra2_c_exhibition[<?php echo $i; ?>][type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Visual Art">Visual Art</option>
                                            <option value="Architecture">Architecture</option>
                                            <option value="Film">Film</option>
                                            <option value="Multimedia">Multimedia</option>
                                            <!-- Add more options if needed -->
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-select" name="kra2_c_exhibition[<?php echo $i; ?>][classification]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Regional">Regional</option>
                                            <option value="National">National</option>
                                            <option value="International">International</option>
                                            <!-- Add more options if needed -->
                                        </select>
                                    </td>
                                    <td><input type="date" class="form-control" name="kra2_c_exhibition[<?php echo $i; ?>][exhibition_date]"></td>
                                    <td><input type="text" class="form-control" name="kra2_c_exhibition[<?php echo $i; ?>][venue]"></td>
                                    <td><input type="text" class="form-control" name="kra2_c_exhibition[<?php echo $i; ?>][organizer]"></td>
                                    <td><input type="text" class="form-control" name="kra2_c_exhibition[<?php echo $i; ?>][faculty_score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="exhibition_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_c_exhibition[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button -->
                <button type="button" class="btn btn-success mt-3 add-exhibition-row" data-table-id="exhibition-table">Add Row</button>
                <!-- Overall Score -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_c_exhibition_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_c_exhibition_total" name="kra2_c_exhibition_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion C.3: Juried or Peer-Reviewed Designs -->
            <div class="sub-criterion mt-5">
                <h6 class="mb-4">
                    <strong>1.3 JURIED OR PEER-REVIEWED DESIGNS (e.g., ARCHITECTURE, ENGINEERING, INDUSTRIAL DESIGN)</strong>
                </h6>
                <!-- Responsive Table -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="juried-designs-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title of Design</th>
                                <th scope="col">Classification</th>
                                <th scope="col">Reviewer</th>
                                <th scope="col">Activity/Exhibition Date</th>
                                <th scope="col">Venue of Activity/Exhibit</th>
                                <th scope="col">Organizer</th>
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
                                    <td><input type="text" class="form-control" name="kra2_c_juried_designs[<?php echo $i; ?>][title]"></td>
                                    <td>
                                        <select class="form-select" name="kra2_c_juried_designs[<?php echo $i; ?>][classification]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Regional">Regional</option>
                                            <option value="National">National</option>
                                            <option value="International">International</option>
                                            <!-- Add more options if needed -->
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="kra2_c_juried_designs[<?php echo $i; ?>][reviewer]"></td>
                                    <td><input type="date" class="form-control" name="kra2_c_juried_designs[<?php echo $i; ?>][activity_date]"></td>
                                    <td><input type="text" class="form-control" name="kra2_c_juried_designs[<?php echo $i; ?>][venue]"></td>
                                    <td><input type="text" class="form-control" name="kra2_c_juried_designs[<?php echo $i; ?>][organizer]"></td>
                                    <td><input type="text" class="form-control" name="kra2_c_juried_designs[<?php echo $i; ?>][faculty_score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="juried_designs_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_c_juried_designs[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button -->
                <button type="button" class="btn btn-success mt-3 add-juried-designs-row" data-table-id="juried-designs-table">Add Row</button>
                <!-- Overall Score -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_c_juried_designs_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_c_juried_designs_total" name="kra2_c_juried_designs_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-criterion C.4: Literary Publications -->
            <div class="sub-criterion mt-5">
                <h6 class="mb-4">
                    <strong>1.4 LITERARY PUBLICATIONS (e.g., NOVEL, SHORT STORY, ESSAY, AND POETRY)</strong>
                </h6>
                <!-- Responsive Table -->
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" id="literary-publications-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Title of Literary Publication</th>
                                <th scope="col">Type of Literary</th>
                                <th scope="col">Reviewer</th>
                                <th scope="col">Name of Publication</th>
                                <th scope="col">Name of Publisher/Press</th>
                                <th scope="col">Date Published</th>
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
                                    <td><input type="text" class="form-control" name="kra2_c_literary_publications[<?php echo $i; ?>][title]"></td>
                                    <td>
                                        <select class="form-select" name="kra2_c_literary_publications[<?php echo $i; ?>][type]">
                                            <option value="">SELECT OPTION</option>
                                            <option value="Novel">Novel</option>
                                            <option value="Short Story">Short Story</option>
                                            <option value="Essay">Essay</option>
                                            <option value="Poetry">Poetry</option>
                                            <!-- Add more options if needed -->
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="kra2_c_literary_publications[<?php echo $i; ?>][reviewer]"></td>
                                    <td><input type="text" class="form-control" name="kra2_c_literary_publications[<?php echo $i; ?>][publication_name]"></td>
                                    <td><input type="text" class="form-control" name="kra2_c_literary_publications[<?php echo $i; ?>][publisher_name]"></td>
                                    <td><input type="date" class="form-control" name="kra2_c_literary_publications[<?php echo $i; ?>][date_published]"></td>
                                    <td><input type="text" class="form-control" name="kra2_c_literary_publications[<?php echo $i; ?>][faculty_score]" readonly></td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm upload-evidence-btn" data-subcriterion-id="literary_publications_<?php echo $i; ?>">Upload Evidence</button>
                                        <input type="hidden" name="kra2_c_literary_publications[<?php echo $i; ?>][evidence_file]" value="">
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
                <!-- Add Row Button -->
                <button type="button" class="btn btn-success mt-3 add-literary-publications-row" data-table-id="literary-publications-table">Add Row</button>
                <!-- Overall Score -->
                <div class="mt-4">
                    <div class="row g-3 justify-content-end">
                        <div class="col-md-4">
                            <label for="kra2_c_literary_publications_total" class="form-label"><strong>Total Score:</strong></label>
                            <input type="text" class="form-control" id="kra2_c_literary_publications_total" name="kra2_c_literary_publications_total" readonly>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Save Button -->
        <div class="d-flex justify-content-end mt-5 mb-5">
            <button type="button" class="btn btn-success" id="save-criterion-c">Save Criterion C</button>
        </div>
    </form>
</div>
// Assuming you're within a DOMContentLoaded event listener
    document.addEventListener('DOMContentLoaded', () => {
        
        // Define enableFields function specific to Criterion A
        function enableFields() {
            // Enable all input and select fields within Criterion A
            document.querySelectorAll('#criterion-a input, #criterion-a select').forEach(field => {
                field.disabled = false;
            });
        }
        
        // Calculate Overall Scores for Criterion A
        const calculateOverallScores = () => {
            // Student Evaluation Calculations
            let studentTotalRating = 0;
            let studentRatingCount = 0;

            const studentReason = document.getElementById('student-reason').value;
            const studentDeductSemesters = parseInt(document.getElementById('student-divisor').value) || 0;
            const studentTotalSemesters = 8 - studentDeductSemesters;

            document.querySelectorAll('#student-evaluation-table tbody tr').forEach(row => {
                const rating1 = parseFloat(row.querySelector('input[name="student_rating_1[]"]').value) || 0;
                const rating2 = parseFloat(row.querySelector('input[name="student_rating_2[]"]').value) || 0;

                studentTotalRating += rating1 + rating2;
                studentRatingCount += 2;

                // Set overall average in hidden input
                const overallAverageInput = row.querySelector('input[name="student_overall_average[]"]');
                if (overallAverageInput) {
                    let overallAverage;
                    if (studentReason === "Not Applicable" || studentReason === "") {
                        overallAverage = studentRatingCount ? (studentTotalRating / studentRatingCount) : 0;
                    } else {
                        overallAverage = studentTotalSemesters ? (studentTotalRating / studentTotalSemesters) : 0;
                    }
                    overallAverageInput.value = overallAverage.toFixed(2);
                }
            });

            const studentOverallAverageRating = (studentReason === "Not Applicable" || studentReason === "") ?
                (studentTotalRating / studentRatingCount) :
                (studentTotalRating / studentTotalSemesters);

            const studentFacultyRating = (studentOverallAverageRating * 0.36).toFixed(2);

            document.getElementById('student-overall-score').value = studentOverallAverageRating.toFixed(2);
            document.getElementById('faculty-overall-score').value = studentFacultyRating;


            // Supervisor Evaluation Calculations
            let supervisorTotalRating = 0;
            let supervisorRatingCount = 0;

            const supervisorReason = document.getElementById('supervisor-reason').value;
            const supervisorDeductSemesters = parseInt(document.getElementById('supervisor-divisor').value) || 0;
            const supervisorTotalSemesters = 8 - supervisorDeductSemesters;

            document.querySelectorAll('#supervisor-evaluation-table tbody tr').forEach(row => {
                const rating1 = parseFloat(row.querySelector('input[name="supervisor_rating_1[]"]').value) || 0;
                const rating2 = parseFloat(row.querySelector('input[name="supervisor_rating_2[]"]').value) || 0;

                supervisorTotalRating += rating1 + rating2;
                supervisorRatingCount += 2;

                // Set overall average in hidden input
                const overallAverageInput = row.querySelector('input[name="supervisor_overall_average[]"]');
                if (overallAverageInput) {
                    let overallAverage;
                    if (supervisorReason === "Not Applicable" || supervisorReason === "") {
                        overallAverage = supervisorRatingCount ? (supervisorTotalRating / supervisorRatingCount) : 0;
                    } else {
                        overallAverage = supervisorTotalSemesters ? (supervisorTotalRating / supervisorTotalSemesters) : 0;
                    }
                    overallAverageInput.value = overallAverage.toFixed(2);
                }
            });

            const supervisorOverallAverageRating = (supervisorReason === "Not Applicable" || supervisorReason === "") ?
                (supervisorTotalRating / supervisorRatingCount) :
                (supervisorTotalRating / supervisorTotalSemesters);

            const supervisorFacultyRating = (supervisorOverallAverageRating * 0.24).toFixed(2);

            document.getElementById('supervisor-overall-score').value = supervisorOverallAverageRating.toFixed(2);
            document.getElementById('supervisor-faculty-overall-score').value = supervisorFacultyRating;
        };

        // Save Criterion A via AJAX
        const saveCriterionA = document.getElementById('save-criterion-a');
        if (saveCriterionA) {
            saveCriterionA.addEventListener('click', () => {
                // Check if an evaluation is selected
                const requestId = document.getElementById('hidden-request-id').value;
                if (!requestId) {
                    // Show error modal
                    document.getElementById('saveErrorModalLabel').textContent = 'Save Failed';
                    document.querySelector('#saveErrorModal .modal-body').textContent = 'Please select an evaluation before saving.';
                    new bootstrap.Modal(document.getElementById('saveErrorModal')).show();
                    return;
                }

                // Manual Validation of Required Fields within Criterion A
                let isValid = true;

                // Collect all input fields and selects within Criterion A
                const criterionAFields = document.querySelectorAll('#criterion-a input, #criterion-a select');
                criterionAFields.forEach(field => {
                    const value = field.value.trim();

                    // Basic non-empty validation for required fields
                    if (field.hasAttribute('required') && !value) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }

                    // Additional validation for URL fields
                    if (field.type === 'url' && field.hasAttribute('required')) {
                        const urlPattern = /^(https?:\/\/).+/;
                        if (!urlPattern.test(value)) {
                            field.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    }
                });

                if (isValid) {
                    // Prepare data for saving
                    const criterionAData = {};
    
                    // Collect all field values
                    criterionAFields.forEach(field => {
                        const name = field.name;
                        const value = field.value.trim();
    
                        if (name.endsWith('[]')) {
                            const key = name.slice(0, -2);
                            if (!Array.isArray(criterionAData[key])) {
                                criterionAData[key] = [];
                            }
                            criterionAData[key].push(value);
                        } else {
                            criterionAData[name] = value;
                        }
                    });
    
                    // Add calculated fields for student evaluations
                    criterionAData['student_overall_average'] = [];
                    criterionAData['student_faculty_rating'] = [];
                    document.querySelectorAll('#student-evaluation-table tbody tr').forEach(row => {
                        const overallAverage = row.querySelector('input[name="student_overall_average[]"]').value;
                        const facultyRating = row.querySelector('input[name="student_faculty_rating[]"]').value;
                        criterionAData['student_overall_average'].push(overallAverage);
                        criterionAData['student_faculty_rating'].push(facultyRating);
                    });
    
                    // Add calculated fields for supervisor evaluations
                    criterionAData['supervisor_overall_average'] = [];
                    criterionAData['supervisor_faculty_overall_score'] = [];
                    document.querySelectorAll('#supervisor-evaluation-table tbody tr').forEach(row => {
                        const overallAverage = row.querySelector('input[name="supervisor_overall_average[]"]').value;
                        const facultyRating = row.querySelector('input[name="supervisor_faculty_overall_score[]"]').value;
                        criterionAData['supervisor_overall_average'].push(overallAverage);
                        criterionAData['supervisor_faculty_overall_score'].push(facultyRating);
                    });
    
                    // Add request_id
                    criterionAData['request_id'] = requestId;
    
                    // Send data to the backend via AJAX
                    fetch('save_criterion_a.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(criterionAData),
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success modal
                                new bootstrap.Modal(document.getElementById('saveConfirmationModal')).show();
                            } else {
                                // Show error modal
                                document.getElementById('saveErrorModalLabel').textContent = 'Save Failed';
                                document.querySelector('#saveErrorModal .modal-body').textContent = data.error || 'An unexpected error occurred.';
                                new bootstrap.Modal(document.getElementById('saveErrorModal')).show();
                            }
                        })
                        .catch(err => {
                            console.error('Error saving data:', err);
                            // Show error modal
                            document.getElementById('saveErrorModalLabel').textContent = 'Save Failed';
                            document.querySelector('#saveErrorModal .modal-body').textContent = 'A network error occurred. Please try again.';
                            new bootstrap.Modal(document.getElementById('saveErrorModal')).show();
                        });
                } else {
                    // Show validation error modal
                    document.getElementById('saveErrorModalLabel').textContent = 'Save Failed';
                    document.querySelector('#saveErrorModal .modal-body').textContent = 'Please complete all required fields before saving.';
                    new bootstrap.Modal(document.getElementById('saveErrorModal')).show();
                }
            });
        }
    });
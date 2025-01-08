// kra1_teaching.js
$(document).ready(function() {
    // Function to fetch KRA1 evaluations
    function fetchKRA1Evaluations(page = 1) {
        console.log(`Fetching KRA1 evaluations for page: ${page}`);
        const searchInput = $('#searchInput');
        const departmentFilter = $('#departmentFilter');
        const facultyRankFilter = $('#facultyRankFilter');

        const search = searchInput.val();
        const department = departmentFilter.val();
        const faculty_rank = facultyRankFilter.val();

        // Create a plain JavaScript object for the parameters
        const params = {
            search: search,
            department: department,
            faculty_rank: faculty_rank,
            page: page
        };

        // AJAX request with simplified data
        $.ajax({
            url: 'kra1_teaching/get_kra1_evaluations.php', 
            type: 'GET',
            data: params, // Pass the object directly to jQuery
            dataType: 'json',
            success: function(data) {
                console.log("Data fetched successfully:", data);
                if (data.error) {
                    console.error('Backend Error:', data.error);
                    alert(`Error: ${data.error}`);
                } else {
                    // Update table and pagination
                    $('#kra1EvaluationsTable tbody').html(data.table_data);
                    $('#kra1Pagination').html(data.pagination);
                    attachViewKRA1Buttons();
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                alert('Failed to fetch KRA1 evaluations.');
            }
        });
    }

    // Function to attach event listeners to "View KRA1" buttons
    function attachViewKRA1Buttons() {
        $('.view-kra1-btn').on('click', function() {
            const facultyId = $(this).data('faculty-id');
            console.log(`View KRA1 clicked for Faculty ID: ${facultyId}`);

            // AJAX request with corrected URL
            $.ajax({
                url: 'get_kra1_details.php', // Correct relative path
                type: 'GET',
                data: { faculty_id: facultyId },
                dataType: 'json',
                success: function(data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        $('#kra1DetailsContent').html(data.html);
                        $('#kra1DetailsModal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('Failed to fetch KRA1 details.');
                }
            });
        });
    }

    // Attach event listeners to filters
    $('#searchInput, #departmentFilter, #facultyRankFilter').on('input change', function() {
        fetchKRA1Evaluations(1);
    });

    // Handle pagination clicks
    $(document).on('click', '.kra1-pagination a', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page) {
            fetchKRA1Evaluations(page);
        }
    });

    // Initial fetch
    fetchKRA1Evaluations();
});
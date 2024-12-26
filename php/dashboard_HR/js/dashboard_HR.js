
// START: For Faculty
function updateFacultyInfo(hasNewMembers, newMembersCount, totalMembersCount) {
    const facultyStatusText = document.getElementById('facultyStatusText');
    const facultyCountText = document.getElementById('facultyCountText');

    if (hasNewMembers) {
        facultyStatusText.textContent = 'New Faculty Members';
        facultyCountText.textContent = `${newMembersCount} New Members This Week`;
    } else {
        facultyStatusText.textContent = 'Total Faculty Members';
        facultyCountText.textContent = `${totalMembersCount} Faculty Members`;
    }
}

function toggleDetails(targetId) {
    // Close all other open collapses except the target
    document.querySelectorAll('.collapse').forEach(function(collapse) {
        if (collapse.id !== targetId.substring(1) && collapse.classList.contains('show')) {
            bootstrap.Collapse.getOrCreateInstance(collapse).hide();
        }
    });
    // Toggle the targeted collapse
    var targetCollapse = document.querySelector(targetId);
    bootstrap.Collapse.getOrCreateInstance(targetCollapse).toggle();
}
// END: For Faculty

// START: For documents
function confirmAction(message) {
    if (confirm(message)) {
        // Perform the action here, like making an API call or redirecting
        console.log('Action confirmed: ' + message);
    } else {
        console.log('Action canceled');
    }
}

function toggleDetails(targetId) {
    // Close all other open collapses except the target
    document.querySelectorAll('.collapse').forEach(function(collapse) {
        if (collapse.id !== targetId.substring(1) && collapse.classList.contains('show')) {
            bootstrap.Collapse.getOrCreateInstance(collapse).hide();
        }
    });
    // Toggle the targeted collapse
    var targetCollapse = document.querySelector(targetId);
    bootstrap.Collapse.getOrCreateInstance(targetCollapse).toggle();
}
// END: For documents

// For notifications
function toggleDetails(targetId) {
    // Close all other open collapses except the target
    document.querySelectorAll('.collapse').forEach(function(collapse) {
        if (collapse.id !== targetId.substring(1) && collapse.classList.contains('show')) {
            bootstrap.Collapse.getOrCreateInstance(collapse).hide();
        }
    });
    // Toggle the targeted collapse
    var targetCollapse = document.querySelector(targetId);
    bootstrap.Collapse.getOrCreateInstance(targetCollapse).toggle();
}


// For recent activities 
document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('#recentActivitiesList .list-group-item');
    const viewMoreButton = document.getElementById('viewMoreButton');
    const viewLessButton = document.getElementById('viewLessButton');
    let defaultItemsPerPage = 5;
    let expandedItemsPerPage = 10;
    let itemsPerPage = defaultItemsPerPage;
    let currentPage = 1;
    let totalPages = Math.ceil(items.length / itemsPerPage);

    function renderPage(page) {
        items.forEach((item, index) => {
            item.style.display = (index >= (page - 1) * itemsPerPage && index < page * itemsPerPage) ? 'block' : 'none';
        });
    }

    function updatePagination() {
        const pagination = document.querySelector('.pagination');
        pagination.innerHTML = '';

        // Previous button
        const prevPageItem = document.createElement('li');
        prevPageItem.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevPageItem.innerHTML = `<a class="page-link" href="#">&lt;</a>`;
        pagination.appendChild(prevPageItem);

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            const pageItem = document.createElement('li');
            pageItem.className = `page-item ${currentPage === i ? 'active' : ''}`;
            pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            pagination.appendChild(pageItem);
        }

        // Next button
        const nextPageItem = document.createElement('li');
        nextPageItem.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        nextPageItem.innerHTML = `<a class="page-link" href="#">&gt;</a>`;
        pagination.appendChild(nextPageItem);
    }

    document.querySelector('.pagination').addEventListener('click', function (e) {
        if (e.target.tagName === 'A') {
            e.preventDefault();
            const selectedPage = e.target.textContent;
            if (selectedPage === '<' && currentPage > 1) {
                currentPage--;
            } else if (selectedPage === '>' && currentPage < totalPages) {
                currentPage++;
            } else if (!isNaN(selectedPage)) {
                currentPage = parseInt(selectedPage);
            }
            renderPage(currentPage);
            updatePagination();
        }
    });

    // "View More" button
    viewMoreButton.addEventListener('click', function (e) {
        e.preventDefault();
        itemsPerPage = expandedItemsPerPage;
        currentPage = 1; // Reset to the first page
        totalPages = Math.ceil(items.length / itemsPerPage);
        renderPage(currentPage);
        updatePagination();
        viewMoreButton.style.display = 'none'; // Hide "View More" button
        viewLessButton.style.display = 'inline'; // Show "View Less" button
    });

    // "View Less" button
    viewLessButton.addEventListener('click', function (e) {
        e.preventDefault();
        itemsPerPage = defaultItemsPerPage;
        currentPage = 1; // Reset to the first page
        totalPages = Math.ceil(items.length / itemsPerPage);
        renderPage(currentPage);
        updatePagination();
        viewLessButton.style.display = 'none'; // Hide "View Less" button
        viewMoreButton.style.display = 'inline'; // Show "View More" button
    });

    // Initial render
    renderPage(currentPage);
    updatePagination();
});
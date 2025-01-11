document.addEventListener('DOMContentLoaded', function () {
    // JavaScript for tabs styling
const tabs = document.querySelectorAll('#kra-tabs .nav-link');
if (tabs.length > 0) {
    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            tabs.forEach(t => t.classList.remove('bg-success', 'text-white'));
            this.classList.add('bg-success', 'text-white');
        });
    });
}
});


/* view user card */
document.querySelectorAll('.view-user-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const card = btn.closest('.user-card');

        document.querySelectorAll('.user-card.user-details-active')
                .forEach(c => c !== card && c.classList.remove('user-details-active'));

        card.classList.toggle('user-details-active');
    });
});



/* tab n filter */
document.addEventListener('DOMContentLoaded', () => {

    const menuItems = document.querySelectorAll('.user-activity-menu ul li');
    const tabs = document.querySelectorAll('.user-activity-tabs');

    //reset all
    function resetTabs() {
        tabs.forEach(t => t.style.display = 'none');
        menuItems.forEach(m => m.classList.remove('active'));
    }

    //chech which filter button is applied
    function getActiveStatus(tab) {
        const btn = tab.querySelector('.user-activity-filter button.active');
        return btn ? btn.textContent.trim().toLowerCase() : 'all';
    }

    function applyFilters(tab) {
        const statusFilter = getActiveStatus(tab);

        const rows = tab.querySelectorAll('tbody tr');
        let found = false;

        rows.forEach(row => {
            const status = row.cells[row.cells.length - 1].textContent.trim().toLowerCase();

            const statusMatch = (statusFilter === 'all' || status === statusFilter);

            if (statusMatch) {
                row.style.display = '';
                found = true;
            } else {
                row.style.display = 'none';
            }
        });

        if (!found) console.log('No matching rows found');
    }

    //menu (comments / rewards)
    menuItems.forEach(item => {
        item.addEventListener('click', () => {
            const target = item.dataset.target;
            if (!target) return;

            resetTabs();
            item.classList.add('active');

            const tab = document.querySelector(`.${target}`);
            tab.style.display = 'block';

            const buttons = tab.querySelectorAll('.user-activity-filter button');
            buttons.forEach(b => b.classList.remove('active'));
            buttons[0]?.classList.add('active');

            tab.querySelectorAll('tbody tr').forEach(r => r.style.display = '');
        });
    });


    //button filter active
    document.querySelectorAll('.user-activity-tabs').forEach(tab => {
        const buttons = tab.querySelectorAll('.user-activity-filter button');

        buttons.forEach(btn => {
            btn.addEventListener('click', () => {
                buttons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                applyFilters(tab); 
            });
        });
    });

});
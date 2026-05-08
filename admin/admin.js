
/* =====================================================
   modal 
===================================================== */

function openModal(modal) {
    clearErrors();
    document.body.classList.add('modal-open');
    document.body.style.overflow = 'hidden';
    modal.classList.add('open');
}


function closeModal(modal) {
    const form = modal.querySelector('form');
    if (form) {
        resetFileInput(form);
        setViewMode(form);
    }
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    modal.classList.remove('open');
}


document.addEventListener('mousedown', function (e) {
    const modal = document.querySelector('.modal.open');
    if (!modal) return;

    if (!modal.contains(e.target)) {
        closeModal(modal);
    }
});



/* =====================================================
   fetch
===================================================== */

function openModalWithData({ triggerSelector, fetchUrl, mapData, modalSelector }) {
    document.querySelectorAll(triggerSelector).forEach(button => {
        button.addEventListener('click', () => {

            const key = button.dataset.key;
            const modal = document.querySelector(modalSelector);
            if (!modal) return;

            const form = modal.querySelector('form');

            fetch(`${fetchUrl}${key}`)
                .then(res => res.json())
                .then(data => {

                    if (typeof mapData === 'function') {
                        mapData(data, modal, form);
                    }

                    if (form) {
                        resetFileInput(form);
                        setViewMode(form);
                    }

                    openModal(modal); 
                })
                .catch(err => console.error('Fetch failed:', err));
        });
    });
}





/* =====================================================
   form view mode
===================================================== */
function setViewMode(form) {
    if (!form) return;
    if (form.dataset.mode !== 'editable') return;

    form.querySelectorAll('[data-editable]').forEach(el => {
        if (el.tagName === 'SELECT' || el.type === 'checkbox' || el.type === 'file') {
            el.disabled = true;
        } else {
            el.setAttribute('readonly', true);
        }
    });

    form.querySelector('.edit-btn').style.display = 'flex';
    form.querySelector('.save-btn').style.display = 'none';
}




/* =====================================================
   form edit mode
===================================================== */
function setEditMode(form) {
     if (!form) return;

    form.querySelectorAll('[data-editable]').forEach(el => {
        if (el.tagName === 'SELECT' || el.type === 'checkbox' || el.type === 'file') {
            el.disabled = false;
        } else {
            el.removeAttribute('readonly');
        }
    });

    form.querySelector('.edit-btn').style.display = 'none';
    form.querySelector('.save-btn').style.display = 'flex';
}



function resetFileInput(form) {
    const fileInput = form.querySelector('input[type="file"]');
    if (fileInput) fileInput.value = '';
}



/* =====================================================
   error
===================================================== */
function showError(id, errorMessage) {
    const element = document.getElementById(id);
    if (!element) return;
    element.textContent = errorMessage;
    element.classList.add("show");
}


function clearErrors() {
    document.querySelectorAll('.error').forEach(element => {
        element.textContent = '';
        element.classList.remove("show");
    });
}




/* =====================================================
   status style 
===================================================== */
document.querySelectorAll('.status').forEach(el => {
  const status = el.querySelector('.status-text').textContent.trim().toUpperCase();
  const icon = el.querySelector('.status-icon');

  if (status === 'ACTIVE') {
    el.classList.add('status-active');
    el.classList.remove('status-inactive');
    icon.className = 'status-icon fa-solid fa-circle-check';
  } else {
    el.classList.add('status-inactive');
    el.classList.remove('status-active');
    icon.className = 'status-icon fa-solid fa-circle-xmark';
  }
});



/* =====================================================
   change status
===================================================== */
document.querySelectorAll('.toggle-status-btn').forEach(btn => {
    btn.addEventListener('click', e => {
        e.preventDefault();

        const action = btn.dataset.action;
        const id = btn.dataset.key;
        if (!action || !id) return;

        fetch('adminAPI.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action, id })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) return alert(data.message || 'Update failed');
            const newStatus = data.newStatus;
            btn.dataset.status = newStatus;

            updateToggleUI(btn, newStatus);
            if (window.location.pathname.includes('adminLocation.php')) {
                window.location.reload();
            }
        })
        .catch(err => console.error(err));
    });
});


function updateToggleUI(btn, newStatus) {
    const isActive = newStatus.toUpperCase() === 'ACTIVE';

    // user card status
    const card = btn.closest('.user-card');
    if (card) {
        const statusDiv = card.querySelector('.status');
        if (statusDiv) {
            const statusLabel = statusDiv.querySelector('.status-text');
            if (statusLabel) statusLabel.textContent = newStatus;

            const icon = statusDiv.querySelector('.status-icon');
            if (icon) icon.className = isActive ? 'status-icon fa-solid fa-circle-check' : 'status-icon fa-solid fa-circle-xmark';

            card.style.borderLeft = isActive ? '4px solid var(--light-green)' : '4px solid var(--error-red)';
            statusDiv.classList.remove('status-active', 'status-inactive');
            statusDiv.classList.add(isActive ? 'status-active' : 'status-inactive');

            btn.innerHTML = isActive ? '<i class="fa-solid fa-user-slash"></i> Block' : '<i class="fa-solid fa-user-check"></i> Unblock';
        }
    }
    btn.classList.remove('user-active', 'user-blocked');
    btn.classList.add(isActive ? 'user-active' : 'user-blocked');


    // location status
    const row = btn.closest('tr');
    if (row) {
        const rowStatusDiv = row.querySelector('.status');
        if (rowStatusDiv) {
            const rowStatusLabel = rowStatusDiv.querySelector('.status-text');
            if (rowStatusLabel) rowStatusLabel.textContent = newStatus;

            const rowIcon = rowStatusDiv.querySelector('.status-icon');
            if (rowIcon) rowIcon.className = isActive ? 'status-icon fa-solid fa-circle-check' : 'status-icon fa-solid fa-circle-xmark';

            rowStatusDiv.classList.remove('status-active', 'status-inactive');
            rowStatusDiv.classList.add(isActive ? 'status-active' : 'status-inactive');

            btn.textContent = isActive ? 'Inactivate' : 'Activate';
        }
    }
}



/* =====================================================
   search js
===================================================== */
document.addEventListener('input', e => {
    if (!e.target.classList.contains('global-search')) return;

    const keyword = e.target.value.toLowerCase().trim();
    const container = document.querySelector(e.target.dataset.target);
    if (!container) return;

    container.querySelectorAll('.searchable-card').forEach(card => {
        let text = "";
        card.querySelectorAll('[data-searchable]').forEach(el => {
            text += el.innerText.toLowerCase() + " ";
        });

        card.style.display = keyword === '' || text.includes(keyword) ? '' : 'none';
    });
});
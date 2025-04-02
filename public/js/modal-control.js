document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('editTaskModal');
    
    if (!modal) return;

    modal.addEventListener('show.bs.modal', function () {
        const bodyChildren = Array.from(document.body.children);
        bodyChildren.forEach(child => {
            if (child !== modal && !child.closest('.modal')) {
                child.setAttribute('aria-hidden', 'true');
            }
        });
    });

    modal.addEventListener('hidden.bs.modal', function () {
        const bodyChildren = Array.from(document.body.children);
        
        bodyChildren.forEach(child => {
            if (child !== modal && !child.closest('.modal')) {
                child.removeAttribute('aria-hidden');
            }
        });
    });
});

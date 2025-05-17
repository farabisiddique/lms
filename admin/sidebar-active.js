document.addEventListener('DOMContentLoaded', function() {
    // Get the current page URL
    const currentPage = window.location.pathname.split('/').pop();
    
    // Get all nav links
    const navLinks = document.querySelectorAll('.nav-link');
    
    // Remove active class from all links
    navLinks.forEach(link => {
        link.classList.remove('active');
    });
    
    // Find and highlight the active link
    navLinks.forEach(link => {
        const linkHref = link.getAttribute('href').split('/').pop();
        if (linkHref === currentPage) {
            link.classList.add('active');
            
            // If it's a submenu item, also open and highlight its parent menu
            const parentNavItem = link.closest('.nav-item.menu-open');
            if (parentNavItem) {
                const parentLink = parentNavItem.querySelector('.nav-link');
                if (parentLink) {
                    parentLink.classList.add('active');
                }
            }
        }
    });
});

// Add CSS styles for active state
const style = document.createElement('style');
style.textContent = `
    .nav-link.active {
        background-color: #007bff !important;
        color: white !important;
    }
    .nav-link.active:hover {
        background-color: #0056b3 !important;
    }
`;
document.head.appendChild(style);
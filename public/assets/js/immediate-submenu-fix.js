/**
 * Immediate Submenu Style Fix
 * This script runs immediately to ensure submenu styling is applied
 */

(function() {
    'use strict';
    
    function applySubmenuStyles() {
        // Add styles immediately
        const submenus = document.querySelectorAll('.dash-submenu');
        submenus.forEach(submenu => {
            submenu.classList.add('enhanced-submenu');
            
            // Style all submenu items
            const items = submenu.querySelectorAll('.dash-item, li');
            items.forEach(item => {
                item.style.position = 'relative';
                item.style.listStyle = 'none';
                
                const link = item.querySelector('a, .dash-link');
                if (link) {
                    // Check if this is the current page
                    if (window.location.pathname === link.getAttribute('href') || 
                        window.location.href === link.href) {
                        item.classList.add('active');
                        
                        // Open parent menu
                        const parentMenu = item.closest('.dash-hasmenu');
                        if (parentMenu) {
                            parentMenu.classList.add('dash-trigger');
                        }
                    }
                }
            });
        });
    }
    
    // Apply styles immediately
    applySubmenuStyles();
    
    // Apply again when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', applySubmenuStyles);
    } else {
        applySubmenuStyles();
    }
    
    // Apply again after a short delay to catch any dynamically loaded content
    setTimeout(applySubmenuStyles, 100);
    setTimeout(applySubmenuStyles, 500);
    
})();

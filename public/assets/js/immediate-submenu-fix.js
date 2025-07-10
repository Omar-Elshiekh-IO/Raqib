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
                const link = item.querySelector('a, .dash-link');
                if (link) {
                    // Check if this is an empty link (no text content or href)
                    const linkText = link.textContent.trim();
                    const linkHrefAttr = link.getAttribute('href');
                    
                    if (!linkText || linkText === '' || !linkHrefAttr || linkHrefAttr === '' || linkHrefAttr === '#') {
                        // Hide empty menu items
                        item.style.display = 'none';
                        return;
                    }
                    
                    item.style.position = 'relative';
                    item.style.listStyle = 'none';
                    
                    // Check if this is the current page
                    const currentPath = window.location.pathname;
                    const linkPath = link.getAttribute('href');
                    const linkHref = link.href;
                    
                    if (currentPath === linkPath || 
                        currentPath === linkHref || 
                        window.location.href === linkHref ||
                        (currentPath === '/account-dashboard' && linkPath && linkPath.includes('account-dashboard'))) {
                        item.classList.add('active');
                        
                        // Open parent menu
                        const parentMenu = item.closest('.dash-hasmenu');
                        if (parentMenu) {
                            parentMenu.classList.add('dash-trigger');
                        }
                    }
                } else {
                    // Hide items without links
                    item.style.display = 'none';
                }
            });
            
            // Hide submenu container if all children are hidden
            const visibleItems = submenu.querySelectorAll('.dash-item:not([style*="display: none"]), li:not([style*="display: none"])');
            if (visibleItems.length === 0) {
                const parentMenuItem = submenu.closest('.dash-item.dash-hasmenu');
                if (parentMenuItem) {
                    parentMenuItem.style.display = 'none';
                }
            }
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

/**
 * Sidebar Auto-Close and Auto-Open Submenu Enhancement
 * Automatically opens submenus on hover and closes them when sidebar collapses
 * NON-INVASIVE: Does not interfere with original menu functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.dash-sidebar.sidebar-hoverable');
    
    if (!sidebar) return;
    
    // Wait for original menu system to fully initialize and load dynamic content
    setTimeout(() => {
        initializeSidebarEnhancements();
    }, 3000); // Increased delay to ensure all dynamic content loads
    
    function initializeSidebarEnhancements() {
        // Prevent duplicate initialization
        if (sidebar.hasAttribute('data-sidebar-enhanced-initialized')) {
            return;
        }
        sidebar.setAttribute('data-sidebar-enhanced-initialized', 'true');
        
        let isHovered = false;
        let collapseTimeout = null;
        let submenuHoverTimeout = null;
        
        console.log('Sidebar enhancements initialized (auto-open/close mode)');
        
        // Function to close all open submenus
        function closeAllSubmenus() {
            const openMenus = sidebar.querySelectorAll('.dash-item.dash-trigger');
            openMenus.forEach(menu => {
                menu.classList.remove('dash-trigger');
                const submenu = menu.querySelector('.dash-submenu');
                if (submenu) {
                    // Use existing slideUp if available, otherwise just hide
                    if (typeof slideUp === 'function') {
                        slideUp(submenu, 200);
                    } else {
                        submenu.style.display = 'none';
                    }
                    
                    // Handle nested submenus
                    const nestedMenus = submenu.querySelectorAll('.dash-item.dash-trigger');
                    nestedMenus.forEach(nested => {
                        nested.classList.remove('dash-trigger');
                        const nestedSubmenu = nested.querySelector('.dash-submenu');
                        if (nestedSubmenu) {
                            if (typeof slideUp === 'function') {
                                slideUp(nestedSubmenu, 200);
                            } else {
                                nestedSubmenu.style.display = 'none';
                            }
                        }
                    });
                }
            });
        }
        
        // Function to open a specific submenu
        function openSubmenu(menuItem) {
            if (!menuItem.classList.contains('dash-hasmenu')) return;
            
            menuItem.classList.add('dash-trigger');
            const submenu = menuItem.querySelector('.dash-submenu');
            if (submenu) {
                // Use existing slideDown if available, otherwise just show
                if (typeof slideDown === 'function') {
                    slideDown(submenu, 200);
                } else {
                    submenu.style.display = 'block';
                }
            }
        }
        
        // Function to close a specific submenu
        function closeSubmenu(menuItem) {
            menuItem.classList.remove('dash-trigger');
            const submenu = menuItem.querySelector('.dash-submenu');
            if (submenu) {
                // Use existing slideUp if available, otherwise just hide
                if (typeof slideUp === 'function') {
                    slideUp(submenu, 200);
                } else {
                    submenu.style.display = 'none';
                }
                
                // Also close nested submenus
                const nestedMenus = submenu.querySelectorAll('.dash-item.dash-trigger');
                nestedMenus.forEach(nested => {
                    closeSubmenu(nested);
                });
            }
        }
        
        // Function to restore submenu states when expanding
        function restoreSubmenuStates() {
            const activeMenus = sidebar.querySelectorAll('.dash-item.active');
            activeMenus.forEach(menu => {
                let parent = menu.closest('.dash-item.dash-hasmenu');
                while (parent) {
                    openSubmenu(parent);
                    // Check for parent menu items
                    parent = parent.parentElement.closest('.dash-item.dash-hasmenu');
                }
            });
        }
        
        // Add hover listeners to menu items with submenus
        const menuItems = sidebar.querySelectorAll('.dash-item.dash-hasmenu');
        menuItems.forEach(menuItem => {
            let hoverTimeout = null;
            
            menuItem.addEventListener('mouseenter', function(e) {
                // Only trigger if sidebar is expanded (hoverable)
                if (!sidebar.matches(':hover')) return;
                
                // Clear any pending timeout
                if (hoverTimeout) {
                    clearTimeout(hoverTimeout);
                    hoverTimeout = null;
                }
                
                // Small delay to prevent accidental opens
                hoverTimeout = setTimeout(() => {
                    if (sidebar.matches(':hover') && menuItem.matches(':hover')) {
                        openSubmenu(menuItem);
                    }
                }, 150);
            });
            
            menuItem.addEventListener('mouseleave', function(e) {
                // Clear hover timeout
                if (hoverTimeout) {
                    clearTimeout(hoverTimeout);
                    hoverTimeout = null;
                }
                
                // Don't close if moving to submenu
                const relatedTarget = e.relatedTarget;
                if (relatedTarget && 
                    (this.contains(relatedTarget) || 
                     relatedTarget.closest('.dash-submenu') === this.querySelector('.dash-submenu'))) {
                    return;
                }
                
                // Small delay before closing to allow navigation
                setTimeout(() => {
                    if (!menuItem.matches(':hover') && 
                        !menuItem.querySelector('.dash-submenu:hover')) {
                        closeSubmenu(menuItem);
                    }
                }, 200);
            });
        });
        
        // Monitor when sidebar enters hover state (expands)
        sidebar.addEventListener('mouseenter', function() {
            isHovered = true;
            
            // Clear any pending collapse timeouts
            if (collapseTimeout) {
                clearTimeout(collapseTimeout);
                collapseTimeout = null;
            }
            if (submenuHoverTimeout) {
                clearTimeout(submenuHoverTimeout);
                submenuHoverTimeout = null;
            }
            
            // Small delay to ensure CSS transitions complete
            setTimeout(() => {
                if (isHovered) {
                    restoreSubmenuStates();
                }
            }, 150);
        });
        
        // Monitor when sidebar leaves hover state (collapses)
        sidebar.addEventListener('mouseleave', function() {
            isHovered = false;
            
            // Add a delay before closing to allow user to navigate
            collapseTimeout = setTimeout(() => {
                if (!isHovered && !sidebar.matches(':hover')) {
                    closeAllSubmenus();
                }
            }, 300);
        });
        
        // Prevent submenus from closing when hovering over them
        const allSubmenus = sidebar.querySelectorAll('.dash-submenu');
        allSubmenus.forEach(submenu => {
            submenu.addEventListener('mouseenter', function() {
                // Clear any pending collapse timeout when hovering over submenus
                if (collapseTimeout) {
                    clearTimeout(collapseTimeout);
                    collapseTimeout = null;
                }
                if (submenuHoverTimeout) {
                    clearTimeout(submenuHoverTimeout);
                    submenuHoverTimeout = null;
                }
            });
            
            submenu.addEventListener('mouseleave', function(e) {
                // Check if we're moving to another submenu or staying within sidebar
                const relatedTarget = e.relatedTarget;
                
                // Don't start timer if moving to nested elements or staying in sidebar
                if (!relatedTarget ||
                    (!this.contains(relatedTarget) &&
                     !relatedTarget.closest('.dash-submenu') &&
                     !relatedTarget.closest('.dash-item.dash-hasmenu') &&
                     !sidebar.contains(relatedTarget))) {
                    
                    // Only start collapse timer if we're truly leaving the sidebar area
                    submenuHoverTimeout = setTimeout(() => {
                        if (!isHovered && !sidebar.matches(':hover')) {
                            closeAllSubmenus();
                        }
                    }, 300);
                }
            });
        });
        
        // Handle window resize to ensure proper behavior
        window.addEventListener('resize', function() {
            if (window.innerWidth <= 1024) {
                // On mobile, remove hover-based auto-close
                isHovered = true;
            }
        });
        
        // Initialize hover state
        if (sidebar.matches(':hover')) {
            isHovered = true;
            restoreSubmenuStates();
        }
        
        console.log('Sidebar auto-open/close ready');
    }
});

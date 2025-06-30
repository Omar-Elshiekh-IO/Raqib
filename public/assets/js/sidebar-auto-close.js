/**
 * Sidebar Auto-Close Submenu Enhancement
 * Automatically closes submenu items when sidebar collapses
 * NON-INVASIVE: Does not interfere with original menu functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.dash-sidebar.sidebar-hoverable');
    
    if (!sidebar) return;
    
    // Wait for original menu system to fully initialize and load dynamic content
    setTimeout(() => {
        initializeNonInvasiveSidebarAutoClose();
    }, 3000); // Increased delay to ensure all dynamic content loads
    
    function initializeNonInvasiveSidebarAutoClose() {
        // Prevent duplicate initialization
        if (sidebar.hasAttribute('data-sidebar-auto-close-initialized')) {
            return;
        }
        sidebar.setAttribute('data-sidebar-auto-close-initialized', 'true');
        
        let isHovered = false;
        let collapseTimeout = null;
        
        console.log('Sidebar auto-close initialized (non-invasive mode)');
        
        // Simple function to close all open submenus - ONLY for auto-close on sidebar collapse
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
        
        // Monitor when sidebar enters hover state (expands)
        sidebar.addEventListener('mouseenter', function() {
            isHovered = true;
            
            // Clear any pending collapse timeout
            if (collapseTimeout) {
                clearTimeout(collapseTimeout);
                collapseTimeout = null;
            }
        });
        
        // Monitor when sidebar leaves hover state (collapses)
        sidebar.addEventListener('mouseleave', function() {
            isHovered = false;
            
            // Only close submenus when sidebar completely collapses
            collapseTimeout = setTimeout(() => {
                if (!isHovered && !sidebar.matches(':hover')) {
                    closeAllSubmenus();
                }
            }, 800); // Generous delay to allow user navigation
        });
        
        // DO NOT add any click event listeners that could interfere with original functionality
        // DO NOT prevent default or stop propagation on any events
        // DO NOT clone or modify original menu elements
        
        // Initialize hover state
        if (sidebar.matches(':hover')) {
            isHovered = true;
        }
        
        console.log('Non-invasive sidebar auto-close ready');
    }
});
        
        // Function to close all open submenus (simple approach)
        function closeAllSubmenus() {
            const openMenus = sidebar.querySelectorAll('.dash-item.dash-trigger');
            openMenus.forEach(menu => {
                menu.classList.remove('dash-trigger');
                const submenu = menu.querySelector('.dash-submenu');
                if (submenu) {
                    submenu.style.display = 'none';
                    // Also handle nested submenus
                    const nestedMenus = submenu.querySelectorAll('.dash-item.dash-trigger');
                    nestedMenus.forEach(nested => {
                        nested.classList.remove('dash-trigger');
                        const nestedSubmenu = nested.querySelector('.dash-submenu');
                        if (nestedSubmenu) {
                            nestedSubmenu.style.display = 'none';
                        }
                    });
                }
            });
        }
        
        // Function to restore submenu states when expanding
        function restoreSubmenuStates() {
            const activeMenus = sidebar.querySelectorAll('.dash-item.active');
            activeMenus.forEach(menu => {
                let parent = menu.closest('.dash-item.dash-hasmenu');
                while (parent) {
                    parent.classList.add('dash-trigger');
                    const submenu = parent.querySelector('.dash-submenu');
                    if (submenu) {
                        submenu.style.display = 'block';
                    }
                    // Check for parent menu items
                    parent = parent.parentElement.closest('.dash-item.dash-hasmenu');
                }
            });
        }
        
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
                if (!isHovered) {
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
    }
});

/**
 * Sidebar Auto-Close and Auto-Open Submenu Enhancement
 * Automatically opens submenus on hover and closes them when sidebar collapses
 * NON-INVASIVE: Does not interfere with original menu functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.dash-sidebar.sidebar-hoverable');
    
    if (!sidebar) return;
    
    // Inject custom submenu styles
    injectCustomSubmenuStyles();
    
    // Wait for original menu system to fully initialize and load dynamic content
    setTimeout(() => {
        initializeSidebarEnhancements();
    }, 3000); // Increased delay to ensure all dynamic content loads
    
    function injectCustomSubmenuStyles() {
        // Check if custom styles are already injected
        if (document.getElementById('custom-submenu-styles')) {
            return;
        }
        
        const customStyles = `
            <style id="custom-submenu-styles">
                /* Enhanced Submenu UI/UX - Clean with Better Spacing */
                .dash-sidebar .dash-submenu .dash-item:hover > .dash-link {
                    background: rgba(0, 0, 0, 0.03) !important;
                    color: inherit !important;
                    border-radius: 6px !important;
                    padding: 8px 16px 8px 45px !important;
                    margin: 2px 12px !important;
                    transition: all 0.2s ease !important;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
                    transform: translateX(2px) !important;
                }

                .dash-sidebar .dash-submenu .dash-item.active > .dash-link {
                    background: rgba(81, 69, 157, 0.08) !important;
                    color: #51459d !important;
                    border-radius: 6px !important;
                    padding: 8px 16px 8px 45px !important;
                    margin: 2px 12px !important;
                    box-shadow: 0 2px 4px rgba(81, 69, 157, 0.1) !important;
                    font-weight: 500 !important;
                    transform: translateX(3px) !important;
                    border-left: 3px solid #51459d !important;
                }

                .dash-sidebar .dash-submenu .dash-item > .dash-link {
                    background: transparent !important;
                    color: #6c757d !important;
                    border-radius: 6px !important;
                    padding: 8px 16px 8px 45px !important;
                    margin: 2px 12px !important;
                    transition: all 0.2s ease !important;
                    font-size: 13px !important;
                    position: relative !important;
                    overflow: visible !important;
                    line-height: 1.4 !important;
                }

                .dash-sidebar .dash-submenu {
                    background: rgba(248, 249, 253, 0.6) !important;
                    border-radius: 8px !important;
                    padding: 6px 0 !important;
                    margin: 8px 8px 8px 16px !important;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06) !important;
                    border: 1px solid rgba(0, 0, 0, 0.04) !important;
                    backdrop-filter: blur(10px) !important;
                }

                .dash-sidebar .dash-submenu .dash-item:before {
                    content: "•" !important;
                    position: absolute !important;
                    left: 28px !important;
                    top: 10px !important;
                    width: auto !important;
                    height: auto !important;
                    border: none !important;
                    border-right-color: transparent !important;
                    border-radius: 0 !important;
                    z-index: 1 !important;
                    transform: none !important;
                    transition: all 0.2s ease !important;
                    color: #cbd5e0 !important;
                    font-size: 16px !important;
                    line-height: 1 !important;
                }

                .dash-sidebar .dash-submenu .dash-item:hover:before {
                    color: #51459d !important;
                    transform: scale(1.2) !important;
                    box-shadow: none !important;
                }

                .dash-sidebar .dash-submenu .dash-item.active:before {
                    color: #51459d !important;
                    transform: scale(1.3) !important;
                    box-shadow: none !important;
                    font-weight: bold !important;
                }

                .dash-sidebar .dash-submenu .dash-item:hover > .dash-link::after {
                    content: none !important;
                    position: static !important;
                    top: auto !important;
                    left: auto !important;
                    right: auto !important;
                    bottom: auto !important;
                    background: none !important;
                    transform: none !important;
                    transition: none !important;
                }

                .dash-sidebar.light-sidebar .dash-submenu .dash-item:hover > .dash-link {
                    background: transparent !important;
                    color: inherit !important;
                }

                .dash-sidebar.light-sidebar .dash-submenu .dash-item.active > .dash-link {
                    background: transparent !important;
                    color: inherit !important;
                }

                .dash-sidebar:not(.light-sidebar) .dash-submenu {
                    background: rgba(28, 35, 47, 0.8) !important;
                    border: 1px solid rgba(255, 255, 255, 0.08) !important;
                }

                .dash-sidebar:not(.light-sidebar) .dash-submenu .dash-item > .dash-link {
                    color: #a0aec0 !important;
                }

                .dash-sidebar:not(.light-sidebar) .dash-submenu .dash-item:hover > .dash-link {
                    background: rgba(255, 255, 255, 0.05) !important;
                    color: #ffffff !important;
                }

                .dash-sidebar:not(.light-sidebar) .dash-submenu .dash-item.active > .dash-link {
                    background: rgba(81, 69, 157, 0.15) !important;
                    color: #51459d !important;
                    border-left: 3px solid #51459d !important;
                }

                .dash-sidebar:not(.light-sidebar) .dash-submenu .dash-item:before {
                    color: rgba(255, 255, 255, 0.3) !important;
                }

                .dash-sidebar:not(.light-sidebar) .dash-submenu .dash-item:hover:before,
                .dash-sidebar:not(.light-sidebar) .dash-submenu .dash-item.active:before {
                    color: #51459d !important;
                }

                .minimenu .dash-sidebar .dash-submenu .dash-item:hover > .dash-link {
                    background: transparent !important;
                    color: inherit !important;
                    border-radius: 0 !important;
                }

                .minimenu .dash-sidebar .dash-submenu .dash-item.active > .dash-link {
                    background: transparent !important;
                    color: inherit !important;
                    border-radius: 0 !important;
                }

                .dash-sidebar .dash-submenu .dash-submenu .dash-item:hover > .dash-link {
                    background: transparent !important;
                    color: inherit !important;
                    border-radius: 0 !important;
                }

                .dash-sidebar .dash-submenu .dash-submenu .dash-item.active > .dash-link {
                    background: transparent !important;
                    color: inherit !important;
                    border-radius: 0 !important;
                }

                .dash-sidebar .dash-hasmenu.dash-trigger > .dash-submenu {
                    display: block !important;
                    animation: none !important;
                }

                @keyframes slideDownFadeIn {
                    from {
                        opacity: 1;
                        transform: translateY(0);
                        max-height: auto;
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                        max-height: auto;
                    }
                }

                @media (max-width: 768px) {
                    .dash-sidebar .dash-submenu .dash-item:hover > .dash-link {
                        transform: translateX(1px) !important;
                        padding: 6px 12px 6px 35px !important;
                        margin: 1px 8px !important;
                    }
                    
                    .dash-sidebar .dash-submenu .dash-item.active > .dash-link {
                        transform: translateX(2px) !important;
                        padding: 6px 12px 6px 35px !important;
                        margin: 1px 8px !important;
                    }

                    .dash-sidebar .dash-submenu {
                        margin: 4px 4px 4px 8px !important;
                        padding: 4px 0 !important;
                    }

                    .dash-sidebar .dash-submenu .dash-item:before {
                        left: 20px !important;
                        top: 8px !important;
                        font-size: 14px !important;
                    }
                }

                .dash-sidebar .dash-submenu .dash-item {
                    position: relative !important;
                }

                .dash-sidebar .dash-submenu .dash-item:hover {
                    z-index: auto !important;
                }

                .dash-sidebar .dash-submenu,
                .dash-sidebar .dash-submenu .dash-item,
                .dash-sidebar .dash-submenu .dash-item > .dash-link {
                    transition: none !important;
                }
            </style>
        `;
        
        document.head.insertAdjacentHTML('beforeend', customStyles);
        console.log('Custom submenu styles injected successfully');
    }
    
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
        
        // Function to hide empty menu items
        function hideEmptyMenuItems() {
            // Hide empty <li> elements
            const emptyListItems = sidebar.querySelectorAll('li:empty');
            emptyListItems.forEach(item => {
                item.style.display = 'none';
            });
            
            // Hide <li> elements with empty <a> tags (no text content or href)
            const listItemsWithEmptyLinks = sidebar.querySelectorAll('li');
            listItemsWithEmptyLinks.forEach(item => {
                const link = item.querySelector('a.dash-link');
                if (link && 
                    (!link.textContent.trim() || link.textContent.trim() === '') && 
                    (!link.getAttribute('href') || link.getAttribute('href') === '' || link.getAttribute('href') === '#')) {
                    item.style.display = 'none';
                }
            });
            
            // Hide submenu containers that have no visible children
            const submenus = sidebar.querySelectorAll('.dash-submenu');
            submenus.forEach(submenu => {
                const visibleChildren = Array.from(submenu.children).filter(child => {
                    return window.getComputedStyle(child).display !== 'none';
                });
                
                if (visibleChildren.length === 0) {
                    const parentMenuItem = submenu.closest('.dash-item.dash-hasmenu');
                    if (parentMenuItem) {
                        parentMenuItem.style.display = 'none';
                    }
                }
            });
        }
        
        // Clean up empty menu items after initialization
        hideEmptyMenuItems();
        
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

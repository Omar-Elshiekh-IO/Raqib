/**
 * Sidebar Auto-Close Enhancement
 * Automatically closes open submenus when sidebar collapses
 * COMPLETELY NON-INVASIVE: Only handles auto-close functionality, preserves all original menu behavior
 */

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.dash-sidebar.sidebar-hoverable');
    
    if (!sidebar) return;
    
    // Inject custom styles for better submenu appearance
    injectCustomSubmenuStyles();
    
    // Wait for original menu system to fully initialize and load dynamic content
    setTimeout(() => {
        initializeSidebarEnhancements();
    }, 1000); // Reduced delay for faster initialization
    
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
                
                /* Ensure original submenu functionality is preserved */
                .dash-sidebar .dash-submenu {
                    display: none;
                }
                
                .dash-sidebar .dash-hasmenu.dash-trigger .dash-submenu {
                    display: block !important;
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
                
                /* Ensure submenus work properly with original functionality */
                .dash-sidebar .dash-submenu {
                    display: none !important;
                }
                
                .dash-sidebar .dash-hasmenu.dash-trigger > .dash-submenu {
                    display: block !important;
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
        let menuClickTimeout = null;
        
        console.log('Sidebar enhancements initialized - fixing submenu timing issues');
        
        // Add debounced click handling to prevent rapid menu toggling
        function debounceMenuClicks() {
            const menuItems = sidebar.querySelectorAll('.dash-item.dash-hasmenu > .dash-link');
            
            menuItems.forEach(menuItem => {
                const originalClickHandler = menuItem.onclick;
                
                menuItem.addEventListener('click', function(event) {
                    // Prevent rapid clicking
                    if (menuClickTimeout) {
                        return;
                    }
                    
                    menuClickTimeout = setTimeout(() => {
                        menuClickTimeout = null;
                    }, 300); // 300ms debounce
                    
                    // Let the original handler process
                    setTimeout(() => {
                        // Additional check to ensure submenu state is stable
                        const parentItem = this.parentNode;
                        if (parentItem.classList.contains('dash-trigger')) {
                            const submenu = parentItem.querySelector('.dash-submenu');
                            if (submenu) {
                                submenu.style.display = 'block';
                            }
                        }
                    }, 50);
                });
            });
        }
        
        // Fix timing issues with submenu animations
        function fixSubmenuTiming() {
            const observer = new MutationObserver((mutations) => {
                mutations.forEach((mutation) => {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        const target = mutation.target;
                        if (target.classList.contains('dash-hasmenu')) {
                            const submenu = target.querySelector('.dash-submenu');
                            if (submenu) {
                                if (target.classList.contains('dash-trigger')) {
                                    // Ensure submenu is properly visible
                                    setTimeout(() => {
                                        submenu.style.display = 'block';
                                        submenu.style.opacity = '1';
                                    }, 10);
                                } else {
                                    // Add slight delay before hiding to prevent flickering
                                    setTimeout(() => {
                                        if (!target.classList.contains('dash-trigger')) {
                                            submenu.style.display = 'none';
                                        }
                                    }, 250);
                                }
                            }
                        }
                    }
                });
            });
            
            const menuItems = sidebar.querySelectorAll('.dash-item.dash-hasmenu');
            menuItems.forEach(item => {
                observer.observe(item, { attributes: true, attributeFilter: ['class'] });
            });
        }
        
        // Initialize fixes
        debounceMenuClicks();
        fixSubmenuTiming();
        
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
        
        // Don't hide empty menu items - let original menu system handle it
        // hideEmptyMenuItems();
        
        // Function to close all open submenus (only remove trigger class)
        function closeAllSubmenus() {
            const openMenus = sidebar.querySelectorAll('.dash-item.dash-trigger');
            openMenus.forEach(menu => {
                menu.classList.remove('dash-trigger');
            });
        }
        
        // Don't restore submenu states - let original menu system handle it
        // function restoreActiveSubmenuStates() removed to avoid interference
        
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
            
            // Don't restore submenu states - let original menu system handle it
            // setTimeout(() => {
            //     if (isHovered) {
            //         restoreActiveSubmenuStates();
            //     }
            // }, 150);
        });
        
        // Monitor when sidebar leaves hover state (collapses)
        sidebar.addEventListener('mouseleave', function() {
            isHovered = false;
            
            // Add a delay before closing to allow user to navigate back
            collapseTimeout = setTimeout(() => {
                if (!isHovered && !sidebar.matches(':hover')) {
                    closeAllSubmenus();
                }
            }, 500); // Increased delay to 500ms for better UX
        });
        
        // Handle window resize to ensure proper behavior
        window.addEventListener('resize', function() {
            if (window.innerWidth <= 1024) {
                // On mobile, don't auto-close menus
                isHovered = true;
            }
        });
        
        // Initialize hover state (don't restore submenu states)
        if (sidebar.matches(':hover')) {
            isHovered = true;
            // Don't restore submenu states - let original menu system handle it
            // setTimeout(() => {
            //     restoreActiveSubmenuStates();
            // }, 100);
        }
        
        console.log('Sidebar auto-close ready (minimal mode - only removes trigger class on sidebar leave)');
    }
});

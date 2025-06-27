/**
 * Sidebar Auto-Close Submenu Enhancement
 * Automatically closes submenu items when sidebar collapses
 */

document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.dash-sidebar.sidebar-hoverable');
    
    if (!sidebar) return;
    
    // Disable original menu click handling to prevent conflicts
    const originalMenuItems = sidebar.querySelectorAll('.dash-navbar > li:not(.dash-caption)');
    originalMenuItems.forEach(item => {
        const clonedItem = item.cloneNode(true);
        item.parentNode.replaceChild(clonedItem, item);
    });
    
    let isHovered = false;
    let collapseTimeout = null;
    let submenuHoverTimeout = null;
    let lastClickTime = 0;
    
    // Debounce function to prevent rapid state changes
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Function to close all open submenus
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
        
        // Add a longer delay before closing to allow user to navigate to submenus
        collapseTimeout = setTimeout(() => {
            if (!isHovered) {
                closeAllSubmenus();
            }
        }, 500); // Increased from 200ms to 500ms
    });
    
    // Enhanced menu item click handling with debouncing
    const menuItems = sidebar.querySelectorAll('.dash-item.dash-hasmenu > .dash-link');
    menuItems.forEach(link => {
        const debouncedClick = debounce(function(parentItem, submenu) {
            // Toggle current submenu
            if (parentItem.classList.contains('dash-trigger')) {
                parentItem.classList.remove('dash-trigger');
                // Use slideUp animation if available
                if (typeof slideUp === 'function') {
                    slideUp(submenu, 200);
                } else {
                    submenu.style.display = 'none';
                }
            } else {
                // Close other open submenus at same level
                const parentUl = parentItem.parentNode;
                const siblings = parentUl.children;
                Array.from(siblings).forEach(sibling => {
                    if (sibling !== parentItem && 
                        sibling.classList.contains('dash-trigger') &&
                        sibling.classList.contains('dash-hasmenu')) {
                        sibling.classList.remove('dash-trigger');
                        const siblingSubmenu = sibling.querySelector('.dash-submenu');
                        if (siblingSubmenu) {
                            if (typeof slideUp === 'function') {
                                slideUp(siblingSubmenu, 200);
                            } else {
                                siblingSubmenu.style.display = 'none';
                            }
                        }
                    }
                });
                
                // Open current submenu
                parentItem.classList.add('dash-trigger');
                // Use slideDown animation if available
                if (typeof slideDown === 'function') {
                    slideDown(submenu, 200);
                } else {
                    submenu.style.display = 'block';
                }
            }
        }, 100);
        
        link.addEventListener('click', function(e) {
            // Always prevent default for menu items with submenus
            e.preventDefault();
            e.stopPropagation();
            
            // Prevent rapid clicking
            const currentTime = Date.now();
            if (currentTime - lastClickTime < 150) {
                return false;
            }
            lastClickTime = currentTime;
            
            // Only handle submenu expansion when sidebar is expanded (hover state)
            if (!isHovered) {
                return false;
            }
            
            const parentItem = this.closest('.dash-item');
            const submenu = parentItem.querySelector('.dash-submenu');
            
            if (submenu) {
                // Clear any hover timeouts to prevent conflicts
                if (collapseTimeout) {
                    clearTimeout(collapseTimeout);
                    collapseTimeout = null;
                }
                if (submenuHoverTimeout) {
                    clearTimeout(submenuHoverTimeout);
                    submenuHoverTimeout = null;
                }
                
                // Use debounced click handler
                debouncedClick(parentItem, submenu);
            }
        });
    });

    // Handle arrow clicks specifically to prevent conflicts (including nested arrows)
    const arrowElements = sidebar.querySelectorAll('.dash-arrow');
    arrowElements.forEach(arrow => {
        arrow.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Prevent rapid clicking for arrows too
            const currentTime = Date.now();
            if (currentTime - lastClickTime < 150) {
                return false;
            }
            lastClickTime = currentTime;
            
            // Only handle when sidebar is expanded
            if (!isHovered) {
                return false;
            }
            
            // Clear any timeouts to prevent conflicts
            if (collapseTimeout) {
                clearTimeout(collapseTimeout);
                collapseTimeout = null;
            }
            if (submenuHoverTimeout) {
                clearTimeout(submenuHoverTimeout);
                submenuHoverTimeout = null;
            }
            
            // Trigger the parent link click
            const parentLink = this.closest('.dash-link');
            if (parentLink) {
                // Create a synthetic click event
                const clickEvent = new Event('click', {
                    bubbles: false,
                    cancelable: true
                });
                parentLink.dispatchEvent(clickEvent);
            }
        });
    });

    // Add hover tracking for main menu items with submenus
    const mainMenuItems = sidebar.querySelectorAll('.dash-item.dash-hasmenu');
    mainMenuItems.forEach(menuItem => {
        let hoverTimeout = null;
        
        menuItem.addEventListener('mouseenter', function() {
            // Clear any pending collapse timeouts when hovering over menu items
            if (collapseTimeout) {
                clearTimeout(collapseTimeout);
                collapseTimeout = null;
            }
            if (submenuHoverTimeout) {
                clearTimeout(submenuHoverTimeout);
                submenuHoverTimeout = null;
            }
            if (hoverTimeout) {
                clearTimeout(hoverTimeout);
                hoverTimeout = null;
            }
        });
        
        menuItem.addEventListener('mouseleave', function(e) {
            // Clear any existing hover timeout
            if (hoverTimeout) {
                clearTimeout(hoverTimeout);
            }
            
            // Only close if we're leaving the entire menu item and its submenu
            const relatedTarget = e.relatedTarget;
            const submenu = this.querySelector('.dash-submenu');
            
            // Don't close if moving to submenu or another menu item
            if (!relatedTarget || 
                (!this.contains(relatedTarget) && 
                 !(submenu && submenu.contains(relatedTarget)) &&
                 !relatedTarget.closest('.dash-item.dash-hasmenu'))) {
                
                hoverTimeout = setTimeout(() => {
                    if (!isHovered && !sidebar.matches(':hover')) {
                        closeAllSubmenus();
                    }
                }, 600); // Increased delay for better UX
            }
        });
    });
    
    // Add hover tracking for all submenu items to prevent premature closing (including nested)
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
            // Check if we're moving to a nested submenu or staying within sidebar
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
                }, 400); // Longer delay for better navigation
            }
        });
    });
    
    // Handle nested submenu items with improved debouncing
    const nestedMenuItems = sidebar.querySelectorAll('.dash-submenu .dash-item.dash-hasmenu > .dash-link');
    nestedMenuItems.forEach(link => {
        const debouncedNestedClick = debounce(function(parentItem, submenu) {
            // Toggle nested submenu
            if (parentItem.classList.contains('dash-trigger')) {
                parentItem.classList.remove('dash-trigger');
                if (typeof slideUp === 'function') {
                    slideUp(submenu, 200);
                } else {
                    submenu.style.display = 'none';
                }
            } else {
                // Close other nested submenus at same level
                const parentSubmenu = parentItem.closest('.dash-submenu');
                const siblings = parentSubmenu.children;
                Array.from(siblings).forEach(sibling => {
                    if (sibling !== parentItem && 
                        sibling.classList.contains('dash-trigger') &&
                        sibling.classList.contains('dash-hasmenu')) {
                        sibling.classList.remove('dash-trigger');
                        const siblingSubmenu = sibling.querySelector('.dash-submenu');
                        if (siblingSubmenu) {
                            if (typeof slideUp === 'function') {
                                slideUp(siblingSubmenu, 200);
                            } else {
                                siblingSubmenu.style.display = 'none';
                            }
                        }
                    }
                });
                
                // Open nested submenu
                parentItem.classList.add('dash-trigger');
                if (typeof slideDown === 'function') {
                    slideDown(submenu, 200);
                } else {
                    submenu.style.display = 'block';
                }
            }
        }, 100);
        
        link.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Prevent rapid clicking for nested items too
            const currentTime = Date.now();
            if (currentTime - lastClickTime < 150) {
                return false;
            }
            lastClickTime = currentTime;
            
            if (!isHovered) {
                return false;
            }
            
            const parentItem = this.closest('.dash-item');
            const submenu = parentItem.querySelector('.dash-submenu');
            
            if (submenu) {
                // Clear any hover timeouts to prevent conflicts
                if (collapseTimeout) {
                    clearTimeout(collapseTimeout);
                    collapseTimeout = null;
                }
                if (submenuHoverTimeout) {
                    clearTimeout(submenuHoverTimeout);
                    submenuHoverTimeout = null;
                }
                
                // Use debounced click handler for nested items
                debouncedNestedClick(parentItem, submenu);
            }
        });
    });

    // Add hover tracking for nested submenu items
    const nestedMenuItemsWithSubmenus = sidebar.querySelectorAll('.dash-submenu .dash-item.dash-hasmenu');
    nestedMenuItemsWithSubmenus.forEach(nestedItem => {
        let nestedHoverTimeout = null;
        
        nestedItem.addEventListener('mouseenter', function() {
            // Clear all timeouts when hovering over nested items
            if (collapseTimeout) {
                clearTimeout(collapseTimeout);
                collapseTimeout = null;
            }
            if (submenuHoverTimeout) {
                clearTimeout(submenuHoverTimeout);
                submenuHoverTimeout = null;
            }
            if (nestedHoverTimeout) {
                clearTimeout(nestedHoverTimeout);
                nestedHoverTimeout = null;
            }
        });
        
        nestedItem.addEventListener('mouseleave', function(e) {
            // Clear any existing nested hover timeout
            if (nestedHoverTimeout) {
                clearTimeout(nestedHoverTimeout);
            }
            
            // Only close if we're leaving the nested menu item and its submenu
            const relatedTarget = e.relatedTarget;
            const nestedSubmenu = this.querySelector('.dash-submenu');
            
            // Don't close if moving to nested submenu or staying within the sidebar
            if (!relatedTarget || 
                (!this.contains(relatedTarget) && 
                 !(nestedSubmenu && nestedSubmenu.contains(relatedTarget)) &&
                 !relatedTarget.closest('.dash-submenu') &&
                 !relatedTarget.closest('.dash-item.dash-hasmenu'))) {
                
                nestedHoverTimeout = setTimeout(() => {
                    if (!isHovered && !sidebar.matches(':hover')) {
                        closeAllSubmenus();
                    }
                }, 700); // Even longer delay for nested items
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
});

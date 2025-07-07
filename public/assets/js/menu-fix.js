/**
 * Menu Fix - Resolves fast opening/closing submenu issues
 * This file provides fixes for submenu timing problems
 */

document.addEventListener('DOMContentLoaded', function() {
    // Wait for the original menu system to initialize
    setTimeout(() => {
        fixSubmenuTiming();
    }, 500);
    
    function fixSubmenuTiming() {
        console.log('Applying submenu timing fixes...');
        
        // Override the slide animation duration to make it slower and more stable
        const originalSlideUp = window.slideUp;
        const originalSlideDown = window.slideDown;
        
        // Force refresh submenu styling
        forceRefreshSubmenuStyling();
        
        // Create debounced versions with longer durations
        window.slideUp = function(target, duration = 400) {
            if (!target) return;
            
            // Prevent multiple animations on same element
            if (target.getAttribute('data-animating') === 'true') {
                return;
            }
            target.setAttribute('data-animating', 'true');
            
            target.style.transitionProperty = "height, margin, padding";
            target.style.transitionDuration = duration + "ms";
            target.style.boxSizing = "border-box";
            target.style.height = target.offsetHeight + "px";
            target.offsetHeight;
            target.style.overflow = "hidden";
            target.style.height = 0;
            target.style.paddingTop = 0;
            target.style.paddingBottom = 0;
            target.style.marginTop = 0;
            target.style.marginBottom = 0;
            
            setTimeout(() => {
                target.style.display = 'none';
                target.removeAttribute('data-animating');
            }, duration);
        };
        
        window.slideDown = function(target, duration = 400) {
            if (!target) return;
            
            // Prevent multiple animations on same element
            if (target.getAttribute('data-animating') === 'true') {
                return;
            }
            target.setAttribute('data-animating', 'true');
            
            target.style.removeProperty("display");
            let display = window.getComputedStyle(target).display;
            
            if (display === "none") display = "block";
            
            target.style.display = display;
            let height = target.offsetHeight;
            target.style.overflow = "hidden";
            target.style.height = 0;
            target.style.paddingTop = 0;
            target.style.paddingBottom = 0;
            target.style.marginTop = 0;
            target.style.marginBottom = 0;
            target.offsetHeight;
            target.style.boxSizing = "border-box";
            target.style.transitionProperty = "height, margin, padding";
            target.style.transitionDuration = duration + "ms";
            target.style.height = height + "px";
            target.style.removeProperty("padding-top");
            target.style.removeProperty("padding-bottom");
            target.style.removeProperty("margin-top");
            target.style.removeProperty("margin-bottom");
            
            setTimeout(() => {
                target.style.removeProperty("height");
                target.style.removeProperty("overflow");
                target.style.removeProperty("transition-duration");
                target.style.removeProperty("transition-property");
                target.removeAttribute('data-animating');
            }, duration);
        };
        
        // Add click debouncing to menu items
        const menuItems = document.querySelectorAll('.dash-navbar > li:not(.dash-caption)');
        const clickTimeouts = new Map();
        
        menuItems.forEach((item, index) => {
            const link = item.querySelector('a');
            if (link) {
                const newLink = link.cloneNode(true);
                link.parentNode.replaceChild(newLink, link);
                
                newLink.addEventListener('click', function(event) {
                    event.stopPropagation();
                    
                    // Debounce rapid clicks
                    if (clickTimeouts.has(index)) {
                        clearTimeout(clickTimeouts.get(index));
                    }
                    
                    clickTimeouts.set(index, setTimeout(() => {
                        handleMenuClick(this, event);
                        clickTimeouts.delete(index);
                    }, 100));
                });
            }
        });
        
        function handleMenuClick(targetElement, event) {
            if (targetElement.tagName === "SPAN") {
                targetElement = targetElement.parentNode;
            }
            
            const parentItem = targetElement.parentNode;
            const submenu = parentItem.querySelector('.dash-submenu');
            
            if (!submenu) return;
            
            if (parentItem.classList.contains("dash-trigger")) {
                parentItem.classList.remove("dash-trigger");
                window.slideUp(submenu, 300);
            } else {
                // Close all other open menus first
                const openMenus = document.querySelectorAll("li.dash-trigger");
                openMenus.forEach(menu => {
                    if (menu !== parentItem) {
                        menu.classList.remove("dash-trigger");
                        const openSubmenu = menu.querySelector('.dash-submenu');
                        if (openSubmenu) {
                            window.slideUp(openSubmenu, 300);
                        }
                    }
                });
                
                // Open this menu
                setTimeout(() => {
                    parentItem.classList.add("dash-trigger");
                    window.slideDown(submenu, 300);
                }, 100);
            }
        }
        
        // Fix for submenu items
        const submenuItems = document.querySelectorAll('.dash-navbar > li:not(.dash-caption) li');
        submenuItems.forEach(item => {
            const link = item.querySelector('a');
            if (link) {
                const newLink = link.cloneNode(true);
                link.parentNode.replaceChild(newLink, link);
                
                newLink.addEventListener('click', function(event) {
                    event.stopPropagation();
                    
                    const parentItem = this.parentNode;
                    const submenu = parentItem.querySelector('.dash-submenu');
                    
                    if (!submenu) return;
                    
                    if (parentItem.classList.contains("dash-trigger")) {
                        parentItem.classList.remove("dash-trigger");
                        window.slideUp(submenu, 300);
                    } else {
                        // Close sibling menus
                        const siblingMenus = parentItem.parentNode.querySelectorAll("li.dash-trigger");
                        siblingMenus.forEach(menu => {
                            if (menu !== parentItem) {
                                menu.classList.remove("dash-trigger");
                                const siblingSubmenu = menu.querySelector('.dash-submenu');
                                if (siblingSubmenu) {
                                    window.slideUp(siblingSubmenu, 300);
                                }
                            }
                        });
                        
                        // Open this menu
                        setTimeout(() => {
                            parentItem.classList.add("dash-trigger");
                            window.slideDown(submenu, 300);
                        }, 100);
                    }
                });
            }
        });
        
        console.log('Submenu timing fixes applied successfully');
    }
    
    function forceRefreshSubmenuStyling() {
        // Force update all submenu items with proper styling
        const submenus = document.querySelectorAll('.dash-submenu');
        submenus.forEach(submenu => {
            // Add enhanced styling class
            submenu.classList.add('enhanced-submenu');
            
            // Force refresh all submenu items
            const submenuItems = submenu.querySelectorAll('.dash-item, li');
            submenuItems.forEach(item => {
                const link = item.querySelector('a, .dash-link');
                if (link) {
                    // Force reapply styles by triggering a repaint
                    link.style.display = 'none';
                    link.offsetHeight; // Force reflow
                    link.style.display = 'block';
                    
                    // Ensure proper positioning
                    item.style.position = 'relative';
                    
                    // Check if this is the active page
                    if (window.location.pathname === link.getAttribute('href') || 
                        window.location.href === link.href) {
                        item.classList.add('active');
                        // Open parent menu if this is active
                        const parentMenu = item.closest('.dash-hasmenu');
                        if (parentMenu) {
                            parentMenu.classList.add('dash-trigger');
                        }
                    }
                }
            });
        });
        
        // Force CSS recalculation
        document.body.style.display = 'none';
        document.body.offsetHeight; // Force reflow
        document.body.style.display = '';
        
        console.log('Submenu styling refreshed');
    }
});

/**
 * HRM Submenu Visibility Fix
 * Ensures that HRM submenu items (Training and Payroll) are always visible
 */

(function() {
    'use strict';
    
    function fixHRMSubmenuVisibility() {
        console.log('Applying HRM submenu visibility fix...');
        
        // Find all HRM-related submenu items and ensure they're visible
        const hrmSubmenuSelectors = [
            '.dash-submenu .dash-item a[href*="training"]',
            '.dash-submenu .dash-item a[href*="trainer"]', 
            '.dash-submenu .dash-item a[href*="payslip"]',
            '.dash-submenu .dash-item a[href*="setsalary"]',
            '.dash-submenu .dash-item:has(a[href*="training"])',
            '.dash-submenu .dash-item:has(a[href*="trainer"])',
            '.dash-submenu .dash-item:has(a[href*="payslip"])',
            '.dash-submenu .dash-item:has(a[href*="setsalary"])'
        ];
        
        hrmSubmenuSelectors.forEach(selector => {
            try {
                const elements = document.querySelectorAll(selector);
                elements.forEach(element => {
                    // For link elements, work with their parent list item
                    const listItem = element.tagName === 'A' ? element.closest('.dash-item') : element;
                    
                    if (listItem) {
                        // Force visibility
                        listItem.style.display = 'block';
                        listItem.style.visibility = 'visible';
                        listItem.style.opacity = '1';
                        
                        // Ensure the link is also visible
                        const link = listItem.querySelector('a, .dash-link');
                        if (link) {
                            link.style.display = 'block';
                            link.style.visibility = 'visible';
                            
                            // Add enhanced styling for better visibility
                            link.style.padding = '10px 16px 10px 45px';
                            link.style.margin = '2px 12px';
                            link.style.borderRadius = '6px';
                            link.style.transition = 'all 0.2s ease';
                            
                            console.log('Fixed visibility for:', link.textContent.trim());
                        }
                    }
                });
            } catch (e) {
                // Ignore selector errors for browsers that don't support :has()
                console.log('Selector not supported:', selector);
            }
        });
        
        // Alternative approach: Find submenu items by text content
        const submenuItems = document.querySelectorAll('.dash-submenu .dash-item');
        submenuItems.forEach(item => {
            const link = item.querySelector('a, .dash-link');
            if (link) {
                const text = link.textContent.trim().toLowerCase();
                
                // Check if this is a Training or Payroll related item
                if (text.includes('training') || text.includes('trainer') || 
                    text.includes('payroll') || text.includes('payslip') || 
                    text.includes('set salary')) {
                    
                    // Force visibility
                    item.style.display = 'block';
                    item.style.visibility = 'visible';
                    item.style.opacity = '1';
                    
                    link.style.display = 'block';
                    link.style.visibility = 'visible';
                    
                    console.log('Fixed HRM submenu item:', text);
                }
            }
        });
        
        // Ensure parent HRM menus are properly configured
        const hrmMenus = document.querySelectorAll('.dash-item.dash-hasmenu');
        hrmMenus.forEach(menu => {
            const link = menu.querySelector('a, .dash-link');
            if (link) {
                const text = link.textContent.trim().toLowerCase();
                
                if (text.includes('training setup') || text.includes('payroll setup')) {
                    const submenu = menu.querySelector('.dash-submenu');
                    if (submenu) {
                        // Ensure submenu is ready to be shown
                        submenu.style.position = 'relative';
                        
                        // If this menu should be active, make sure it's triggered
                        if (menu.classList.contains('active') || menu.classList.contains('dash-trigger')) {
                            submenu.style.display = 'block';
                            submenu.style.visibility = 'visible';
                            submenu.style.opacity = '1';
                            
                            console.log('Activated HRM parent menu:', text);
                        }
                    }
                }
            }
        });
        
        console.log('HRM submenu visibility fix completed');
    }
    
    // Apply fix immediately
    fixHRMSubmenuVisibility();
    
    // Apply fix when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fixHRMSubmenuVisibility);
    } else {
        fixHRMSubmenuVisibility();
    }
    
    // Apply fix after other scripts have loaded
    setTimeout(fixHRMSubmenuVisibility, 100);
    setTimeout(fixHRMSubmenuVisibility, 500);
    setTimeout(fixHRMSubmenuVisibility, 1000);
    
    // Monitor for dynamic changes and reapply fix
    if (window.MutationObserver) {
        const observer = new MutationObserver(function(mutations) {
            let shouldRefix = false;
            
            mutations.forEach(mutation => {
                if (mutation.type === 'attributes' && 
                    (mutation.attributeName === 'style' || mutation.attributeName === 'class')) {
                    const target = mutation.target;
                    if (target.classList.contains('dash-submenu') || 
                        target.classList.contains('dash-item') ||
                        target.closest('.dash-submenu')) {
                        shouldRefix = true;
                    }
                }
            });
            
            if (shouldRefix) {
                setTimeout(fixHRMSubmenuVisibility, 50);
            }
        });
        
        observer.observe(document.body, {
            attributes: true,
            subtree: true,
            attributeFilter: ['style', 'class']
        });
    }
    
})();

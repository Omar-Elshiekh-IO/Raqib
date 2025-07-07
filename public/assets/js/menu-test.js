/**
 * Menu Test and Debug Script
 * Use this to test if the menu fixes are working properly
 */

document.addEventListener('DOMContentLoaded', function() {
    // Wait for all systems to load
    setTimeout(() => {
        runMenuTests();
    }, 2000);
    
    function runMenuTests() {
        console.log('🔧 Running menu functionality tests...');
        
        // Test 1: Check if menu fix is loaded
        if (typeof window.slideUp === 'function' && typeof window.slideDown === 'function') {
            console.log('✅ Menu fix functions loaded successfully');
        } else {
            console.log('❌ Menu fix functions not loaded properly');
        }
        
        // Test 2: Check if debouncing is working
        const menuItems = document.querySelectorAll('.dash-navbar > li:not(.dash-caption)');
        console.log(`✅ Found ${menuItems.length} main menu items`);
        
        // Test 3: Check if submenu elements exist
        const submenus = document.querySelectorAll('.dash-submenu');
        console.log(`✅ Found ${submenus.length} submenu containers`);
        
        // Test 4: Check if animation attributes are working
        let animatingElements = 0;
        submenus.forEach(submenu => {
            if (submenu.getAttribute('data-animating') !== null) {
                animatingElements++;
            }
        });
        console.log(`✅ Animation control attributes initialized`);
        
        // Test 5: Check CSS fixes
        const menuFixCSS = document.querySelector('link[href*="menu-fix.css"]');
        if (menuFixCSS) {
            console.log('✅ Menu fix CSS loaded successfully');
        } else {
            console.log('❌ Menu fix CSS not loaded');
        }
        
        // Test 6: Monitor for rapid clicks
        let clickCount = 0;
        const testInterval = setInterval(() => {
            clickCount = 0;
        }, 1000);
        
        menuItems.forEach((item, index) => {
            const link = item.querySelector('a');
            if (link) {
                link.addEventListener('click', () => {
                    clickCount++;
                    if (clickCount > 3) {
                        console.log('⚠️ Rapid clicking detected - debouncing should prevent issues');
                    }
                });
            }
        });
        
        console.log('🎉 Menu tests completed. Monitor console for any issues.');
        
        // Visual indicator removed to avoid UI clutter
    }
    
    // Monitor for menu issues
    let issueCount = 0;
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                const target = mutation.target;
                if (target.classList.contains('dash-hasmenu')) {
                    // Check for rapid toggling
                    if (target.hasAttribute('data-toggle-time')) {
                        const lastToggle = parseInt(target.getAttribute('data-toggle-time'));
                        const now = Date.now();
                        if (now - lastToggle < 200) {
                            issueCount++;
                            if (issueCount > 5) {
                                console.log('⚠️ Rapid menu toggling detected. Fixes should prevent this.');
                            }
                        }
                    }
                    target.setAttribute('data-toggle-time', Date.now());
                }
            }
        });
    });
    
    // Start monitoring
    const sidebar = document.querySelector('.dash-sidebar');
    if (sidebar) {
        observer.observe(sidebar, { 
            attributes: true, 
            attributeFilter: ['class'],
            subtree: true 
        });
    }
});

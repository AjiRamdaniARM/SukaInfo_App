// Smooth scroll for anchor links and close mobile menu
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        // Check if on the same page or navigating to another section on index.html
        let targetId = this.getAttribute('href');
        let targetElement = document.querySelector(targetId);

        if (targetElement) { // If it's a section on the current page
            targetElement.scrollIntoView({
                behavior: 'smooth'
            });
        } else { // If it's a link to another page/section (e.g., index.html#hot-news)
            window.location.href = this.getAttribute('href');
        }

        // Close mobile menu if it's active
        const navList = document.getElementById('nav-list');
        if (navList.classList.contains('active')) {
            navList.classList.remove('active');
            // Also remove the no-scroll class from body
            document.body.classList.remove('body-no-scroll');
        }
    });
});

// Toggle mobile menu visibility when hamburger icon is clicked
const hamburger = document.getElementById('hamburger');
const navList = document.getElementById('nav-list');

hamburger.addEventListener('click', (event) => {
    // Stop propagation to prevent document click listener from closing immediately
    event.stopPropagation();
    navList.classList.toggle('active');
    // Toggle body scrolling when mobile menu is active
    document.body.classList.toggle('body-no-scroll');
});

// Close mobile menu when clicking outside of it
document.addEventListener('click', (event) => {
    // Check if the navList is active AND the click is outside the navList AND outside the hamburger
    if (navList.classList.contains('active') &&
        !navList.contains(event.target) &&
        !hamburger.contains(event.target)) {

        navList.classList.remove('active');
        document.body.classList.remove('body-no-scroll');
    }
});

// Listener for the new close icon INSIDE the sidebar
const closeSidebarButton = document.querySelector('.close-sidebar-button'); // Ambil elemen berdasarkan class
if (closeSidebarButton) { // Pastikan elemen ada
    closeSidebarButton.addEventListener('click', (event) => {
        event.preventDefault(); // Mencegah default behavior link '#' (misal jika ada)
        event.stopPropagation(); // Mencegah event ini merambat ke document (agar tidak langsung dibuka lagi)

        // Tutup menu
        navList.classList.remove('active');
        document.body.classList.remove('body-no-scroll');
    });
}
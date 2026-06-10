function updateThemeIcons() {
    const isDark = document.documentElement.classList.contains('dark');

    document.querySelectorAll('[data-theme-icon="sun"]').forEach((icon) => {
        icon.classList.toggle('hidden', ! isDark);
    });

    document.querySelectorAll('[data-theme-icon="moon"]').forEach((icon) => {
        icon.classList.toggle('hidden', isDark);
    });
}

function initThemeToggle() {
    document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const root = document.documentElement;
            const nextTheme = root.classList.contains('dark') ? 'light' : 'dark';

            root.classList.toggle('dark', nextTheme === 'dark');
            localStorage.setItem('theme', nextTheme);
            updateThemeIcons();
        });
    });

    updateThemeIcons();
}

function setDropdownOpen(dropdown, open) {
    const trigger = dropdown.querySelector('[data-dropdown-trigger]');
    const menu = dropdown.querySelector('[data-dropdown-menu]');

    if (! trigger || ! menu) {
        return;
    }

    menu.classList.toggle('hidden', ! open);
    trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
}

function closeAllDropdowns() {
    document.querySelectorAll('[data-dropdown]').forEach((dropdown) => {
        setDropdownOpen(dropdown, false);
    });
}

function initDropdowns() {
    document.querySelectorAll('[data-dropdown]').forEach((dropdown) => {
        const trigger = dropdown.querySelector('[data-dropdown-trigger]');
        const menu = dropdown.querySelector('[data-dropdown-menu]');

        if (! trigger || ! menu) {
            return;
        }

        trigger.addEventListener('click', (event) => {
            event.stopPropagation();
            const isOpen = ! menu.classList.contains('hidden');

            closeAllDropdowns();
            setDropdownOpen(dropdown, ! isOpen);
        });
    });

    document.addEventListener('click', () => {
        closeAllDropdowns();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeAllDropdowns();
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initThemeToggle();
    initDropdowns();
});

(function() {
  const THEMES = ['classic', 'modern', 'dark', 'colorful'];
  let currentTheme = 'classic'; // Default theme

  function applyTheme(theme) {
    // Remove existing theme classes from header and footer
    const header = document.getElementById('masthead');
    const footer = document.getElementById('colophon');

    if (header) {
      THEMES.forEach(t => {
        header.classList.remove(`theme-${t}-header`);
        // Remove default Tailwind classes that might conflict
        header.classList.remove('bg-primary', 'text-white');
      });
      header.classList.add(`theme-${theme}-header`);
    }

    if (footer) {
      THEMES.forEach(t => {
        footer.classList.remove(`theme-${t}-footer`);
        // Remove default Tailwind classes that might conflict
        footer.classList.remove('bg-dark', 'text-light');
      });
      footer.classList.add(`theme-${theme}-footer`);
    }

    // Optionally, store the selected theme in localStorage
    try {
      localStorage.setItem('selectedTheme', theme);
    } catch (e) {
      console.warn('Could not save theme to localStorage:', e);
    }
  }

  function createThemeSwitcher() {
    const switcherContainer = document.createElement('div');
    switcherContainer.id = 'theme-switcher-controls';
    switcherContainer.style.position = 'fixed';
    switcherContainer.style.top = '20px';
    switcherContainer.style.right = '20px';
    switcherContainer.style.backgroundColor = 'white';
    switcherContainer.style.padding = '10px';
    switcherContainer.style.border = '1px solid #ccc';
    switcherContainer.style.zIndex = '10000';
    switcherContainer.style.display = 'flex';
    switcherContainer.style.gap = '10px';


    THEMES.forEach(theme => {
      const button = document.createElement('button');
      button.textContent = theme.charAt(0).toUpperCase() + theme.slice(1);
      button.dataset.theme = theme;
      button.style.padding = '5px 10px';
      button.style.cursor = 'pointer';
      button.style.border = '1px solid #ddd';
      button.style.backgroundColor = '#f9f9f9';
      button.style.color = '#333';


      button.addEventListener('click', function() {
        currentTheme = this.dataset.theme;
        applyTheme(currentTheme);
        // Update active button style
        document.querySelectorAll('#theme-switcher-controls button').forEach(btn => {
          btn.classList.remove('active-theme');
        });
        this.classList.add('active-theme');
      });
      switcherContainer.appendChild(button);
    });

    document.body.appendChild(switcherContainer);
    return switcherContainer;
  }

  function updateActiveButton(switcherInstance, theme) {
    if (!switcherInstance) return;
    switcherInstance.querySelectorAll('button').forEach(btn => {
      btn.classList.remove('active-theme');
      if (btn.dataset.theme === theme) {
        btn.classList.add('active-theme');
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function() {
    const switcher = createThemeSwitcher();
    let savedTheme = null;
    try {
      savedTheme = localStorage.getItem('selectedTheme');
    } catch (e) {
      console.warn('Could not retrieve theme from localStorage:', e);
    }

    if (savedTheme && THEMES.includes(savedTheme)) {
      currentTheme = savedTheme;
    }

    applyTheme(currentTheme);
    updateActiveButton(switcher, currentTheme);
  });
})();

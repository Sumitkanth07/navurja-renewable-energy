const toggle = document.querySelector('.menu-toggle');
const nav = document.querySelector('.site-nav');
const themeToggle = document.querySelector('.theme-toggle');
const storedTheme = localStorage.getItem('navurja-theme');

function setTheme(theme) {
  document.documentElement.dataset.theme = theme;
  localStorage.setItem('navurja-theme', theme);
  if (themeToggle) {
    themeToggle.textContent = theme === 'dark' ? 'Light' : 'Dark';
    themeToggle.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
  }
}

setTheme(storedTheme || 'light');

if (themeToggle) {
  themeToggle.addEventListener('click', () => {
    setTheme(document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark');
  });
}

if (toggle && nav) {
  toggle.addEventListener('click', () => nav.classList.toggle('open'));
  nav.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => nav.classList.remove('open')));
}

const links = [...document.querySelectorAll('.site-nav a')];
const sections = [...document.querySelectorAll('section[id]')];
window.addEventListener('scroll', () => {
  let current = '';
  sections.forEach((section) => {
    if (scrollY >= section.offsetTop - 120) current = '#' + section.id;
  });
  links.forEach((link) => link.classList.toggle('active', link.getAttribute('href').endsWith(current)));
});

const calc = document.querySelector('.results');
if (calc) {
  const money = (number) => 'Rs. ' + Math.round(number).toLocaleString('en-IN');
  const run = () => {
    const bill = +document.querySelector('#bill').value || 0;
    const city = +document.querySelector('#city').value || 1;
    const roof = +document.querySelector('#roof').value || 0;
    const usage = +document.querySelector('#usage').value || 0;
    const rate = +calc.dataset.rate;
    const co2Rate = +calc.dataset.co2;
    const roofKw = roof / 100;
    const billKw = bill / 900;
    const usageKw = usage / 120;
    const kw = Math.max(0.5, Math.min(roofKw, (billKw + usageKw) / 2)) * city;
    const monthly = bill * rate;
    document.querySelector('#system').textContent = kw.toFixed(1) + ' kW';
    document.querySelector('#monthly').textContent = money(monthly);
    document.querySelector('#annual').textContent = money(monthly * 12);
    document.querySelector('#years').textContent = money(monthly * 12 * 25);
    document.querySelector('#co2').textContent = (kw * co2Rate).toFixed(1) + ' tons/year';
  };
  ['bill', 'city', 'roof', 'usage'].forEach((id) => document.querySelector('#' + id).addEventListener('input', run));
  run();
}

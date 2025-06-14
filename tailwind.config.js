/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './**/*.php',
    './assets/js/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        primary: '#3B82F6',
        secondary: '#10B981',
        neutral: '#6B7280',
        accent: '#F59E0B',
        light: '#F3F4F6',
        dark: '#1F2937',
      },
    },
  },
  plugins: [],
}

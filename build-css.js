#!/usr/bin/env node

const fs = require('fs');
const { execSync } = require('child_process');

// Cabecera de WordPress para el tema
const wordpressHeader = `/*
Theme Name: ST162 Assistant Theme
Description: WordPress theme for AI Assistant plugin with Tailwind CSS styling
Author: Your Name
Version: 1.0.0
License: GPL v2 or later
Text Domain: st162-assistant-theme
*/

`;

// Ejecutar Tailwind CSS
console.log('Compilando CSS con Tailwind...');
execSync('npx tailwindcss -i ./assets/css/src/main.css -o temp-style.css --minify', {
  stdio: 'inherit'
});

// Leer el CSS compilado
const compiledCSS = fs.readFileSync('temp-style.css', 'utf8');

// Crear el archivo final con la cabecera de WordPress
const finalCSS = wordpressHeader + compiledCSS;

// Escribir el archivo final
fs.writeFileSync('style.css', finalCSS);

// Eliminar el archivo temporal
fs.unlinkSync('temp-style.css');

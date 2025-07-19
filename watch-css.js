#!/usr/bin/env node

const fs = require('fs');
const { spawn } = require('child_process');
const path = require('path');

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

// Función para procesar el CSS y agregar la cabecera
function processCSS() {
  try {
    if (fs.existsSync('temp-style.css')) {
      const compiledCSS = fs.readFileSync('temp-style.css', 'utf8');
      const finalCSS = wordpressHeader + compiledCSS;
      fs.writeFileSync('style.css', finalCSS);
      console.log('✅ CSS actualizado con cabecera de WordPress');
    }
  } catch (error) {
    console.error('Error procesando CSS:', error);
  }
}

// Compilación inicial
console.log('Iniciando modo watch de Tailwind CSS...');

// Iniciar Tailwind en modo watch
const tailwindProcess = spawn('npx', [
  'tailwindcss',
  '-i', './assets/css/src/main.css',
  '-o', 'temp-style.css',
  '--watch',
  '--minify'
], {
  stdio: 'inherit'
});

// Observar cambios en el archivo temporal
if (fs.existsSync('temp-style.css')) {
  fs.watchFile('temp-style.css', { interval: 500 }, () => {
    processCSS();
  });
}

// Procesamiento inicial después de un breve delay
setTimeout(processCSS, 2000);

// Manejar cierre del proceso
process.on('SIGINT', () => {
  console.log('\n🛑 Deteniendo watch mode...');
  tailwindProcess.kill();
  process.exit();
});

process.on('SIGTERM', () => {
  tailwindProcess.kill();
  process.exit();
});

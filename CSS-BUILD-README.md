# ST162 Assistant Theme - CSS Build Process

Este tema utiliza Tailwind CSS con scripts personalizados que preservan la cabecera de WordPress necesaria para el reconocimiento del tema.

## Scripts Disponibles

### Compilación de Producción
```bash
npm run build:cssle copy of the corresponding source code, to be
    distributed under the terms of Sections 1 and 2 above on a medium
    customarily used for software interchange; or,

    c) Accompany it with the information you received as to the offer
    to distribute corresponding source code.  (This alternative is
    allowed only for noncommercial distribution and only if you
    received the program in object code or executable form with such
    an offer, in accord with Subsection b above.)

The source code for a work means the preferred form of the work for
making modifications to it.  For an executable work, complete source
code means all the source code for all modules it contains, plus any
associated interface definition files, plus the scripts used to
control compilation
```
Compila el CSS de Tailwind y agrega automáticamente la cabecera de WordPress al archivo `style.css`.

### Modo Watch para Desarrollo
```bash
npm run watch:css
```
Inicia el modo watch de Tailwind que recompila automáticamente el CSS cuando se detectan cambios en los archivos fuente, manteniendo siempre la cabecera de WordPress.

### Desarrollo Completo con BrowserSync
```bash
npm run watch
```
Ejecuta tanto el watch de CSS como BrowserSync para desarrollo en tiempo real.

## Estructura de Archivos CSS

- **Archivo fuente**: `assets/css/src/main.css` - Contiene las directivas de Tailwind y estilos personalizados
- **Archivo compilado**: `style.css` - Archivo final con cabecera de WordPress y CSS compilado
- **Archivo temporal**: `temp-style.css` - Archivo temporal usado durante la compilación (en .gitignore)

## Cabecera de WordPress

La cabecera que se agrega automáticamente al `style.css` es:

```css
/*
Theme Name: ST162 Assistant Theme
Description: WordPress theme for AI Assistant plugin with Tailwind CSS styling
Author: Your Name
Version: 1.0.0
License: GPL v2 or later
Text Domain: st162-assistant-theme
*/
```

## Personalización

Para modificar la cabecera del tema, edita los archivos:
- `build-css.js` - Para compilación de producción
- `watch-css.js` - Para modo watch

## Notas Importantes

1. **No edites directamente** el archivo `style.css` ya que se sobrescribe en cada compilación
2. Todos los cambios de estilos deben hacerse en `assets/css/src/main.css`
3. El archivo `temp-style.css` está en .gitignore y no debe versionarse
4. Los scripts manejan automáticamente la preservación de la cabecera de WordPress

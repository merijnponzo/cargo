/*
  This is the default config 
*/

import { themeParser } from "blockbite-tailwind";
// load theme.json
const themeJson = require('./theme.json');
// parse it to tailwind values
// https://www.blockbite.dev/documentation/api/themeParser
const theme = themeParser(themeJson, false);


/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./blocks/**/*.{html,js,php}', './templates/**/*.{html,js,php}', './parts/**/*.{html,js,php}'],
  important: '.bite',
  safelist: [],
  theme: {
    fontFamily: theme.fonts,
    fontWeight: theme.fontWeights,
    container: theme.container,
    extend: {
      fontSize: theme.fontSizes,
      colors: theme.colors,
      spacing: theme.spacing,
      gap: theme.spacing,
      minWidth: theme.spacing,
      maxWidth: theme.spacing,
      minHeight: theme.spacing,
      maxHeight: theme.spacing,
      aspectRatio: theme.aspectRatio,
      screens: theme.screens
    },
  },
}
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    extend: {
      colors: {
        'description' : '#69707D',
        'b-grey' : '#E4E9F2',
        'marque': '#FF7E1B',
        'button': '#FFAB6A'
      },
      fontFamily: {
        'Kumbh':  ['Kumbh Sans']
      },
      borderWidth: {
        '1': '1px',
      },
      borderRadius: {
        '15': '15px',
      },
      width: {
        '100': '475px',
      }
    },
  },
  plugins: [],
}
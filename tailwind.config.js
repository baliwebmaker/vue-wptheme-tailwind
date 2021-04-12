module.exports = {
  purge: [],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
      container: {
        center: true,
        padding: '2rem',
        screens: {
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
        }
    }
  },
  variants: {
    extend: {},
  },
  plugins: [],
}

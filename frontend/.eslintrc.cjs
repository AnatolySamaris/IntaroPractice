/* eslint-env node */
require('@rushstack/eslint-patch/modern-module-resolution')

module.exports = {
  root: true,
  env: {
    node: true
  },
  extends: ['plugin:vue/essential', 'eslint:recommended', '@vue/prettier'],
  parserOptions: {
    parser: '@babel/eslint-parser',
    requireConfigFile: false
  },
  rules: {
    'no-unused-vars': 'off', // Отключает правило no-unused-vars
    'no-useless-escape': 'off',
    'vue/multi-word-component-names': 'off',
    'vue/no-reserved-component-names': 'off'
  },
  overrides: [
    {
      files: ['*.css'],
      rules: {
        // Отключение проверки CSS файлов
        'css/**': 'off'
      }
    }
  ]
}

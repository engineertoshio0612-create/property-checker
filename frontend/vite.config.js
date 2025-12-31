import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [vue()],
  server: {
    proxy: {
      // フロント(5173) -> バック(80)へ /api を転送
      '/api': {
        target: 'http://localhost',
        changeOrigin: true,
      },
    },
  },
})

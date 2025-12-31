<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const properties = ref([])
const loading = ref(false)
const error = ref('')

// フィルタ（最小）
const corner = ref('')        // '' | '0' | '1'
const minSunlight = ref('')   // '' | '1'..'5'

const fetchProperties = async () => {
  loading.value = true
  error.value = ''
  try {
    const params = {}
    if (corner.value !== '') params.corner = corner.value
    if (minSunlight.value !== '') params.min_sunlight = minSunlight.value

    const res = await axios.get('/api/properties', { params })
    properties.value = res.data?.data ?? []
  } catch (e) {
    error.value = '取得に失敗しました（API/Proxy設定を確認）'
    properties.value = []
  } finally {
    loading.value = false
  }
}

onMounted(fetchProperties)
</script>

<template>
  <div style="max-width: 900px; margin: 24px auto; font-family: sans-serif;">
    <h1>Property List</h1>

    <div style="display:flex; gap:12px; align-items:center; margin: 12px 0 20px;">
      <label>
        corner:
        <select v-model="corner" @change="fetchProperties">
          <option value="">(all)</option>
          <option value="1">1</option>
          <option value="0">0</option>
        </select>
      </label>

      <label>
        min_sunlight:
        <select v-model="minSunlight" @change="fetchProperties">
          <option value="">(all)</option>
          <option v-for="n in 5" :key="n" :value="String(n)">{{ n }}</option>
        </select>
      </label>

      <button @click="fetchProperties">Reload</button>
    </div>

    <p v-if="loading">loading...</p>
    <p v-if="error" style="color: #b00020;">{{ error }}</p>

    <table v-if="!loading" border="1" cellpadding="8" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>ID</th>
          <th>name</th>
          <th>corner</th>
          <th>sunlight_score</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="p in properties" :key="p.id">
          <td>{{ p.id }}</td>
          <td>{{ p.name }}</td>
          <td>{{ p.is_corner }}</td>
          <td>{{ p.sunlight_score }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

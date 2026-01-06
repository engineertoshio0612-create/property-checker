<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const properties = ref([]);
const loading = ref(false);
const error = ref("");

const meta = ref(null);
const message = ref("");

// pagination
const page = ref(1);

// filters
const corner = ref(""); // '' | '0' | '1'
const minSunlight = ref(""); // '' | '1'..'5'

const fetchProperties = async (pageNum = page.value) => {
    loading.value = true;
    error.value = "";
    try {
        const params = { page: pageNum };
        if (corner.value !== "") params.corner = corner.value;
        if (minSunlight.value !== "") params.min_sunlight = minSunlight.value;

        const res = await axios.get("/api/properties", { params });

        properties.value = res.data?.data ?? [];
        meta.value = res.data?.meta ?? null;
        message.value = res.data?.message ?? "";

        // サーバの結果を正として page を同期
        page.value = meta.value?.current_page ?? pageNum;
    } catch (e) {
        error.value = "取得に失敗しました（API/Proxy設定を確認）";
        properties.value = [];
        meta.value = null;
        message.value = "";
    } finally {
        loading.value = false;
    }
};

// フィルタ変更時は1ページ目に戻す
const onFilterChange = () => {
    page.value = 1;
    fetchProperties(1);
};

const goPrev = () => {
    if (!meta.value) return;
    if (page.value <= 1) return;
    fetchProperties(page.value - 1);
};

const goNext = () => {
    if (!meta.value) return;
    if (page.value >= meta.value.last_page) return;
    fetchProperties(page.value + 1);
};

onMounted(() => fetchProperties(1));
</script>

<template>
    <div style="max-width: 900px; margin: 24px auto; font-family: sans-serif">
        <h1>Property List</h1>

        <div
            style="
                display: flex;
                gap: 12px;
                align-items: center;
                margin: 12px 0 20px;
            "
        >
            <label>
                corner:
                <select v-model="corner" @change="onFilterChange">
                    <option value="">(all)</option>
                    <option value="1">1</option>
                    <option value="0">0</option>
                </select>
            </label>

            <label>
                min_sunlight:
                <select v-model="minSunlight" @change="onFilterChange">
                    <option value="">(all)</option>
                    <option v-for="n in 5" :key="n" :value="String(n)">
                        {{ n }}
                    </option>
                </select>
            </label>

            <button @click="fetchProperties(page)">Reload</button>
        </div>

        <p v-if="loading">loading...</p>
        <p v-if="error" style="color: #b00020">{{ error }}</p>

        <p v-if="!loading && message" style="margin: 0 0 8px">{{ message }}</p>

        <div
            v-if="!loading && meta"
            style="
                margin: 8px 0 16px;
                opacity: 0.85;
                display: flex;
                gap: 12px;
                align-items: center;
            "
        >
            <span>
                page: {{ meta.current_page }} / {{ meta.last_page }} / total:
                {{ meta.total }} / per_page: {{ meta.per_page }}
            </span>

            <button @click="goPrev" :disabled="page <= 1">Prev</button>
            <button @click="goNext" :disabled="page >= meta.last_page">
                Next
            </button>
        </div>

        <table
            v-if="!loading"
            border="1"
            cellpadding="8"
            cellspacing="0"
            width="100%"
        >
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

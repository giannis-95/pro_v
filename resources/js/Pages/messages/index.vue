<template>
    <AuthenticatedLayout>
        <div class="container">
            <div class="row text-center mt-4 mb-4">
                <div class="col">
                    <h4>Μηνύματα</h4>
                </div>
            </div>
            <hr>
            <div style="overflow-y: scroll;">
                <div v-for="msg in messages" :key="msg.id" class="mt-2">
                    <span>{{ msg.user.name }} : </span>
                    {{ msg.text }}
                </div>
            </div>
            <div class="row mt-5">
                <textarea v-model="text" @keydown.enter.exact.prevent="sendMessage" rows="4" class="form-control" placeholder="Στείλτε μηνύμα...."></textarea>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { ref, onMounted } from 'vue'
import axios from 'axios'

const props = defineProps({
    messages: Array
})

const messages = ref(props.messages)
const text = ref('')

onMounted(() => {
    window.Echo.channel('chat').listen('MessageSent', (event) => {
        messages.value.push(event.message)
    })
})

const sendMessage = async () => {
    if(!text.value.trim()) return

    const response = await axios.post('/messages', {
        text: text.value
    })

    messages.value.push(response.data)
    text.value = ''
}

</script>

<template>
    <div class="min-h-full">
        <Navbar />
        <router-view></router-view>
        <Notification />
    </div>
</template>

<script setup>
import Notification from "./Notification.vue";
import Navbar from "./Navbar.vue";
</script>

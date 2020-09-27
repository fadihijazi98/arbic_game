<template>
    <div>
        <h1><Disp class=""></Disp></h1>
        <countdown :end-time="time">
        </countdown>
    </div>
</template>

<script>
export default {
    name: "TimerComponent.vue",
    data() {
        return {
            time: 30*1000
        }
    },
    components: {
        countdown
    }
}
</script>

<style scoped>

</style>

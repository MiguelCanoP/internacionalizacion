<template>
    <v-row class="mt-1">
        <v-col
            v-for="item in count? count:6"
            :key="item"
            cols="12"
            md="4"
        >
            <v-skeleton-loader
                class="mx-auto"
                max-width="300"
                type="card"
            ></v-skeleton-loader>
        </v-col>
    </v-row>

</template>

<script>
export default {
    name: "Loading",
    props: {
        count: Number
    }
}
</script>

<style scoped>

</style>
